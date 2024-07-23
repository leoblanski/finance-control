<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Transaction;
use App\Models\User;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => ::factory(),
            'payment_type_id' => ::factory(),
            'description' => $this->faker->text(),
            'value' => $this->faker->randomFloat(0, 0, 9999999999.),
            'date' => $this->faker->date(),
        ];
    }
}
