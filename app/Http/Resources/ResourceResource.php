<?php

namespace App\Http\Resources;

use App\Models\{Category, User};
use Carbon\Carbon;
use Illuminate\{Http\Request, Http\Resources\Json\JsonResource};
use OpenApi\Annotations as OA;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $category_id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $url
 * @property mixed $slug
 * @property mixed $created_at
 * @property mixed $updated_at
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
        $user = User::find($this->user_id);
        $category = Category::find($this->category_id);
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('d/m/Y');
        $formattedUpdatedAt = Carbon::parse($this->updated_at)->format('d/m/Y');

        return [
            'id' => $this->id,
            'user_name' => $user ? $user->name : null,
            'category_name' => $category ? $category->name : null,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'url' => $this->url,
            'created_at' => $formattedCreatedAt,
            'updated_at' => $formattedUpdatedAt,
            'image'  => $this->getFirstMediaUrl('image'),
        ];
    }
}
