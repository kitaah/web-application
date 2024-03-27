<?php

namespace Comments;

use App\Models\{Comment, Resource, User};
use Database\Factories\UserAdminFactory;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class CommentTest extends TestCase
{
    /**
     * Tests that comment creation fails when content is not provided.
     *
     * @return void
     */
    public function test_comment_creation_fails_when_content_is_not_provided(): void
    {
        $user = User::where('email', 'totoro@example.com')->first();
        $this->assertNotNull($user, "L'utilisateur 'totoro@example.com' n'a pas été trouvé.");
        $this->actingAs($user);

        $response = $this->post('/comments');

        $response->assertStatus(ResponseAlias::HTTP_FOUND)
            ->assertSessionHasErrors(['content']);
    }

    /**
     * Tests if a user can successfully create a comment.
     *
     * @return void
     */
    public function test_user_can_create_comment(): void
    {
        $user = User::where('email', 'totoro@example.com')->first();
        $this->assertNotNull($user, "L'utilisateur 'totoro@example.com' n'a pas été trouvé.");
        $this->actingAs($user);

        $resource = Resource::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Resource::class, $resource);

        $comment = Comment::factory()->make([
            'user_id' => $user->id,
            'resource_id' => $resource->id,
        ]);

        $this->assertInstanceOf(Comment::class, $comment);

        $response = $this->post('/comments', [
            'resource_id' => $resource->id,
            'content' => $comment->content,
        ]);

        $response->assertStatus(302)
            ->assertRedirect();

        $lastComment = Comment::latest()->first();

        $this->assertNotNull($lastComment);

        $commentResourceId = $lastComment->resource_id;
        $commentUserId = $lastComment->user_id;

        $this->assertDatabaseHas('comments', [
            'id' => $lastComment->id,
            'user_id' => $commentUserId,
            'resource_id' => $commentResourceId,
            'content' => $lastComment->content,
        ]);
    }

    /**
     * Tests if a user can create a comment within the character limit.
     *
     * @return void
     */
    public function test_user_cannot_create_comment_within_character_limit(): void
    {
        $user = User::where('email', 'totoro@example.com')->first();
        $this->assertNotNull($user, "L'utilisateur 'totoro@example.com' n'a pas été trouvé.");
        $this->actingAs($user);

        $resource = Resource::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Resource::class, $resource);

        $longContent = str_repeat('a', 2500);

        $response = $this->post('/comments', [
            'resource_id' => $resource->id,
            'content' => $longContent,
        ]);

        $response->assertSessionHasErrors(['content']);

        $this->assertDatabaseMissing('comments', [
            'content' => $longContent,
        ]);
    }

    /**
     *  Test that the comment store route is protected by roles and permissions.
     *
     * @return void
     */
    public function test_comment_store_route_is_protected_by_roles_and_permissions(): void
    {
        $user = UserAdminFactory::new()->create();

        $response = $this->actingAs($user)->post('/comments');

        $response->assertStatus(403);
    }
}
