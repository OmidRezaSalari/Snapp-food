<?php

namespace Authenticate\Facades;

use Tymon\JWTAuth\Facades\JWTAuth;

class BaseAuth
{

    public function check()
    {
        return auth()->check();
    }

    public function loginUsingId($uid)
    {
        $user = Auth::loginUsingId($uid);

        return $user->makeVisible(['api_token', 'role']);
    }


    public function Attempt($data)
    {

        $credentials = request(['username', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {

            return false;
        }

        return $token;
    }
}
