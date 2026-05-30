<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view items', 'create items', 'edit items', 'delete items',
            'view suppliers', 'create suppliers', 'edit suppliers', 'delete suppliers',
            'view transactions', 'create transactions',
            'view roles', 'manage roles',
            'view departments', 'create departments', 'edit departments', 'delete departments',
            'view settings', 'manage settings'
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Create Roles and Assign Permissions
        $adminRole = Role::findOrCreate('Admin');
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::findOrCreate('Manager');
        $managerRole->givePermissionTo([
            'view users',
            'view categories', 'create categories', 'edit categories',
            'view items', 'create items', 'edit items',
            'view suppliers', 'create suppliers', 'edit suppliers',
            'view transactions', 'create transactions',
            'view departments', 'create departments', 'edit departments'
        ]);

        $staffRole = Role::findOrCreate('Staff');
        $staffRole->givePermissionTo([
            'view categories',
            'view items',
            'view suppliers',
            'view transactions', 'create transactions'
        ]);

        $user = User::factory()->create([
            'name' => 'Lara Wire',
            'username' => 'larawire',
            'email' => 'larawire@dev.com',
            'password' => bcrypt('larawire@123'),
        ]);

        // Assign Admin role
        $user->assignRole($adminRole);
    }
}

