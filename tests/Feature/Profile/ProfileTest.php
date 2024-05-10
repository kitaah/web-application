<?php

namespace Profile;

use App\Models\User;
use Database\Factories\UserAdminFactory;
use JsonException;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * Test that the profile page is displayed.
     *
     * @return void
     */
    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profil');

        $response->assertOk();
    }

    /**
     * Test that the profile page is redirected for guest users.
     *
     * @return void
     */
    public function test_profile_page_is_redirected_for_guest_users(): void
    {
        $response = $this->get('/profil');

        $response->assertStatus(302);

        $response->assertRedirect('/connexion');
    }

    /**
     * Test that the profile route is protected by roles and permissions.
     *
     * @return void
     */
    public function test_profile_route_is_protected_by_roles_and_permissions(): void
    {
        $user = UserAdminFactory::new()->create();

        $response = $this->actingAs($user)->get('/profil');

        $response->assertStatus(403);
    }

    /**
     * Test that the profile information can be updated.
     *
     * @throws JsonException
     */
    public function test_mood_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profil', [
                'name' => $user->name,
                'email' => $user->email,
                'mood' => '😊',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profil');

        $user->refresh();

        $this->assertSame('😊', $user->mood);
    }

    /**
     * Test that updating mood increments user points.
     *
     * @throws JsonException
     */
    public function test_mood_update_increments_user_points(): void
    {
        $user = User::factory()->create(['points' => 0]);

        $mood = '😊';

        $response = $this
            ->actingAs($user)
            ->patch('/profil', [
                'name' => $user->name,
                'email' => $user->email,
                'mood' => '😊',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profil');

        $user->refresh();

        $this->assertSame($mood, $user->mood);

        $this->assertSame(1, $user->points);
    }
}
