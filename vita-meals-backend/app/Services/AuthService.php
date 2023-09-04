<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AuthService
{
    public function fetchAuthenticatedUser()
    {
        return Auth::user();
    }

    public function fetchAuthToken()
    {
        $user = Auth::user();
        $token = $user->createToken('AppName')->plainTextToken;
        return $token;
    }

    public function refreshToken()
    {
        return Auth::refresh();
    }

    public function fetchTokenExpirationTime()
    {
        return 200;
    }

    public function logout()
    {
        Auth::logout();
    }
}