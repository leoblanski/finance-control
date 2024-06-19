<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'website',
        'logo',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'primary_color',
        'secondary_color',
        'active',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
        'user_id' => 'integer',
        'primary_color' => 'string',
        'secondary_color' => 'string',
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
