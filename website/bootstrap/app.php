<?php

use App\Http\Middleware\AllowPaddleWebhookIps;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // cPanel, Cloudflare and local ngrok terminate HTTPS before forwarding
        // the request to Laravel. Trust their forwarded scheme/host so secure
        // Filament and Livewire URLs are not downgraded to HTTP.
        $middleware->trustProxies(at: '*');
        $middleware->validateCsrfTokens(except: ['paddle/*']);
        $middleware->append(AllowPaddleWebhookIps::class);
        $middleware->appendToGroup('web', SecurityHeaders::class);
    })
    ->withEvents(discover: [
        __DIR__.'/../app/Listeners',
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
