<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\relationships;

class RelationshipsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Relationships::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'belongsTo' => $this->faker->word(),
        ];
    }
}
