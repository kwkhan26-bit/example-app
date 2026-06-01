<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Passenger;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'sanctum']);
        $userRole  = Role::create(['name' => 'user',  'guard_name' => 'sanctum']);

        // Create permissions
        Permission::create(['name' => 'create', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'edit',   'guard_name' => 'sanctum']);
        Permission::create(['name' => 'delete', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'view',   'guard_name' => 'sanctum']);

        // Give permissions to roles
        $adminRole->givePermissionTo(['create', 'edit', 'delete', 'view']);
        $userRole->givePermissionTo(['view']);

        // Assign roles to first 2 passengers in DB
        $passenger1 = Passenger::first();
        $passenger2 = Passenger::skip(1)->first();

        $passenger1->assignRole('admin');
        $passenger2->assignRole('user');
    }
}