<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory;
    use HasRoles;
    // use HasName;
    use BelongsToTeam;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'active',
        'remember_token',
        'email',
        'email_verified_at',
        'password',
        'team_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'email_verified_at' => 'timestamp',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getFilamentName(): string
    {
        return "test";
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->label(__('labels.name'))
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->unique()
                ->email()
                ->required()
                ->maxLength(255),
            TextInput::make('username')
                ->unique()
                ->label(__('labels.username'))
                ->required()
                ->maxLength(255),
            TextInput::make('password')
                ->label(__('labels.password'))
                ->password()
                ->required()
                ->maxLength(255),
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
                ->searchable(),
            TextColumn::make('email')
                ->searchable(),
            TextColumn::make('username')
                ->label(__('labels.username'))
                ->searchable(),
            IconColumn::make('active')
                ->label(__('labels.active'))
                ->boolean(),
            TextColumn::make('last_login_at')
                ->label(__('labels.last_login'))
                ->dateTime()
                ->sortable(),
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
}
