<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Laravel\Sanctum\PersonalAccessToken;

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
        $user = Auth::user();
        // Revoke all of the user's tokens (log them out from all devices).
        $user->tokens->each(function (PersonalAccessToken $token) {
            $token->delete();
        });
    }
}