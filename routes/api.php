<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\UserSkillController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\EmploymentTypeController;

Route::get('account-types', [AccountTypeController::class, 'index']); // get collectionn of account types

Route::get('employment-types', [EmploymentTypeController::class, 'index']); // get collection of employment types

Route::get('industries', [IndustryController::class, 'index']); // get collection of industries

Route::get('skills', [SkillController::class, 'index'])->name('skills.index'); // get collection of skills

Route::get('categories', [CategoryController::class, 'index'])->name('categories.index'); // get collection of categories

Route::post('register', [RegistrationController::class, 'register'])->name('register'); // individual registration

Route::post('login', [LoginController::class, 'login'])->name('login'); // login

Route::middleware('auth:sanctum')->group(function ($router) {

    Route::get('logout', [LogoutController::class, 'logout'])->name('logout'); // logout authenticated user

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // get user dashboard data

    Route::get('user/profile', [UserController::class, 'profile']); // retrieve user profile

    Route::put('user/profile', [UserController::class, 'update']); // update user profile

    Route::get('experiences', [ExperienceController::class, 'index'])->name('experience.index'); // retrieve user experiences collection

    Route::post('experiences', [ExperienceController::class, 'store'])->name('experience.store'); // store experience

    Route::put('experiences/{experience}', [ExperienceController::class, 'update'])->name('experience.update'); // update experience

    Route::delete('experiences/{experience}', [ExperienceController::class, 'destroy'])->name('experience.destroy'); // delete experience

    Route::get('user/skills', [UserSkillController::class, 'index'])->name('user.skills'); // retrievee user skills

    Route::post('user/skills', [UserSkillController::class, 'addSkills'])->name('skills.store'); // store a skill

    Route::delete('user/skills/{skill}', [UserSkillController::class, 'deleteSkill'])->name('delete.skill'); // delete a skill

    Route::get('user/portfolios', [PortfolioController::class, 'index'])->name('portfolios.list'); // retrieve user portfolio list

    Route::post('user/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store'); // add a portfolio

    Route::get('positions', [PositionController::class, 'index'])->name('positions.index'); // list job positions

    Route::post('positions', [PositionController::class, 'store'])->name('positions.store'); // store new position

    Route::get('positions/{position}', [PositionController::class, 'show'])->name('positions.show'); // show specific position

});