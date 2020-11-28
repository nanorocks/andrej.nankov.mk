<?php

namespace App\Http\Controllers\AdminSide;

use App\Models\User;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;
use ReallySimpleJWT\Token;

class AuthController{

    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validate->fails()){
            return $validate->getMessageBag();
        }

        $user = User::where('email', $request->email)->first();

        if(!Hash::check($request->password, $user->password)){
            return response('Invalid email or password.', 401);
        }

        $userId = $user->id;
        $secret = env('JWT_SECRET');
        $time = time() + 3600;
        $issuer = 'localhost';
        $token = Token::create($userId, $secret, $time, $issuer);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $time
        ]);
    }

}

