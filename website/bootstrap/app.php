<?php

use App\Http\Middleware\DetectBruteForce;
use App\Http\Middleware\SecurityHeaders;
use App\Listeners\FailedLoginListener;
use Illuminate\Auth\Events\Failed;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Event;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: ['paddle/*']);
        $middleware->appendToGroup('web', SecurityHeaders::class);
        $middleware->appendToGroup('web', DetectBruteForce::class);
    })
    ->withEvents(discover: [
        __DIR__.'/../app/Listeners',
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->booting(function () {
        Event::listen(Failed::class, FailedLoginListener::class);
    })->create();
