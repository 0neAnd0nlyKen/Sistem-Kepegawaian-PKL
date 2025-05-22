<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        Log::info('Login attempt', ['email' => $credentials['email'] ?? null, 'ip' => $request->ip()]);

        if (!Auth::attempt($credentials)) {
            Log::warning('Login failed', ['email' => $credentials['email'] ?? null, 'ip' => $request->ip()]);
            return response()->json(['message' => 'Unauthorized'], 401);
        }
            /** @var \App\Models\MyUserModel $user **/
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        Log::info('Login successful', ['user_id' => $user->id, 'email' => $user->email, 'ip' => $request->ip()]);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        Log::info('Logout', ['user_id' => $user->id, 'email' => $user->email, 'ip' => $request->ip()]);
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
