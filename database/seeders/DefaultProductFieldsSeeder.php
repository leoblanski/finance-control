<?php

namespace Database\Seeders;

use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductLine;
use Illuminate\Database\Seeder;

class DefaultProductFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Creating default brand, line and category...');

        ProductBrand::factory()->create([
            'name' => 'GERAL',
        ]);
        
        ProductLine::factory()->create([
            'name' => 'GERAL',
        ]);

        ProductCategory::factory()->create([
            'name' => 'GERAL',
        ]);
    }
}
