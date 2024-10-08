<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Leandrocfe\FilamentPtbrFormFields\Money;

class Transaction extends Model
{
    use HasFactory;
    use BelongsToTeam;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'payment_type_id',
        'description',
        'value',
        'type',
        'date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'category_id' => 'integer',
        'payment_type_id' => 'integer',
        // 'value' => 'decimal',
        'date' => 'date',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public static function getForm(): array
    {
        return [
            Grid::make([
                'default' => '1',
                'sm' => '1',
                'md' => '2',
            ])->schema([
                Select::make('user_id')
                    ->label(__('labels.owner'))
                    ->relationship('user', 'name')
                    ->nullable(),
                Select::make('category_id')
                    ->default('9') // Other
                    ->searchable()
                    ->label(__('labels.category'))
                    ->preload()
                    ->relationship('category', 'name')
                    ->required(),
            ]),
            Grid::make([
                'default' => '1',
                'sm' => '1',
                'md' => '2',
            ])->schema([
                Money::make('value')
                    ->label(__('labels.value'))
                    // ->live()
                    ->dehydrateMask(true)
                    ->default('100,00')
                    ->required(),
                Select::make('payment_type_id')
                    ->live()
                    ->searchable()
                    ->preload()
                    ->label(__('labels.payment_type'))
                    ->relationship('paymentType', 'name')
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        dd($get('value'));
                        if ($get('payment_type_id') == PaymentType::TYPE_CREDIT_ID) {
                            $set('installments', '1');
                            $set('per_installment', $parsedValue); // Use parsed value
                            return;
                        }
                    })
                    ->required(),
            ]),
            Grid::make([
                'default' => '1',
                'sm' => '1',
                'md' => '2',
            ])->schema([
                Select::make('installments')
                    ->label(__('labels.installments'))
                    ->options([
                        '1' => '1x',
                        '2' => '2x',
                        '3' => '3x',
                        '4' => '4x',
                        '5' => '5x',
                        '6' => '6x',
                        '7' => '7x',
                        '8' => '8x',
                        '9' => '9x',
                        '10' => '10x',
                        '11' => '11x',
                        '12' => '12x',
                    ])
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $parsedValue = parseMoneyString($get('value'));
                        $installments = intval($get('installments'));

                        if ($installments > 0) {
                            $set('per_installment', $parsedValue / $installments); // Use parsed value
                        }
                    })
                    ->default('1')
                    ->required(),
                Money::make('per_installment')
                    ->disabled()
                    ->label(__('labels.price_per_installment'))
            ])->hidden(function (Get $get) {
                return $get('payment_type_id') != PaymentType::TYPE_CREDIT_ID;
            }),
            DatePicker::make('date')
                ->label(__('labels.date'))
                ->default(now())
                ->required(),
            Textarea::make('description')
                ->label(__('labels.description'))
                ->columnSpanFull(),
            Radio::make('type')
                ->label(__('labels.type'))
                ->options([
                    'in' => __('labels.in'),
                    'out' => __('labels.out'),
                ])
                ->default('out'),
        ];
    }


    public static function getColumns(): array
    {
        return [
            TextColumn::make('user.name')
                ->searchable()
                ->default(__('labels.not_informed'))
                ->label(__('labels.owner')),
            TextColumn::make('category.name')
                ->searchable()
                ->label(__('labels.category')),
            TextColumn::make('paymentType.name')
                ->searchable()
                ->label(__('labels.payment_type')),
            TextColumn::make('description')
                ->searchable()
                ->label(__('labels.description')),
            BadgeColumn::make('value')
                ->searchable()
                ->label(__('labels.total'))
                ->sortable()
                ->icon(function (Transaction $transaction) {
                    return $transaction->type == 'out' ? 'heroicon-o-arrow-down' : 'heroicon-o-arrow-up';
                })
                ->color(function (Transaction $transaction) {
                    return $transaction->type == 'out' ? 'danger' : 'success';
                })
                ->formatStateUsing(function (Transaction $transaction) {
                    return 'R$ ' . number_format($transaction->value, 2, ',', '.');
                })
                ->summarize(Sum::make('value')->label(__('labels.total'))),
            TextColumn::make('date')
                ->date('d/m/Y')
                ->sortable()
                ->searchable()
                ->label(__('labels.date')),
        ];
    }
}
