<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiAuthService
{
    public function register($name,$email,$password)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }

    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return ['result' => false, 'message' => 'Invalid credentials'];
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'result' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ];
    }
}
