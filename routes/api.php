<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\RegistrationController;

Route::get('account-types', [AccountTypeController::class, 'index']); // list of account types

Route::post('register', [RegistrationController::class, 'register']); // individual registration

Route::post('login', [LoginController::class, 'login']); // login

Route::middleware('auth:sanctum')->group(function ($router) {

    Route::get('logout', [LogoutController::class, 'logout']); // logout authenticated user
    
});