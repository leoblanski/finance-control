<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductBalance;

class ProductBalanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductBalance::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => 1,
            'product_id' => Product::factory(),
            'qty' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
