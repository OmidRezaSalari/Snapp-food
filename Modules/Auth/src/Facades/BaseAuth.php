<?php

namespace Authenticate\Facades;

use Tymon\JWTAuth\Facades\JWTAuth;

class BaseAuth
{
    public function Attempt($data)
    {
        return JWTAuth::attempt($data) ?? false;
    }
}
