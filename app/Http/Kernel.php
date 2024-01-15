<?php

namespace App\Http;

use App\{Http\Middleware\Authenticate,
    Http\Middleware\EncryptCookies,
    Http\Middleware\HandleInertiaRequests,
    Http\Middleware\PreventRequestsDuringMaintenance,
    Http\Middleware\RedirectIfAuthenticated,
    Http\Middleware\TrimStrings,
    Http\Middleware\TrustProxies,
    Http\Middleware\ValidateSignature,
    Http\Middleware\VerifyCsrfToken};
use Illuminate\{Auth\Middleware\AuthenticateWithBasicAuth,
    Auth\Middleware\Authorize,
    Auth\Middleware\EnsureEmailIsVerified,
    Auth\Middleware\RequirePassword,
    Cookie\Middleware\AddQueuedCookiesToResponse,
    Foundation\Http\Kernel as HttpKernel,
    Foundation\Http\Middleware\ConvertEmptyStringsToNull,
    Foundation\Http\Middleware\HandlePrecognitiveRequests,
    Foundation\Http\Middleware\ValidatePostSize,
    Http\Middleware\AddLinkHeadersForPreloadedAssets,
    Http\Middleware\HandleCors,
    Http\Middleware\SetCacheHeaders,
    Routing\Middleware\SubstituteBindings,
    Routing\Middleware\ThrottleRequests,
    Session\Middleware\AuthenticateSession,
    Session\Middleware\StartSession,
    View\Middleware\ShareErrorsFromSession};

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        TrustProxies::class,
        HandleCors::class,
        PreventRequestsDuringMaintenance::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            ThrottleRequests::class.':api',
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'auth.session' => AuthenticateSession::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'precognitive' => HandlePrecognitiveRequests::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
    ];
}
