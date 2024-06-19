<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\DependentType;
use App\Models\Brand;
use App\Models\CustomerDependent;

class CustomerDependentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerDependent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => 1,
            'name' => $this->faker->name(),
            'user_id' => User::factory(),
            'dependent_type_id' => DependentType::factory(),
        ];
    }
}
