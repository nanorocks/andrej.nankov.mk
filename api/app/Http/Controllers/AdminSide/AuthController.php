<?php

namespace App\Http\Controllers\AdminSide;

use App\Models\User;
use ReallySimpleJWT\Token;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RefreshTokenRequest;

class AuthController
{

    /**
     * @OA\Post(path="/login",
     *   tags={"Auth"},
     *   summary="Login user and use your JWT",
     *   description="",
     *   operationId="loginUser",
     *   @OA\Parameter(
     *     name="email",
     *     required=true,
     *     in="query",
     *     description="The email for login",
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="password",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="The password for login in clear text",
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Get JWT",
     *     @OA\Schema(type="string"),
     *     @OA\Header(
     *       header="X-Rate-Limit",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the user"
     *     ),
     *     @OA\Header(
     *       header="X-Expires-After",
     *       @OA\Schema(
     *          type="string",
     *          format="date-time",
     *       ),
     *       description="date in UTC when token expires"
     *     )
     *   ),
     *   @OA\Response(response=422, description="Unprocessable Entity"),
     *   @OA\Response(response=401, description="Invalid email or password."),
     *   @OA\Response(response=500, description="Internal Server error")
     * )
     */
    public function login(LoginUserRequest $request)
    {
        $email = $request->getParams()->get('email');
        $password = $request->getParams()->get('password');

        $user = User::where('email', $email)->first();

        if (empty($user) || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }

        $token = Token::create(
            $user->id,
            env('JWT_SECRET'),
            $time = time() + env('JWT_TTL'),
            env('APP_URL')
        );

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $time
        ]);
    }

    /**
     * @OA\Post(path="/refresh",
     *   tags={"Auth"},
     *   summary="Refresh JWT",
     *   description="",
     *   operationId="RefreshJWT",
     *   @OA\Parameter(
     *     name="token",
     *     required=false,
     *     in="query",
     *     description="expired JWT",
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Refresh JWT",
     *     @OA\Schema(type="string"),
     *     @OA\Header(
     *       header="X-Rate-Limit",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the user"
     *     ),
     *     @OA\Header(
     *       header="X-Expires-After",
     *       @OA\Schema(
     *          type="string",
     *          format="date-time",
     *       ),
     *       description="date in UTC when token expires"
     *     )
     *   ),
     *   @OA\Response(response=422, description="Unprocessable Entity"),
     *   @OA\Response(response=500, description="Internal Server error| Invalid token signature")
     * )
     */
    public function refresh(RefreshTokenRequest $request)
    {
        $token = Token::getPayload($request->getParams()->get('token'), env('JWT_SECRET'));
        $time = time();

        // var_dump(date('h:i:sa',$time), date('h:i:sa', $token['exp']));

        if($time <= $token['exp']){
            return response()->json([
                'access_token' => $request->getParams()->get('token'),
                'token_type' => 'Bearer',
                'expires_in' => $token['exp'],
                'message' => 'Old token is active!'
            ]);
        }

        $newToken = Token::create(
            $token['user_id'],
            env('JWT_SECRET'),
            $time = $time + env('JWT_TTL'),
            env('APP_URL')
        );

        return response()->json([
            'access_token' => $newToken,
            'token_type' => 'Bearer',
            'expires_in' => $time,
            'message' => 'New token is generated!'
        ]);
    }
}
