<?php

namespace App\Http\Resources;

use Illuminate\{Http\Request, Http\Resources\Json\JsonResource};
use OpenApi\Annotations as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $url
 * @property mixed $slug
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $user
 * @property mixed $category
 * @method getFirstMediaUrl(string $string)
 */
class AllResourcesResource extends JsonResource
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
     *      ),
     *      @OA\Response(
     *        response=404,
     *        description="Not found"
     *      ),
     * ),
     * @OA\Info(
     *       title="Project API Documentation",
     *       version="1.0",
     *       description="Documentation for project APIs",
     *          @OA\Contact(
     *         email="contact@mna-coding.fr"
     *    )
     *  ),
     * @OA\Get(
     *      path="/api/resource/{slug}",
     *      operationId="getSingleResource",
     *      tags={"Resource"},
     *      summary="Get a single validated resource",
     * @OA\Parameter(
     *      name="slug",
     *      required=true,
     *      in="path",
     *      description="Slug of the resource",
     *      @OA\Schema(
     *         type="string"
     *          )
     *       ),
     *       @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *       ),
     *       @OA\Response(
     *        response=401,
     *        description="Unauthorized - Invalid credentials",
     *       ),
     *       @OA\Response(
     *        response=403,
     *        description="Forbidden"
     *       ),
     *       @OA\Response(
     *         response=404,
     *         description="Not found"
     *       ),
     *  ),
     * @OA\Server(
     *   url="https://web-application.ddev.site:8443/"
     *  )
     *
     *  Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     *
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'user_name' => optional($this->user)->name,
            'category_name' => optional($this->category)->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'url' => $this->url,
            'image' => $this->getFirstMediaUrl('image'),
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];

        return array_filter($data, static function ($value) {
            return $value !== null;
        });
    }
}
