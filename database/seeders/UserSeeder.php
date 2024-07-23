<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
            'brand_id' => 1,
            'name' => 'User',
            'email' => 'team@team.com',
            'username' => 'user',
            'password' => Hash::make('123123'),
        ]);
    }
}
