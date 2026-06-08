<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $userRole  = Role::create(['name' => 'user',  'guard_name' => 'web']);

        // Create permissions
        Permission::create(['name' => 'create', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit',   'guard_name' => 'web']);
        Permission::create(['name' => 'delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'view',   'guard_name' => 'web']);

        // Give permissions to roles
        $adminRole->givePermissionTo(['create', 'edit', 'delete', 'view']);
        $userRole->givePermissionTo(['view']);

        // Create admin user
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password'),
        ]);

        // Create normal user
        $user = User::create([
            'name'     => 'Normal User',
            'email'    => 'user@test.com',
            'password' => Hash::make('password'),
        ]);

        // Assign roles
        $admin->assignRole('admin');
        $user->assignRole('user');
    }
}