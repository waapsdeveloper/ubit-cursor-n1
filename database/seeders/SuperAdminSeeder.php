<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the super admin role (created by RolePermissionSeeder)
        $role = Role::where('name', 'super-admin')->first();

        // Create the super admin user
        $user = User::firstOrCreate(
            ['email' => 'superadmin@email.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123$'),
                'role' => 'admin',
            ]
        );

        // Assign the super admin role to the user
        $user->assignRole($role);
    }
}
