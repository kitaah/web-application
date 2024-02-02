<?php

namespace App\Http\Resources;

use Illuminate\{Http\Request, Http\Resources\Json\JsonResource};
use OpenApi\Annotations as OA;

/**
 * @property mixed $id
 * @property mixed $question
 * @property mixed $slug
 * @property mixed $name
 * @property mixed $is_right
 */
class GameResource extends JsonResource
{
    /**
     * @OA\Get(
     *     path="/api/game",
     *     operationId="getRandomGame",
     *     tags={"Games"},
     *     summary="Get a random quiz",
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
            'slug' => $this->slug,
            'question' => $this->question,
            'is_right' => $this->is_right,
        ];

        return array_filter($data, static function ($value) {
            return $value !== null;
        });
    }
}
