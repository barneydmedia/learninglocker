<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        // \App\Http\Middleware\Guest::class,
        \App\Http\Middleware\ResponseHeaders::class,
        \App\Http\Middleware\EncryptCookies::class,
        // \App\Http\Middleware\RedirectIfAuthenticated::class,
        // \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        "auth.admin" => \App\Http\Middleware\AuthAdmin::class,
        "auth.check" => \App\Http\Middleware\AuthCheck::class,
        "auth.lrs" => \App\Http\Middleware\AuthLRS::class,
        "auth.statement" => \App\Http\Middleware\AuthStatement::class,
        "auth.super" => \App\Http\Middleware\AuthSuper::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        "create.lrs" => \App\Http\Middleware\CreateLrs::class,
        "edit.lrs" => \App\Http\Middleware\EditLrs::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        "registration.status" => \App\Http\Middleware\RegistrationStatus::class,
        "user.delete" => \App\Http\Middleware\UserDelete::class,
    ];
}
