<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Brand;
use App\Models\Payment;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'name' => $this->faker->name(),
            'user_id' => User::factory(),
            'active' => $this->faker->boolean(),
            'payment_type_id' => ::factory(),
        ];
    }
}
