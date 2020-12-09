<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;

class HmacSignature
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

        $signature = base64_decode($request->query('signature'));
        $data = base64_decode($request->query('data'));
        $hmacSignatureSecret = env('HMAC_SHARED_SECRET_KEY');

        if ($this->verifySignature($data, $signature, $hmacSignatureSecret) !== false) {
            return $next($request);
        }

        return response()->json([
            'statusCode' => 401,
            'error' => 'Unauthorized',
            'message' => 'Invalid Signature',
            'attributes' => ['error' => 'Invalid Signature']
        ]);
    }

    private function verifySignature($data, $signature, $secret)
    {
        return hash_equals(hash_hmac("sha512", $data, $secret), $signature);
    }

}
