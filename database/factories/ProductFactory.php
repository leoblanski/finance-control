<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductLine;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => 1,
            'name' => $this->faker->title(),
            'description' => $this->faker->text(),
            'reference' => $this->faker->word(),
            'product_brand_id' => ProductBrand::factory(),
            'product_line_id' => ProductLine::factory(),
            'product_category_id' => ProductCategory::factory(),
            'codebar' => $this->faker->randomDigitNotZero(),
            'active' => $this->faker->boolean(),
            'cost_price' => $this->faker->randomFloat(2, 0, 999),
            'sale_price' => $this->faker->randomFloat(2, 0, 999),
            'user_id' => User::factory(),
        ];
    }
}
