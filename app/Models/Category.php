<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Leandrocfe\FilamentPtbrFormFields\Money;

class Category extends Model
{
    use HasFactory;
    use BelongsToTeam;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'active',
        'limit',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->label('Name')
                ->required(),
            TextInput::make('description')
                ->label('Description'),
            Money::make('limit')
                ->label('Mensal Limit')
                ->columnSpanFull(),
            Toggle::make('active')
                ->label('Active')
                ->default(true)
                ->required(),
        ];
    }

    public static function getColumns(): array
    {
        return [
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            TextColumn::make('description')
                ->sortable()
                ->searchable(),
            TextColumn::make('limit')
                ->label('Limite Mensal')
                ->formatStateUsing(fn (Category $category) => $category->limit ? 'R$ ' . number_format($category->limit, 2, ',', '.') : 'Sem limite')
                ->sortable()
                ->searchable(),
            ToggleColumn::make('active')
                ->sortable()
                ->searchable(),
        ];
    }
}
