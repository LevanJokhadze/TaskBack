<?php

namespace App\services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function registerUser($username, $otp)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'username' => $username,
                'otp' => $otp,
            ]);

            DB::commit();

            return response()->json([
                "success" => true,
                "message" => "Redirecting to Password Page.",
                "user" => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Registration failed. Please try again.'], 500);
        }
    }
}
