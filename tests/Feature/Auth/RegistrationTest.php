<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\{Foundation\Testing\RefreshDatabase, Support\Str, Http\UploadedFile, Support\Facades\Storage};
use Tests\TestCase;

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
        $newDirectory = (int) Storage::directories('public')[0] + 300;
        Storage::makeDirectory('public/' . $newDirectory);

        $image = UploadedFile::fake()->image('avatar.jpg', 200, 200)->size(500);

        $imageName = strtoupper(Str::random(26)) . '.' . $image->getClientOriginalExtension();
        Storage::putFileAs('public/' . $newDirectory, $image, $imageName);

        $response = $this->post('/inscription', [
            'name' => 'julie12',
            'email' => 'julie12@gmail.com',
            'password' => '45.POO.az',
            'department' => 'Ain',
            'password_confirmation' => '45.POO.az',
            'terms_accepted' => true,
            'image' => $image,
        ]);

        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'name' => 'julie12',
            'email' => 'julie12@gmail.com',
        ]);
    }
}
