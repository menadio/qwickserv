<?php

use App\Http\Controllers\v1\ConsentController;
use App\Http\Controllers\v1\LoginController;
use App\Http\Controllers\v1\LogoutController;
use App\Http\Controllers\v1\RegisterController;
use App\Http\Controllers\v1\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group( function () {

    Route::post('register', [RegisterController::class, 'register']); // register new user account

    Route::post('login', [LoginController::class, 'login']); // authenticate user

    Route::middleware('auth:sanctum')->group( function () {
        
        Route::post('logout', [LogoutController::class, 'logout']); // revoke authenticated user access token

        Route::post('verify', [VerificationController::class, 'verify']); // verify authenticated user email

        Route::get('verify/code', [VerificationController::class, 'resend']); // resend verification code

        Route::post('consent/accept', [ConsentController::class, 'accept']); // accept terms of use

        Route::post('consent/reject', [ConsentController::class, 'reject']); // reject terms of use

    });

});