<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Creating admin user...');

        User::factory()->create([
            'name'     => 'Admin',
            'login'    => 'admin',
            'brand_id' => 1,
            'email'    => 'admin@fastcontrol.com',
            'password' => Hash::make('admin'),
            'store_id' => 1,
            'active'   => 1,
        ]);
    }
}
