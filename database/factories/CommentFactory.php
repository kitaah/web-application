<?php

namespace Database\Factories;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->text(1000),
            'is_published' => true,
            'is_reported' => false,
            'moderation_comment' => null,
            'is_user_banned' => false,
            'created_at' => null,
        ];
    }
}
