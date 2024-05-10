<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\{
    Http\Response,
    Support\Str,
    Http\UploadedFile,
    Support\Facades\Storage};
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;

class RegistrationTest extends TestCase
{
    use WithFaker;

    /**
     * Verify if registration screen can be rendered.
     *
     * @return void
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/inscription');

        $response->assertOk();
    }


    /**
     * Test validation of required fields in user registration form.
     *
     * @return void
     */
    public function test_required_fields_validation(): void
    {
        $response = $this->post('/inscription');

        $response->assertStatus(ResponseAlias::HTTP_FOUND)
        ->assertSessionHasErrors(['name', 'email', 'password', 'department', 'terms_accepted', 'image']);
    }

    /**
     * Test new user registration with valid data.
     *
     * @return void
     */
    public function test_new_user_can_register_with_valid_data(): void
    {
        $citizenRole = Role::where('name', 'Citoyen')->firstOrFail();

        $image = UploadedFile::fake()->image('avatar.jpg', 200, 200)->size(50);
        $imageName = strtoupper(Str::random(26)) . '.' . $image->getClientOriginalExtension();
        Storage::put('public/' . $imageName, file_get_contents($image->getPathname()));

        $response = $this->post('/inscription', [
            'name' => 'totoro',
            'email' => 'totoro@example.com',
            'password' => '45.POO.az',
            'department' => 'Ain',
            'password_confirmation' => '45.POO.az',
            'terms_accepted' => true,
            'image' => $image,
        ]);

        $user = User::where('email', 'totoro@example.com')->first();

        $user->assignRole($citizenRole);

        $this->assertAuthenticated();

        $this->assertTrue($user->hasRole('Citoyen'));

        if (!$user->getFirstMedia('image')) {
            $user->addMedia(storage_path('app/public/' . $imageName))
                ->toMediaCollection('image');
        }

        $this->assertCount(1, $user->getMedia('image'));
        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => 'totoro',
            'email' => 'totoro@example.com',
            'department' => 'Ain',
            'terms_accepted' => true,
        ]);
    }
}
