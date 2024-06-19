<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Moviment;
use App\Models\OperationType;
use App\Models\Store;
use App\Models\User;

class MovimentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Moviment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => 1,
            'user_id' => User::factory(),
            'store_id' => Store::factory(),
            'customer_id' => Customer::factory(),
            'employee_id' => Employee::factory(),
            'status' => $this->faker->randomNumber(),
            'type' => $this->faker->word(),
            'operation_type_id' => OperationType::factory(),
            'amount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'discount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'obs' => $this->faker->word(),
        ];
    }
}
