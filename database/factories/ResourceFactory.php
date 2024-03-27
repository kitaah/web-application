<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $sentence = $this->faker->unique()->sentence(30);
        $truncatedSentence = Str::limit($sentence, 45);

        $slug = Str::slug($truncatedSentence);

        $description = $this->faker->text(800);
        $truncatedDescription = Str::limit($description, 4000);

        $user = User::inRandomOrder()->first();

        $category = Category::inRandomOrder()->first();

        return [
            'category_id' => $category->id,
            'user_id' => $user->id,
            'name' => $truncatedSentence,
            'slug' => $slug,
            'description' => $truncatedDescription,
            'is_validated' => true,
            'status' => $this->faker->randomElement(['Publiée']),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Resource $resource) {
            $faker = \Faker\Factory::create();
            $image = UploadedFile::fake()->image('image.png', 200, 200)->size(50);

            $imageName = strtoupper(Str::random(26)) . '.png';
            Storage::putFileAs('public', $image, $imageName);

            $resource->addMedia(storage_path('app/public/' . $imageName))
                ->toMediaCollection('image');
        });
    }
}


