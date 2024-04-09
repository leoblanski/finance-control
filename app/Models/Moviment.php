<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Moviment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'user_id',
        'store_id',
        'customer_id',
        'employee_id',
        'status',
        'type',
        'operation_type_id',
        'amount',
        'discount',
        'obs',
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
        'store_id' => 'integer',
        'customer_id' => 'integer',
        'employee_id' => 'integer',
        'status' => 'integer',
        'operation_type_id' => 'integer',
        'amount' => 'decimal',
        'discount' => 'decimal',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function operationType(): BelongsTo
    {
        return $this->belongsTo(OperationType::class);
    }
}
