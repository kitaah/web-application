<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\{Foundation\Testing\RefreshDatabase, Support\Str, Http\UploadedFile, Support\Facades\Storage};
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class RegistrationTest extends TestCase
{
    /**
     * Verify if registration screen can be rendered.
     *
     * @return void
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/inscription');

        $response->assertStatus(200);
    }

    /**
     * Test new user registration with JPG image.
     *
     * @return void
     */
    public function test_new_user_can_register_with_valid_data(): void
    {
        $citizenRole = Role::where('name', 'Citoyen')->firstOrFail();

        $image = UploadedFile::fake()->image('avatar.jpg', 400, 300)->size(50);
        $imageName = strtoupper(Str::random(26)) . '.' . $image->getClientOriginalExtension();
        Storage::put('public/' . $imageName, file_get_contents($image->getPathname()));

        $response = $this->post('/inscription', [
            'name' => 'julie66',
            'email' => 'julie66@gmail.com',
            'password' => '45.POO.az',
            'department' => 'Ain',
            'password_confirmation' => '45.POO.az',
            'terms_accepted' => true,
            'image' => $image,
        ]);

        $user = User::where('email', 'julie66@gmail.com')->first();

        $user->assignRole($citizenRole);

        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertAuthenticated();

        $this->assertTrue($user->hasRole('Citoyen'));

        if (!$user->getFirstMedia('image')) {
            $user->addMedia(storage_path('app/public/' . $imageName))
                ->toMediaCollection('image');
        }

        $this->assertCount(1, $user->getMedia('image'));

        $this->assertDatabaseHas('users', [
            'name' => 'julie66',
            'email' => 'julie66@gmail.com',
        ]);
    }
}
