<?php

namespace App\Http\Controllers;

use App\Models\verified;
use App\Http\Requests\StoreverifiedRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VerifiedController extends Controller
{
    public function verifyUser(StoreverifiedRequest $request)
    {
        $username = $request->username;
        $password = $request->password;

        try {
            $user = verified::create([
                'username' => $username,
                'password' => $password,
            ]);

            $response = [
                "message" => "UserVerified",
                "user" => $user
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details',
                "data" => $request->only('username'),
                "password" => $request->only('password')
            ], 401);
        }

        $user = verified::where('username', $request['username'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $request->user()->currentAccessToken()->delete();
    
        return response()->json(['message' => 'Logged out successfully']);
    }
    
}
