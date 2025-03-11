<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $createBookPermission = Permission::create(['name' => 'create books']);
        $editBookPermission = Permission::create(['name' => 'edit books']);
        $deleteBookPermission = Permission::create(['name' => 'delete books']);
        $borrowBookPermission = Permission::create(['name' => 'borrow books']);
        $returnBookPermission = Permission::create(['name' => 'return books']);

        // Assign permissions to roles
        $adminRole->givePermissionTo([$createBookPermission, $editBookPermission, $deleteBookPermission]);
        $userRole->givePermissionTo([$borrowBookPermission, $returnBookPermission]);
    }
}
