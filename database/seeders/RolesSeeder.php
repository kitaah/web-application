<?php

namespace Database\Seeders;

use Illuminate\{Database\Console\Seeds\WithoutModelEvents, Database\Seeder};
use Spatie\{Permission\Models\Permission, Permission\Models\Role};

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_super_admin = Role::create(['name' => 'Super-Administrateur']);
        $role_admin = Role::create(['name' => 'Administrateur']);
        $role_moderator = Role::create(['name' => 'Modérateur']);
        $role_citizen = Role::create(['name' => 'Citoyen']);
        $role_banned = Role::create(['name' => 'Banni']);

        $permission_none = Permission::create(['name' => 'none']);

        $role_super_admin->givePermissionTo($permission_none);
        $role_admin->givePermissionTo($permission_none);
        $role_moderator->givePermissionTo($permission_none);
        $role_citizen->givePermissionTo($permission_none);
        $role_banned->givePermissionTo($permission_none);
    }
}
