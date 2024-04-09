<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Brand;
use App\Models\Store;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'name' => $this->faker->name(),
            'cnpj' => $this->faker->word(),
            'user_id' => User::factory(),
            'responsible_name' => $this->faker->word(),
            'mobile' => $this->faker->word(),
            'active' => $this->faker->boolean(),
            'charge_date' => $this->faker->dateTime(),
        ];
    }
}
