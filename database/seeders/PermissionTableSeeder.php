<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'change-password',
            'package-list',
            'package-create',
            'package-edit',
            'package-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'subcategory-list',
            'subcategory-create',
            'subcategory-edit',
            'subcategory-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'pages-list',
            'pages-create',
            'pages-edit',
            'pages-delete',
            'general_setting',

            // Added permissions based on sidebar
            'contact-list',
            'contact-create',
            'contact-edit',
            'contact-delete',
            'blog-list',
            'blog-create',
            'blog-edit',
            'blog-delete',
            'file-list',
            'file-create',
            'file-edit',
            'file-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'Admin',
            'User',
            'Shopper',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $user = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ];

        $adminUser = User::firstOrCreate(['email' => $user['email']], $user);
        $adminUser->assignRole('Admin');

        // Assign all permissions to Admin role
        $adminRole = Role::where('name', 'Admin')->first();
        $permissions = Permission::pluck('id')->all();
        $adminRole->syncPermissions($permissions);
    }
}
