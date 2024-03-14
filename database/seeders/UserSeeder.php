<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\{Database\Seeder, Support\Facades\Hash};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'paul78',
                'email' => 'paul.robert@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Super-Administrateur',
            ],
            [
                'name' => 'marta35',
                'email' => 'marta.hernandez@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Administrateur',
            ],
            [
                'name' => 'clodia11',
                'email' => 'c.juvin@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Modérateur',
            ],
            [
                'name' => 'cedric47',
                'email' => 'cedric47@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'doudou',
                'email' => 'doudou24@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Banni',
            ]
        ];

        foreach($users as $user) {
            $created_user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);

            $created_user->assignRole($user['role']);

            $this->command->info("User \"$user[name]\" created with role \"$user[role]\".");
        }

        $this->command->info("User seeding completed.");
    }
}
