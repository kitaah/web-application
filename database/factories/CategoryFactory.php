<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $sentence = $this->faker->unique()->sentence(10);
        $truncatedSentence = Str::limit($sentence, 15);

        $slug = Str::slug($truncatedSentence);

        return [
            'name' => $truncatedSentence,
            'slug' => $slug,
        ];
    }
}
