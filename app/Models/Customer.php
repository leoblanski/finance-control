<?php

namespace App\Models;

use App\Traits\BelongsToBrand;
use App\Traits\BelongsToUser;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    use BelongsToBrand;
    use BelongsToUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'name',
        'cpf',
        'birthday',
        'mobile',
        'cep',
        'state',
        'city',
        'neighborhood',
        'active',
        'complement',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'brand_id' => 'integer',
        'birthday' => 'timestamp',
        'active' => 'boolean',
        'user_id' => 'integer',
    ];

    public static function getForm(): array
    {
        return [
            Select::make('brand_id')
                ->relationship('brand', 'name'),
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('cpf')
                ->maxLength(255),
            DateTimePicker::make('birthday'),
            TextInput::make('mobile')
                ->maxLength(255),
            TextInput::make('cep')
                ->maxLength(255),
            TextInput::make('state')
                ->maxLength(255),
            TextInput::make('city')
                ->maxLength(255),
            TextInput::make('neighborhood')
                ->maxLength(255),
            Toggle::make('active')
                ->required(),
            TextInput::make('complement')
                ->maxLength(255),
            Select::make('user_id')
                ->relationship('user', 'name'),
        ];
    }

    public static function getColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('brand.name')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('cpf')
                ->searchable(),
            Tables\Columns\TextColumn::make('birthday')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('mobile')
                ->searchable(),
            Tables\Columns\TextColumn::make('cep')
                ->searchable(),
            Tables\Columns\TextColumn::make('state')
                ->searchable(),
            Tables\Columns\TextColumn::make('city')
                ->searchable(),
            Tables\Columns\TextColumn::make('neighborhood')
                ->searchable(),
            Tables\Columns\IconColumn::make('active')
                ->boolean(),
            Tables\Columns\TextColumn::make('complement')
                ->searchable(),
            Tables\Columns\TextColumn::make('user.name')
                ->numeric()
                ->sortable(),
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customerDependents(): HasMany
    {
        return $this->hasMany(CustomerDependent::class);
    }
}
