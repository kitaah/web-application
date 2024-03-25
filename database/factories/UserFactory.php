<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Factories\Factory,
    Http\UploadedFile,
    Support\Facades\Hash,
    Support\Str,
    Support\Facades\File,
    Support\Facades\Storage};
use Spatie\Permission\Models\Role;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $department = $this->faker->word();
        $department = Str::limit($department, 40);

        $email = $this->faker->unique()->safeEmail();
        $email = Str::limit($email, 40);

        return [
            'name' => $this->faker->unique()->regexify('/^[A-Za-z0-9_-]{5,8}$/'),
            'email' => $email,
            'email_verified_at' => $this->faker->dateTimeBetween(Carbon::createFromDate(2023), Carbon::createFromDate(2024)),
            'department' => 'Ain',
            'points' => $this->faker->numberBetween(500, 10000),
            'mood' => $this->faker->randomElement(['😀', '😂', '😊', '😍', '😎', '🤩', '😴', '😢', '😡', '🤯', '🤔', '🤫']),
            'terms_accepted' => true,
            'password' => Hash::make('45.POO.az'),
            'remember_token' => Str::random(64),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            $faker = \Faker\Factory::create();
            $image = UploadedFile::fake()->image('avatar.jpg', 200, 200)->size(50);
            $imageName = strtoupper(Str::random(26)) . '.' . $image->getClientOriginalExtension();

            Storage::put('public/' . $imageName, file_get_contents($image->getPathname()));

            $user->addMedia(storage_path('app/public/' . $imageName))
                ->toMediaCollection('image');

            $citizenRole = Role::where('name', 'Citoyen')->firstOrFail();
            $user->assignRole($citizenRole);
        });
    }
}
