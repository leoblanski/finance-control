<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Gasolina',
                'description' => 'Despesas com transporte',
                'active' => true,
            ],
            [
                'name' => 'Alimentação',
                'description' => 'Despesas com alimentação',
                'active' => true,
            ],
            [
                'name' => 'iFood',
                'description' => 'Despesas com alimentação',
                'active' => true,
            ],
            [
                'name' => 'Mercado',
                'description' => 'Despesas com mercado',
                'active' => true,
            ],
            [
                'name' => 'Farmácia',
                'description' => 'Despesas com farmácia',
                'active' => true,
            ],
            [
                'name' => 'Saúde',
                'description' => 'Despesas com saúde',
                'active' => true,
            ],
            [
                'name' => 'Educação',
                'description' => 'Despesas com educação',
                'active' => true,
            ],
            [
                'name' => 'Lazer',
                'description' => 'Despesas com lazer',
                'active' => true,
            ],
            [
                'name' => 'Outros',
                'description' => 'Despesas diversas',
                'active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::factory()->create($category);
        }
    }
}
