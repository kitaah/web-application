<?php

namespace Database\Seeders;

use Illuminate\{Database\Console\Seeds\WithoutModelEvents, Database\Seeder};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PermissionsSeeder::class
        ]);

        \App\Models\User::factory(50)->create();
        \App\Models\Category::factory(15)->create();
        \App\Models\Resource::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
