<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Category;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                SelectFilter::make('type')
                    ->options([
                        'in' => 'Entrada',
                        'out' => 'Saída',
                    ]),
                SelectFilter::make('category_id')
                    ->multiple()
                    ->options(fn () => Category::pluck('name', 'id')->toArray()),

            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()
                    ->mutateFormDataUsing(function (array $data): array {
                        $type = $data['type'] ?? null;

                        if ($type == 'out') {
                            $data['value'] = -$data['value'];
                        }

                        return $data;
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
