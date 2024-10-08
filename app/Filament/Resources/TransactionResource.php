<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Category;
use App\Models\PaymentType;
use App\Models\Transaction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;


    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-end-on-rectangle';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('labels.transactions');
    }

    public static function getModelLabel(): string
    {
        return __('labels.transactions');
    }

    public static function getModelLabelPlural(): string
    {
        return __('labels.transactions');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('labels.finances');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Transaction::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(Transaction::getColumns())
            ->filters([
                // Filter::make('created_at')
                //     ->form([
                //         DatePicker::make('start')
                //             ->label(__('labels.start'))
                //             ->placeholder(__('labels.start')),
                //         DatePicker::make('final')
                //             ->label(__('labels.final'))
                //             ->placeholder(__('labels.final')),
                //     ])
                //     ->query(function ($query, array $value) {
                //         $query->whereBetween('created_at', $value);
                //     }),
                SelectFilter::make('type')
                    ->label(__('labels.type'))
                    ->options([
                        'in' => __('labels.in'),
                        'out' => __('labels.out'),
                    ]),
                SelectFilter::make('payment_type_id')
                    ->label(__('labels.payment_type'))
                    ->options(fn() => PaymentType::pluck('name', 'id')->toArray()),
                SelectFilter::make('category_id')
                    ->searchable()
                    ->label(__('labels.categories'))
                    ->multiple()
                    ->options(fn() => Category::pluck('name', 'id')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()
                    ->mutateFormDataUsing(function (array $data): array {
                        $type = $data['type'] ?? null;

                        if ($type == 'out') {
                            $data['value'] = -$data['value'];
                        }

                        return $data;
                    })
                    ->after(function ($record, $data) {

                        dd(1);
                        if ($data['type'] == 'out') {
                            if ($record->payment_type_id == PaymentType::TYPE_CREDIT_ID) {
                                $pricePerInstallment = $record->value / $record->installments;

                                dd($pricePerInstallment, $record->installments);

                                // for ($installments; $installments > 0; $installments--) {

                                //     $record->replicate()->fill([
                                //         'value' => -$record->per_installment,
                                //         'installments' => 0,
                                //     ])->save();
                                // }

                            }
                        }

                        $record->save();
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTransactions::route('/'),
        ];
    }
}
