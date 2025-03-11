<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class NormalUserSeeder extends Seeder
{
    public function run()
    {
        // Create the normal user
        $user = User::create([
            'name' => 'Paras Normal',
            'email' => 'parasmajethiya2020@gmail.com',
            'password' => Hash::make('password123#'),
        ]);

        // Create the 'user' role if it doesn't exist
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign the 'user' role to the user
        $user->assignRole($userRole);

        $this->command->info('Normal user created successfully with the "user" role.');
    }
}