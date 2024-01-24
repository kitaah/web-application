<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\{Database\Console\Seeds\WithoutModelEvents, Database\Seeder, Support\Facades\Hash};

class UserSeeder extends Seeder
{
    /**
     *  Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'password' => 'superadmin',
                'role' => 'Super-Administrateur',
            ],
        ];

        foreach($users as $user) {
            $created_user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
        }

        $created_user->assignRole($user['role']);
    }
}
