<?php

namespace App\Filament\Resources\RelationManagers;

use App\Models\Role;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UsersRelationManager extends RelationManager
{
    protected static ?string $title = '';

    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema(User::getForm());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns(User::getColumns())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->fillForm(function () {
                        return [
                            'team_id' => auth()->user()->team_id,
                        ];
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(function (Builder $query) {
                // if (!auth()->user()->hasRole(Role::ADMIN_ROLE)) {
                //     $query->whereHas('roles', function ($q) {
                //         $q->where('name', '!=', Role::ADMIN_ROLE);
                //     });
                // }
            });
    }
}
