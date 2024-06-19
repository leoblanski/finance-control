<?php

namespace Database\Seeders;

use App\Models\OperationType;
use Illuminate\Database\Seeder;

class OperationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Creating operation types...');

        OperationType::factory()->create([
            'name' => 'Entrada de Mercadoria',
        ]);

        OperationType::factory()->create([
            'name' => 'Venda de Mercadoria',
            'type' => 'S',
        ]);

        OperationType::factory()->create([
            'name' => 'Entrada de Bonificação',
        ]);
    }
}
