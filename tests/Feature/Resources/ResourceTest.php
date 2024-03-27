<?php

namespace Resources;

use App\Models\Resource;
use App\Models\User;
use Database\Factories\UserAdminFactory;
use Illuminate\{Http\UploadedFile, Support\Str};
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Faker\Factory as Faker;

class ResourceTest extends TestCase
{
    use WithFaker;

    /**
     * Tests the access to a resource page.
     *
     * @return void
     */
    public function test_user_can_access_resource_page(): void
    {
        $user = User::where('email', 'totoro@example.com')->first();
        $this->assertNotNull($user, "L'utilisateur 'totoro@example.com' n'a pas été trouvé.");
        $this->actingAs($user);

        $resource = Resource::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Resource::class, $resource);

        $resource->id = 200;
        $resource->save();

        $response = $this->get('/ressource/' . $resource->slug);

        $response->assertStatus(200);
    }

    /**
     * Test validation of required fields in user registration form.
     *
     * @return void
     */
    public function test_resource_creation_validation(): void
    {
        $user = User::where('email', 'totoro@example.com')->first();
        $this->assertNotNull($user, "L'utilisateur 'totoro@example.com' n'a pas été trouvé.");
        $this->actingAs($user);

        $response = $this->post('/mes-ressources/ajout');

        $response->assertStatus(ResponseAlias::HTTP_FOUND)
            ->assertSessionHasErrors(['name' ,'slug' ,'description', 'image', 'category_id']);
    }

    /**
     * Test creating a resource via the user resource form.
     *
     * @return void
     */
    public function test_create_resource_via_user_form(): void
    {
        $user = User::where('email', 'totoro@example.com')->first();
        $this->assertNotNull($user, "L'utilisateur 'totoro@example.com' n'a pas été trouvé.");
        $this->actingAs($user);

        $resource = Resource::factory()->create([
            'user_id' => $user->id,
            'is_validated' => false,
            'status' => $this->faker->randomElement(['En attente']),
        ]);

        $response = $this->post('/mes-ressources/ajout', [
            'category_id' => $resource->category_id,
            'name' => $resource->name,
            'description' => $resource->description,
            'image' => $resource->image,
        ]);

        $response->assertStatus(302)
            ->assertRedirect();

        $lastResource = Resource::latest()->first();

        $this->assertNotNull($lastResource);

        $resourceUserId = $lastResource->user_id;

        $this->assertDatabaseHas('resources', [
            'category_id' => $lastResource->category_id,
            'user_id' => $resourceUserId,
            'slug' => $lastResource->slug,
            'name' => $lastResource->name,
            'description' => $lastResource->description,
        ]);
    }

    /**
     * Tests editing a resource via user form.
     *
     * @return void
     */
    public function test_edit_resource_via_user_form(): void
    {
        $user = User::where('email', 'totoro@example.com')->first();
        $this->assertNotNull($user, "The user 'totoro@example.com' was not found.");
        $this->actingAs($user);

        $resourceToEdit = Resource::findOrFail(200);

        $response = $this->get(route('resource.edit', ['slug' => $resourceToEdit->slug]));
        $response->assertStatus(200);

        $faker = Faker::create();
        $updatedName = $faker->text(40);
        $updatedDescription = $faker->text(1000);
        $updatedSlug = Str::slug($updatedName);
        $updatedCategoryId = $faker->numberBetween(1, 2);

        $updatedData = [
            'category_id' => $updatedCategoryId,
            'name' => $updatedName,
            'description' => $updatedDescription,
            'slug' => $updatedSlug,
        ];

        $response = $this->put(route('resource.update', ['slug' => $resourceToEdit->slug]), $updatedData);

        $response->assertRedirect();

        $editedResource = Resource::findOrFail($resourceToEdit->id);

        $this->assertEquals($updatedData['name'], $editedResource->name);
        $this->assertEquals($updatedData['description'], $editedResource->description);
        $this->assertEquals($updatedData['slug'], $editedResource->slug);
        $this->assertEquals($updatedData['category_id'], $editedResource->category_id);
    }

    /**
     * Tests editing a resource image via user form.
     *
     * @return void
     */
    public function test_edit_resource_image_via_user_form(): void
    {
        $user = User::where('email', 'totoro@example.com')->first();
        $this->assertNotNull($user, "L'utilisateur 'totoro@example.com' n'a pas été trouvé.");
        $this->actingAs($user);

        $resourceToEdit = Resource::findOrFail(200);

        $response = $this->get(route('image.edit', ['slug' => $resourceToEdit->slug]));

        $response->assertStatus(200);

        $imageFile = UploadedFile::fake()->image('image.jpg', 200, 200)->size(50);

        $updatedData = [
            'image' => $imageFile,
        ];

        $response = $this->put(route('image.update', ['slug' => $resourceToEdit->slug]), $updatedData);

        $response->assertRedirect();

        $editedResource = Resource::findOrFail($resourceToEdit->id);

        $this->assertNotNull($editedResource->getFirstMedia('image'));
    }

    /**
     * Test that image cannot be edited if it's a PDF file.
     *
     * @return void
     */
    public function test_edit_resource_image_does_not_accept_pdf(): void
    {
        $user = User::where('email', 'totoro@example.com')->first();
        $this->assertNotNull($user, "L'utilisateur 'totoro@example.com' n'a pas été trouvé.");
        $this->actingAs($user);

        $resourceToEdit = Resource::findOrFail(200);

        $response = $this->get(route('image.edit', ['slug' => $resourceToEdit->slug]));
        $response->assertStatus(200);

        $pdfFile = UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf');

        $updatedData = ['image' => $pdfFile];
        $response = $this->put(route('image.update', ['slug' => $resourceToEdit->slug]), $updatedData);

        $response->assertSessionHasErrors(['image']);
    }

    /**
     * Test that the resource routes are protected by roles and permissions.
     *
     * @return void
     */
    public function test_resources_routes_are_protected_by_roles_and_permissions(): void
    {
        $user = UserAdminFactory::new()->create();

        $response1 = $this->actingAs($user)->get('/mes-ressources');
        $response2 = $this->actingAs($user)->get('/mes-ressources/ajout');

        $response1->assertStatus(403);
        $response2->assertStatus(403);
    }
}
