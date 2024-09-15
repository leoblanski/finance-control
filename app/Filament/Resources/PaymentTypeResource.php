<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentTypeResource\Pages;
use App\Models\PaymentType;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentTypeResource extends Resource
{
    protected static ?string $model = PaymentType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('labels.payment_types');
    }

    public static function getModelLabel(): string
    {
        return __('labels.payment_types');
    }

    public static function getModelLabelPlural(): string
    {
        return __('labels.payment_types');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('labels.parameters');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema(PaymentType::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(PaymentType::getColumns())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->disabled(function ($record) {
                        return !$record->team_id;
                    }),
                Tables\Actions\DeleteAction::make()
                    ->disabled(function ($record) {
                        return !$record->team_id;
                    }),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePaymentTypes::route('/'),
        ];
    }
}
