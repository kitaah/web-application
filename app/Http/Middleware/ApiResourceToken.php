<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Middleware\ThrottleRequests;
class ApiResourceToken
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return JsonResponse|mixed|Response
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->is('api/token')) {
            $token = Str::random(60);
            return response()->json(['token' => $token]);
        }

        $token = $request->header('X-Api-Token');

        if (!$token || !$this->isValidToken($token)) {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        return $next($request);
    }

    /**
     * @param $token
     * @return bool
     */
    private function isValidToken($token): bool
    {
        return strlen($token) === 60;
    }
}
