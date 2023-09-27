<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

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
        $user = Auth::user();
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return $this->fetchAuthToken();
    }

    public function fetchTokenExpirationTime()
    {
        return Carbon::now()->addHours(2);
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