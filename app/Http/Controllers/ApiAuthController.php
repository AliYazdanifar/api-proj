<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->authService = app('App\Services\ApiAuthService');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $this->authService->register(
            $request->name,
            $request->email,
            $request->password
        );

        return response()->json([
            'result' => true,
            'message' => 'User registered successfully',
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $loginResult = $this->authService->login($request->email, $request->password);

        if ($loginResult['result']) {
            return response()->json([
                'result' => true,
                'message' => $loginResult['message'],
                'token' => $loginResult['token'],
                'user' => $loginResult['user'],
            ]);
        }

        return response()->json([
            'result' => false,
            'message' => $loginResult['message'],
        ], 401);

    }

    public function tokenInfo(Request $request)
    {
        return response()->json($request->user()->currentAccessToken());
    }
}
