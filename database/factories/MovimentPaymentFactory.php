<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PaymentType;
use App\Models\Brand;
use App\Models\Moviment;
use App\Models\MovimentPayment;

class MovimentPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovimentPayment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'payment_type_id' => PaymentType::factory(),
            'moviment_id' => Moviment::factory(),
            'amount' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
