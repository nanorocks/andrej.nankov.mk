<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->query('key') == env('HMAC_SHARED_API_KEY')) {
            return $next($request);
        }

        return response()->json([
            'status' => 401,
            'error' => 'Unauthorized',
            'message' => 'Invalid api key',
            'attributes' => ['error' => 'Invalid api key']
        ], 401);
    }
}
