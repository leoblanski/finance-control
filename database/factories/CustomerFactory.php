<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\, User;
use App\Models\Brand;
use App\Models\Customer;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'name' => $this->faker->name(),
            'cpf' => $this->faker->word(),
            'birthday' => $this->faker->dateTime(),
            'mobile' => $this->faker->word(),
            'cep' => $this->faker->word(),
            'state' => $this->faker->word(),
            'city' => $this->faker->city(),
            'neighborhood' => $this->faker->word(),
            'active' => $this->faker->boolean(),
            'complement' => $this->faker->word(),
            'user_id' => User::factory(),
        ];
    }
}
