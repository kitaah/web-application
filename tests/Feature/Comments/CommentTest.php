<?php

namespace Comments;

use App\Models\{Comment, Resource, User};
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * Test comment creation.
     *
     * @return void
     */
    public function test_comment_creation(): void
    {
        $user = User::where('email', 'julie12@gmail.com')->first();
        $this->actingAs($user);

        $comment = Comment::factory()->make();

        $response = $this->post('/comments', [
            'resource_id' => $comment->resource_id,
            'content' => $comment->content,
        ]);

        $response->assertRedirect();

        $lastComment = Comment::latest()->first();

        $this->assertDatabaseHas('comments', [
            'id' => $lastComment->id,
            'resource_id' => $comment->resource_id,
            'content' => $comment->content,
        ]);

        $this->assertEquals($user->id, $comment->user_id);
    }

    /**
     * Test comment display.
     *
     * @return void
     */
    public function test_comment_display(): void
    {
        $comment = Comment::factory()->create();
        $resourceSlug = $comment->resource->slug;

        $response = $this->get('/ressource/' . $resourceSlug);

        $response->assertStatus(200);
        $response->assertSee($comment->content);
    }
}
