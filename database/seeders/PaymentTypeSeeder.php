<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Creating payment types...');

        PaymentType::factory()->create([
            'name' => 'Dinheiro',
        ]);
        
        PaymentType::factory()->create([
            'name' => 'Débito',
        ]);

        PaymentType::factory()->create([
            'name' => 'Crédito',
        ]);
    }
}
