<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\{Database\Seeder, Http\UploadedFile, Support\Facades\Hash, Support\Facades\Storage, Support\Str};
use Spatie\Permission\Models\Role;

class  UserSeeder extends Seeder
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
                'name' => 'paul16',
                'email' => 'p.simon@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Super-Administrateur',
            ],
            [
                'name' => 'fabien45',
                'email' => 'f.boulard@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Super-Administrateur',
            ],
            [
                'name' => 'diane57',
                'email' => 'diane.foux@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Super-Administrateur',
            ],
            [
                'name' => 'boris16',
                'email' => 'b.zelinsky@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Super-Administrateur',
            ],
            [
                'name' => 'helene38',
                'email' => 'h.poulain@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Administrateur',
            ],
            [
                'name' => 'marc13',
                'email' => 'm.valentinez@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Administrateur',
            ],
            [
                'name' => 'camille59',
                'email' => 'c.foulard@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Administrateur',
            ],
            [
                'name' => 'olivier58',
                'email' => 'o.martinez@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Modérateur',
            ],
            [
                'name' => 'amina71',
                'email' => 'a.hamlah@re-relationnelles.fr',
                'password' => '45.POO.az',
                'role' => 'Modérateur',
            ],
        ];

        foreach($users as $user) {
            $created_user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'department' => 'Ain',
                'email_verified_at' => now(),
                'terms_accepted' => true,
            ]);

            $created_user->assignRole($user['role']);

            \Faker\Factory::create();
            $image = UploadedFile::fake()->image('avatar.jpg', 200, 200)->size(50);
            $imageName = strtoupper(Str::random(26)) . '.' . $image->getClientOriginalExtension();

            Storage::put('public/' . $imageName, file_get_contents($image->getPathname()));

            $created_user->addMedia(storage_path('app/public/' . $imageName))
                ->toMediaCollection('image');

            $this->command->info("User \"$user[name]\" created with role \"$user[role]\".");
        }

        $this->command->info("User seeding completed.");
    }
}
