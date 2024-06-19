<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Store;
use App\Models\Brand;
use App\Models\Employee;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => 1,
            'name' => $this->faker->name(),
            'store_id' => Store::factory(),
            'active' => $this->faker->boolean(),
            'user_id' => User::factory(),
        ];
    }
}
