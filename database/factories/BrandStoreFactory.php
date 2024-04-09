<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\BrandStore;
use App\Models\Store;

class BrandStoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BrandStore::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'store_id' => Store::factory(),
            'brand_id' => Brand::factory(),
        ];
    }
}
