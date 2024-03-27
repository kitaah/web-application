<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use JsonException;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * Test if the login screen can be rendered.
     *
     * @return void
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/connexion');

        $response->assertStatus(200);
    }

    /**
     * Test if user can authenticate using the login screen.
     *
     * @return void
     * @throws JsonException
     */
    public function test_user_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/connexion', [
            'email' => $user->email,
            'password' => '45.POO.az',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME)
            ->assertSessionHasNoErrors();
    }

    /**
     * Test if user cannot authenticate with an invalid password.
     *
     * @return void
     */
    public function test_user_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/connexion', [
            'email' => $user->email,
            'password' => '45.POO.hg',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    /**
     * Test if user can log out.
     *
     * @return void
     * @throws JsonException
     */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/')
            ->assertSessionHasNoErrors();
    }
}
