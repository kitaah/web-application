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
        $role_admin = Role::create(['name' => 'Administratreur']);
        $role_moderator = Role::create(['name' => 'Modérateur']);
        $role_citizen = Role::create(['name' => 'Citoyen']);
        $role_banned = Role::create(['name' => 'Banni']);

        $permission_test = Permission::create(['name' => 'test']);
        //$permission_read = Permission::create(['name' => 'read articles']);
        //$permission_edit = Permission::create(['name' => 'edit articles']);
        //$permission_write = Permission::create(['name' => 'write articles']);
        //$permission_delete = Permission::create(['name' => 'delete articles']);

        //$permissions_admin = [$permission_read, $permission_edit, $permission_write, $permission_delete];

        //$role_super_admin->syncPermissions($permission_admin);
        $role_super_admin->givePermissionTo($permission_test);
        $role_admin->givePermissionTo($permission_test);
        $role_moderator->givePermissionTo($permission_test);
        $role_citizen->givePermissionTo($permission_test);
        $role_banned->givePermissionTo($permission_test);
    }
}
