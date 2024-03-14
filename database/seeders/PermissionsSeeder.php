<?php

namespace Database\Seeders;

use Illuminate\Database\{Console\Seeds\WithoutModelEvents, Seeder};
use Spatie\{Permission\Models\Permission, Permission\Models\Role};

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Super-Administrateur',
            'Citoyen',
        ];

        $permissions = [
            'can vote for an association',
        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                foreach ($permissions as $permissionName) {
                    $permission = Permission::where('name', $permissionName)->first();
                    $role->givePermissionTo($permission);
                    $this->command->info("Permission \"$permissionName\" added to role \"$roleName\".");
                }
            } else {
                $this->command->error("The role \"$roleName\" does not exist.");
            }
        }
    }
}
