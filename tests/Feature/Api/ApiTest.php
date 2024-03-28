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
    public function test_generation_of_api_token(): void
    {
        $response = $this->get('/api/token');

        $response->assertOk()
            ->assertJsonStructure(['token'])
            ->assertJson(['token' => true]);
    }

    /**
     * Test valid token access.
     *
     * Verify that the request to '/api/resources' with a valid token returns a successful response.
     *
     * @return void
     */
    public function test_successful_access_with_valid_token(): void
    {
        $resources = Resource::where('is_validated', true)
            ->where('status', 'Publiée')
            ->get();

        $this->assertNotEmpty($resources, 'Aucune ressource valide et publiée trouvée en base de données');

        $token = $this->faker->regexify('[A-Za-z0-9]{60}');

        $response = $this->withHeaders(['X-Api-Token' => $token])->get('/api/resources');

        $response->assertOk();
    }

    /**
     * Test invalid token access.
     *
     * Verify that access to resources from the API is denied when no token is provided in the request header.
     *
     * @return void
     */
    public function test_access_to_resources_api_with_invalid_token(): void
    {
        $response = $this->get('/api/resources');

        $response->assertStatus(403);
    }
}
