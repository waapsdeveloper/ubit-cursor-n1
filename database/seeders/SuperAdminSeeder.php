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
        // Create or get the super admin role
        $role = Role::firstOrCreate(['name' => 'super-admin']);

        // Create all permissions if they don't exist
        $permissions = Permission::all();
        if ($permissions->isEmpty()) {
            $defaultPermissions = [
                'manage users', 'manage auctions', 'manage bids', 'manage wallets', 'manage invites', 'view admin', 'edit settings',
            ];
            foreach ($defaultPermissions as $perm) {
                Permission::firstOrCreate(['name' => $perm]);
            }
            $permissions = Permission::all();
        }

        // Assign all permissions to the super admin role
        $role->syncPermissions($permissions);

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
