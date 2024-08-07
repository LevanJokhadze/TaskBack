<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StorePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Requests\SendEmailRequest;
use App\Http\Requests\CheckTokenRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPmail;

class UserController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $username = $request->username;
        $token = $request->token;
        try {
            $user = User::create([
                'username' => $username,
                'otp' => $token,
            ]);

            $response = [
                "message" => "Redirecting to Password Page.",
                "user" => $user
            ];


            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function sendEmail(SendEmailRequest $request) 
    {
        $to = $request->username; 
        $message = $request->href; 
    
        $details = [
            'title' => 'Mail from Laravel',
            'body' => $message
        ];
    
        Mail::to($to)->send(new OTPmail($details));
    
        return response()->json(['message' => 'Email sent successfully'], 200);
    }

    public function checkToken(CheckTokenRequest $request)
    {
        $otp = $request->otp;
    
        $otpRecord = User::where('otp', $otp)->first();
    
        if ($otpRecord) {
            return response()->json(['message' => 'OTP is valid', "success" => true, "data" => $otpRecord], 200);
        } else {
            return response()->json(['message' => 'OTP is invalid'], 404);
        }
    }


}
