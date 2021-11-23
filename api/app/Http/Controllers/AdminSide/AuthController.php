<?php

namespace App\Http\Controllers\AdminSide;

use ReallySimpleJWT\Token;
use App\Services\UserService;
use App\Services\ReCaptchaService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;

class AuthController
{

    public UserService $userService;

    public ReCaptchaService $reCaptchaService;

    /**
     * __construct
     *
     * @param  mixed $userService
     * @return void
     */
    public function __construct(UserService $userService, ReCaptchaService $reCaptchaService)
    {
        $this->userService = $userService;
        $this->reCaptchaService = $reCaptchaService;
    }

    /**
     * @OA\Post(path="/auth/login",
     *   tags={"AdminSide Auth"},
     *   summary="Login user and use your JWT",
     *   operationId="loginUser",
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "andrejnankov@gmail.com", "password": "secret"}
     *             )
     *         )
     *     ),
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
     *   @OA\Response(response=422, description="Not Processable Entity"),
     *   @OA\Response(response=401, description="Invalid email or password."),
     *   @OA\Response(response=500, description="Internal Server error")
     * )
     */
    public function login(LoginRequest $request)
    {
        if (env('RECAPTCHA')) {
            $reCaptcha = $this->reCaptchaService->validateReCaptcha($request->convertToDto());
            if (!$reCaptcha['success']) {
                return response()->json(['message' => $reCaptcha['error-codes'][0]], 401);
            }
        }

        $user = $this->userService->findWhere('email', $request->convertToDto()->email);

        if (empty($user) || !Hash::check($request->convertToDto()->password, $user->password)) {
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
     * @OA\Post(path="/auth/refresh",
     *   tags={"AdminSide Auth"},
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
     *   @OA\Response(response=422, description="Not Processable Entity"),
     *   @OA\Response(response=500, description="Internal Server error| Invalid token signature")
     * )
     */
    public function refresh(RefreshTokenRequest $request)
    {
        $token = $request->convertToDto()->token;
        $time = time();

        // var_dump(date('h:i:sa',$time), date('h:i:sa', $token['exp']));

        // if ($time <= $token['exp']) {
        //     return response()->json([
        //         'access_token' => $request->getParams()->get('token'),
        //         'token_type' => 'Bearer',
        //         'expires_in' => $token['exp'],
        //         'message' => 'Old token is active!',
        //         'code' => 400
        //     ]);
        // }

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
            'message' => 'New token is generated!',
            'code' => 200
        ]);
    }
}
