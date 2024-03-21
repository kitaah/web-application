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
                'name' => 'paul79',
                'email' => 'p.robert@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Super-Administrateur',
            ],
            [
                'name' => 'fabien59',
                'email' => 'f.barreau@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Super-Administrateur',
            ],
            [
                'name' => 'diane56',
                'email' => 'diane.noux@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Super-Administrateur',
            ],
            [
                'name' => 'boris73',
                'email' => 'b.zelinski@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Administrateur',
            ],
            [
                'name' => 'helene36',
                'email' => 'h.simon@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Administrateur',
            ],
            [
                'name' => 'marc15',
                'email' => 'm.douarez@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Administrateur',
            ],
            [
                'name' => 'gaelle63',
                'email' => 'g.foulard@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Administrateur',
            ],
            [
                'name' => 'olivier59',
                'email' => 'o.fischer@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Modérateur',
            ],
            [
                'name' => 'amina75',
                'email' => 'a.hamla@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Modérateur',
            ],
            [
                'name' => 'vivien43',
                'email' => 'vivi43@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'tao57',
                'email' => 'tao57@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'eric28',
                'email' => 'eric288@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'kevin66',
                'email' => 'kevin66@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'sofiane38',
                'email' => 'sofiane38@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'anne16',
                'email' => 'anne16@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'helene22',
                'email' => 'helene22@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'sadeck37',
                'email' => 'sadeck37@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'carla29',
                'email' => 'carla29@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'louise41',
                'email' => 'louise41@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'sylvie93',
                'email' => 'sylvie93@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'romain78',
                'email' => 'romain78@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'manu36',
                'email' => 'manu36@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'misha14',
                'email' => 'misha14@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'romain71',
                'email' => 'romain71@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'louane82',
                'email' => 'louane82@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'hugo98',
                'email' => 'hugo98@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'kevin73',
                'email' => 'kevin73@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'julia58',
                'email' => 'julia58@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'enzo18',
                'email' => 'enzo18@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'paulin69',
                'email' => 'paulin69@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'lea67',
                'email' => 'lea67@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'olivia17',
                'email' => 'olivia17@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'dimitri29',
                'email' => 'dimitri29@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'carlos45',
                'email' => 'carlos45@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'francis',
                'email' => 'francis39@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'hubert78',
                'email' => 'hubert78@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'fiona34',
                'email' => 'fiona34@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'xavier22',
                'email' => 'xavier22@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'hugo99',
                'email' => 'hugo99@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'didier88',
                'email' => 'didier88@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'quentin99',
                'email' => 'quentin99@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'andre84',
                'email' => 'andre84@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'paola68',
                'email' => 'paola68@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'yves41',
                'email' => 'yves41@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'theo12',
                'email' => 'theo12@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'mathieu37',
                'email' => 'mathieu37@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'benoit88',
                'email' => 'benoit88@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'anna36',
                'email' => 'anna36@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'william14',
                'email' => 'william14@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Citoyen',
            ],
            [
                'name' => 'caroline39',
                'email' => 'caroline39@gmail.com',
                'password' => '45.POO.az',
                'role' => 'Banni',
            ],
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
