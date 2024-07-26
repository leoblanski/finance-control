<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TeamScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (session()->has('team_id')) {
            $teamId = session()->get('team_id');
            $table = $model->getTable(); // Get the table name of the model

            $builder->where(function ($query) use ($teamId, $table) {
                $query->where("{$table}.team_id", $teamId)
                    ->orWhereNull("{$table}.team_id"); // Assuming null team_id is for default categories
            });
        }
    }
}
