<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
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
                ->maxLength(255),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            TextInput::make('username')
                ->maxLength(255),
            TextInput::make('password')
                ->password()
                ->required()
                ->maxLength(255),
            Toggle::make('active')
                ->default(true)
                ->required(),
        ];
    }

    public static function getColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('email')
                ->searchable(),
            TextColumn::make('username')
                ->searchable(),
            IconColumn::make('active')
                ->boolean(),
            TextColumn::make('last_login_at')
                ->dateTime()
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
