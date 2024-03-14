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
                'name' => 'alban24',
                'email' => 'a.gers@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Super-Administrateur',
            ],
            [
                'name' => 'julie89',
                'email' => 'j.combiers@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Administrateur',
            ],
            [
                'name' => 'xav46',
                'email' => 'x.martinez@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Modérateur',
            ],
            [
                'name' => 'samy33',
                'email' => 'samy33@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'zoomask',
                'email' => 'zoomask45@gmail.com',
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
        }
    }
}
