<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Brand;
use App\Models\SaleType;

class SaleTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SaleType::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'name' => $this->faker->name(),
            'active' => $this->faker->boolean(),
            'user_id' => User::factory(),
        ];
    }
}
