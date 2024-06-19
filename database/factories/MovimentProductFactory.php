<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Moviment;
use App\Models\Brand;
use App\Models\MovimentProduct;

class MovimentProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovimentProduct::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => 1,
            'product_id' => Product::factory(),
            'moviment_id' => Moviment::factory(),
            'unit_price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'qty' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
