<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Granular permissions, grouped by admin area.
        $permissions = [
            'manage products', 'manage categories', 'manage orders', 'manage users',
            'manage suppliers', 'manage pricing', 'manage currencies', 'manage coupons',
            'manage payments', 'manage taxes', 'view analytics', 'view activity logs',
            'manage roles', 'send notifications', 'monitor system',
        ];
        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // Admin — everything.
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions(Permission::all());

        // Staff — day-to-day operations, no roles/pricing/system control.
        $staff = Role::firstOrCreate(['name' => 'Staff']);
        $staff->syncPermissions([
            'manage products', 'manage categories', 'manage orders',
            'manage suppliers', 'manage coupons', 'view analytics',
            'send notifications',
        ]);

        // Customer — no admin permissions (storefront role).
        Role::firstOrCreate(['name' => 'Customer']);
    }
}
