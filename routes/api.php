<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifiedController;
use App\Http\Controllers\UploadStudentController;
use App\Http\Controllers\DocumentController;

Route::get('/test', function() {
    return response()->json(['message' => 'Test route reached']);
});

// Registers an User
Route::post('/register', [UserController::class, 'register']);

// Check Token
Route::post('/check-token', [UserController::class, 'checkToken']);

// Verifie User
Route::post('/verify', [VerifiedController::class, 'verifyUser']);

// Sends an Email
Route::post('/email', [UserController::class, 'sendEmail']);

// Upload Student
Route::post('/upload', [UploadStudentController::class, 'upload']);

// Get Students
Route::post('/students', [UploadStudentController::class, 'index']);

// Edit Document
Route::post('/edit-document', [DocumentController::class, 'editDocument']);

//upload document
Route::post('/upload-document', [DocumentController::class, 'upload']);

//upload document
// Route::post('/upload-document', [DocumentController::class, 'upload']);

// Check job status

Route::middleware('throttle:12,1')->group(function () {
    Route::post('/login', [VerifiedController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::post('/logout', [VerifiedController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
