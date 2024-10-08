<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): ?string
    {
        return __('labels.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('labels.users');
    }

    public static function getModelLabel(): string
    {
        return __('labels.user');
    }

    public static function getModelLabelPlural(): string
    {
        return __('labels.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(User::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(User::getColumns())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->mutateFormDataUsing(function (array $data): array {
                    $data['password'] = bcrypt($data['password']);

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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
