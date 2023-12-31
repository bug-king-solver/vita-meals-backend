<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private UserService $userService;
    private AuthService $authService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->authService = new AuthService();
    }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized',
            ], 401);
        }
        $token = $this->authService->fetchAuthToken();

        $user = $this->authService->fetchAuthenticatedUser();

        return response()->json([
            'error' => false,
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => $this->authService->fetchTokenExpirationTime()
            ]
        ]);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = $this->userService->create($request->all());

        if (! $user) {
            return response()->json([
                'error' => true,
                'message' => 'User registration failed!'
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'User created successfully'
        ]);
    }

    public function signout()
    {
        $this->authService->logout();

        return response()->json([
            'error' => false,
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        if (!Auth::check()) {
            // Authenticate the user here using Auth::attempt or other methods
        }
        return response()->json([
            'error' => false,
            'user' => $this->authService->fetchAuthenticatedUser(),
            'authorisation' => [
                'token' => $this->authService->refreshToken(),
                'type' => 'bearer',
                'expires_in' => $this->authService->fetchTokenExpirationTime(),
            ]
        ]);
    }
}
