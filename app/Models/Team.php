<?php

namespace App\Models;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'primary_color',
        'secondary_color',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function getForm()
    {
        return [
            Grid::make()->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->columnSpanFull()
                    ->required(),
                ColorPicker::make('primary_color')
                    ->label(__('labels.primary_color'))
                    ->columnSpan(1)
                    ->default('#000000'),
                ColorPicker::make('secondary_color')
                    ->label(__('labels.secondary_color'))
                    ->columnSpan(1)
                    ->default('#000000'),
            ])->columns(2),
        ];
    }
}
