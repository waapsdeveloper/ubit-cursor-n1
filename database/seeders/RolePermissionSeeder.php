<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User permissions
            'view auctions',
            'view auction details',
            'apply for bidder status',
            
            // Bidder permissions
            'place bids',
            'view bid history',
            'manage wallet',
            'view personal bids',
            
            // Admin permissions
            'manage users',
            'manage auctions',
            'manage bids',
            'manage wallets',
            'manage invites',
            'view admin',
            'edit settings',
            'process bidder applications',
            'send invitations',
            
            // Super admin permissions (all permissions)
            'super admin',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'user' => [
                'view auctions',
                'view auction details',
                'apply for bidder status',
            ],
            'bidder' => [
                'view auctions',
                'view auction details',
                'apply for bidder status',
                'place bids',
                'view bid history',
                'manage wallet',
                'view personal bids',
            ],
            'admin' => [
                'view auctions',
                'view auction details',
                'apply for bidder status',
                'place bids',
                'view bid history',
                'manage wallet',
                'view personal bids',
                'manage users',
                'manage auctions',
                'manage bids',
                'manage wallets',
                'manage invites',
                'view admin',
                'edit settings',
                'process bidder applications',
                'send invitations',
            ],
            'super-admin' => $permissions, // Super admin gets all permissions
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
} 