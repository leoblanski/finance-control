<?php

namespace App\Models;

use App\Traits\BelongsToBrand;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
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
        'description',
        'reference',
        'user_id',
        'product_brand_id',
        'product_line_id',
        'product_category_id',
        'codebar',
        'active',
        'cost_price',
        'sale_price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'brand_id' => 'integer',
        'user_id' => 'integer',
        'product_brand_id' => 'integer',
        'product_line_id' => 'integer',
        'product_category_id' => 'integer',
        'active' => 'boolean',
        'cost_price' => 'decimal',
        'sale_price' => 'decimal',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productBrand(): BelongsTo
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function productLine(): BelongsTo
    {
        return $this->belongsTo(ProductLine::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
