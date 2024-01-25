<?php

namespace App\Http\Resources;

use Illuminate\{Http\Request, Http\Resources\Json\JsonResource};
use OpenApi\Annotations as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @method getFirstMediaUrl(string $string)
 */
class ResourceResource extends JsonResource
{
    /**
     * @OA\Get(
     *     path="/api/resources",
     *     operationId="getResourcesList",
     *     tags={"Resources"},
     *     summary="Get a list of validated resources",
     *      @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *      ),
     *      @OA\Response(
     *       response=401,
     *       description="Unauthorized - Invalid credentials",
     *      ),
     *      @OA\Response(
     *       response=403,
     *       description="Forbidden"
     *    ),
     * ),
     * @OA\Info(
     *       title="Resources API Documentation",
     *       version="1.0",
     *       description="Documentation for Resources API",
     *          @OA\Contact(
     *         email="contact@mna-coding.fr"
     *    )
     *  )
     * @OA\Server(
     *   description="Returns list of validated resources",
     *   url="https://web-application.ddev.site:8443/"
     *  )
     *
     * Get a list of validated resources.
     *
     * @param Request $request
     * @return array<string, mixed>
     *
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'resources'  => $this->getFirstMediaUrl('resources'),
        ];
    }
}
