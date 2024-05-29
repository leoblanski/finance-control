<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductBrand;
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
            'brand_id' => Brand::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'reference' => $this->faker->word(),
            'user_id' => User::factory(),
            'product_brand_id' => ProductBrand::factory(),
            'product_line_id' => ProductLine::factory(),
            'product_category_id' => ProductCategory::factory(),
            'codebar' => $this->faker->word(),
            'active' => $this->faker->boolean(),
            'cost_price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'sale_price' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
