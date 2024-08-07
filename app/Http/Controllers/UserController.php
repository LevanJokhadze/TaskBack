<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\SendEmailRequest;
use App\Http\Requests\CheckTokenRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPmail;
use App\services\UserService;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(StoreUserRequest $request)
    {
        $username = $request->username;
        $token = $request->token;
        $response = $this->userService->registerUser($username, $token);

        return $response;
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
