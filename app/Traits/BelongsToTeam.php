<?php

namespace App\Traits;

use App\Models\Team;
use App\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeam
{
    protected static function bootBelongsToTeam()
    {
        static::addGlobalScope(new TeamScope);

        static::creating(function ($model) {
            if (session()->has('team_id')) {
                $model->team_id = session()->get('team_id');
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
