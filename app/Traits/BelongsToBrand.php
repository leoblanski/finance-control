<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeam
{
    protected static function bootBelongsToBrand()
    {
        static::addGlobalScope(new BrandScope);

        static::creating(function ($model) {
            if (session()->has('brand_id')) {
                $model->brand_id = session()->get('brand_id');
            }
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
