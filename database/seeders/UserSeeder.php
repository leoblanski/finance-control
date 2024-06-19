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
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('123123'),
        ])->assignRole(Role::findByName(Role::ADMIN_ROLE));

        $this->command->info('Creating manager user...');

        User::factory()->create([
            'brand_id' => 1,
            'name' => 'Manager',
            'email' => 'manager@manager.com',
            'username' => 'manager',
            'password' => Hash::make('123123'),
        ])->assignRole(Role::findByName(Role::MANAGER_ROLE));

        $this->command->info('Creating team member user...');

        User::factory()->create([
            'brand_id' => 1,
            'name' => 'Team',
            'email' => 'team@team.com',
            'username' => 'team',
            'password' => Hash::make('123123'),
        ])->assignRole(Role::findByName(Role::TEAM_MEMBER_ROLE));
    }
}
