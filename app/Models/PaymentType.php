<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
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
                ->label(__('labels.name'))
                ->required(),
            TextInput::make('description')
                ->label(__('labels.description')),
            Toggle::make('active')
                ->label(__('labels.active'))
                ->default(true)
                ->required(),
        ];
    }
    public static function getColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label(__('labels.name'))
                ->sortable()
                ->searchable(),
            IconColumn::make('active')
                ->label(__('labels.active'))
                ->boolean(),
            TextColumn::make('created_at')
                ->label(__('labels.created_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->label(__('labels.updated_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
