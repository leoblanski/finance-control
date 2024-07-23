<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            [
                'name' => 'Dinheiro',
            ],
            [
                'name' => 'Cartão de Crédito',
            ],
            [
                'name' => 'Cartão de Débito',
            ],
            [
                'name' => 'Transferência Bancária',
            ],
            [
                'name' => 'Pix',
            ],
        ];

        foreach ($payments as $payment) {
            PaymentType::create($payment);
        }
    }
}
