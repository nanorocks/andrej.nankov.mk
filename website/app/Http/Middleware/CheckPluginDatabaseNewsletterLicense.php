<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Facades\PluginDatabaseNewsletterLicense;

class CheckPluginDatabaseNewsletterLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $licenseKey = $request->header('X-Plugin-License') ?? $request->input('license_key');

        if (! $licenseKey || ! PluginDatabaseNewsletterLicense::validateLicense($licenseKey)) {
            abort(403, 'Invalid or missing license key.');
        }

        return $next($request);
    }
}
