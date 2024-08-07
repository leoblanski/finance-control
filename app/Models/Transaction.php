<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use App\Traits\BelongsToUser;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
            Select::make('user_id')
                ->label('Owner')
                ->hint('O responsável pela transação')
                ->relationship('user', 'name')
                ->nullable(),
            Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),
            Select::make('payment_type_id')
                ->relationship('paymentType', 'name')
                ->required(),
            Textarea::make('description')
                ->columnSpanFull(),
            Money::make('value')
                ->required(),
            Radio::make('type')
                ->options([
                    'in' => 'In',
                    'out' => 'Out'
                ])
                ->default('out'),
            DatePicker::make('date')
                ->default(now())
                ->required()
        ];
    }

    public static function getColumns(): array
    {
        return [
            TextColumn::make('user.name')
                ->searchable()
                ->default('Sem responsável')
                ->label('Owner'),
            TextColumn::make('category.name')
                ->searchable()
                ->label('Category'),
            TextColumn::make('paymentType.name')
                ->searchable()
                ->label('Payment Type'),
            TextColumn::make('description')
                ->searchable()
                ->label('Description'),
            BadgeColumn::make('value')
                ->searchable()
                ->label('Value')
                ->icon(function (Transaction $transaction) {
                    return $transaction->type == 'out' ? 'heroicon-o-arrow-down' : 'heroicon-o-arrow-up';
                })
                ->color(function (Transaction $transaction) {
                    return $transaction->type == 'out' ? 'danger' : 'success';
                })
                ->formatStateUsing(function (Transaction $transaction) {
                    return 'R$ ' . number_format($transaction->value, 2, ',', '.');
                })
                ->summarize(Sum::make('value')->label('Balance')),
            TextColumn::make('date')
                ->date('d/m/Y')
                ->searchable()
                ->label('Date')
        ];
    }
}
