<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BrandSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            OperationTypeSeeder::class,
            PaymentTypeSeeder::class,
            DefaultProductFieldsSeeder::class,
            StoreSeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
