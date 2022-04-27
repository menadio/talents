<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\EmploymentTypeController;

Route::get('account-types', [AccountTypeController::class, 'index']); // get collectionn of account types

Route::get('employment-types', [EmploymentTypeController::class, 'index']); // get collection of employment types

Route::get('industries', [IndustryController::class, 'index']); // get collection of industries

Route::post('register', [RegistrationController::class, 'register']); // individual registration

Route::post('login', [LoginController::class, 'login']); // login

Route::middleware('auth:sanctum')->group(function ($router) {

    Route::get('logout', [LogoutController::class, 'logout']); // logout authenticated user

    Route::get('user/profile', [UserController::class, 'profile']); // retrieve user profile

    Route::put('user/profile', [UserController::class, 'update']); // update user profile

    Route::get('experiences', [ExperienceController::class, 'index'])->name('experience.index'); // retrieve user experiences collection

    Route::post('experiences', [ExperienceController::class, 'store'])->name('experience.store'); // store experience

    Route::put('experiences/{experience}', [ExperienceController::class, 'update'])->name('experience.update'); // update experience

    Route::delete('experiences/{experience}', [ExperienceController::class, 'destroy'])->name('experience.destroy'); // delete experience

});