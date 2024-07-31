<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Team;
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
        $this->command->info('Creating user...');

        Team::factory()->create([
            'name' => 'Team Blanski',
        ]);

        User::factory()->create([
            'team_id' => 1,
            'name' => 'Camila',
            'email' => 'fga.camilaaquino@gmail.com',
            'username' => 'camiladeaquino',
            'password' => Hash::make('123123'),
        ]);
         User::factory()->create([
            'team_id' => 1,
            'name' => 'Leonardo',
            'email' => 'leo_blanski@hotmail.com',
            'username' => 'leoblanski',
            'password' => Hash::make('123123'),
        ]);
    }
}
