<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/test', function() {
    return response()->json(['message' => 'Test route reached']);
});

Route::post('/register', [UserController::class, 'register']);

Route::post('/register/{username}', [UserController::class, 'registerPassword']);
Route::middleware('throttle:12,1')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
