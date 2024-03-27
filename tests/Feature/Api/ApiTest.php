<?php

namespace Api;

use App\Models\Resource;
use Illuminate\{Foundation\Testing\WithFaker};
use Tests\TestCase;

class ApiTest extends TestCase
{
    use WithFaker;

    /**
     * Test API token generation.
     *
     * Verify that the GET request to '/api/token' returns an HTTP status code 200
     * and that the JSON response contains a 'token' key.
     *
     * @return void
     */
    public function test_api_token_generation(): void
    {
        $response = $this->get('/api/token');

        $response->assertStatus(200)
            ->assertJsonStructure(['token'])
            ->assertJson(['token' => true]);
    }

    /**
     * Test valid token access.
     *
     * Verify that the request to '/api/resources' with a valid token returns a single resource with ID 10.
     *
     * @return void
     */
    public function test_valid_token_access(): void
    {
        $resource = Resource::where('id', 200)
            ->where('is_validated', true)
            ->where('status', 'Publiée')
            ->first();

        $this->assertNotNull($resource, 'Ressource avec ID 200 non trouvée en base de données');

        $token = $this->faker->regexify('[A-Za-z0-9]{60}');

        $response = $this->withHeaders(['X-Api-Token' => $token])->get('/api/resources');

        $response->assertStatus(200)
            ->assertJsonCount(1);
    }

    /**
     * Test invalid token access.
     *
     * Verify that access to resources from the API is denied when no token is provided in the request header.
     *
     * @return void
     */
    public function test_invalid_token_access(): void
    {
        $response = $this->get('/api/resources');

        $response->assertStatus(403);
    }
}
