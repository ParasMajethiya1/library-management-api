<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create the admin user
        $admin = User::create([
            'name' => 'Paras Admin',
            'email' => 'parasmajethiya1@gmail.com',
            'password' => Hash::make('password123#'),
        ]);

        // Create the 'admin' role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Assign the 'admin' role to the user
        $admin->assignRole($adminRole);

        $this->command->info('Admin user created successfully with the "admin" role.');
    }
}
