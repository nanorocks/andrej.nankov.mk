<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;

class JwtMiddleware
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
        $token = $request->bearerToken();
        $secret = env('JWT_SECRET');

        if (!is_null($token) && Token::validate($token, $secret) ) {
            return $next($request);
        }

        return response()->json([
            'status' => 401,
            'error' => 'Unauthorized',
            'message' => 'Invalid token',
            'attributes' => ['error' => 'Invalid token']
        ], 401);
    }
}
