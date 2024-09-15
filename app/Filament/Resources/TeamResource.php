<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RelationManagers\UsersRelationManager;
use App\Filament\Resources\TeamResource\Pages;
use App\Models\Team;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 5;

    public static function getNavigationLabel(): string
    {
        return __('labels.team');
    }

    public static function getModelLabel(): string
    {
        return __('labels.team');
    }

    public static function getModelLabelPlural(): string
    {
        return __('labels.teams');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('labels.settings');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('id', Session::get('team_id'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Team::getForm())->columns(2);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

    public static function getSlug(): string
    {
        return 'team';
    }

    public static function getPages(): array
    {
        return [
            'edit' => Pages\EditTeam::route('/{record}/edit'),
            'index' => Pages\EditTeam::route("/settings/edit"),
        ];
    }
}
