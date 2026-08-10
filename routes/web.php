<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WaterIntakeController;
use App\Http\Controllers\BmiController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AchievementController;

use App\Http\Controllers\Admin\AdminController;


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');

});


/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store']);

});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
|
| Available to normal users and administrators.
|
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | WORKOUTS
    |--------------------------------------------------------------------------
    */

    Route::get('/workouts', [WorkoutController::class, 'index'])
        ->name('workouts.index');

    Route::post('/workouts', [WorkoutController::class, 'store'])
        ->name('workouts.store');

    Route::delete('/workouts/{workout}', [WorkoutController::class, 'destroy'])
        ->name('workouts.destroy');


    /*
    |--------------------------------------------------------------------------
    | WATER INTAKE
    |--------------------------------------------------------------------------
    */

    Route::get('/water', [WaterIntakeController::class, 'index'])
        ->name('water.index');

    Route::post('/water', [WaterIntakeController::class, 'store'])
        ->name('water.store');

    Route::delete('/water/{waterIntake}', [WaterIntakeController::class, 'destroy'])
        ->name('water.destroy');


    /*
    |--------------------------------------------------------------------------
    | BMI
    |--------------------------------------------------------------------------
    */

    Route::get('/bmi', [BmiController::class, 'index'])
        ->name('bmi.index');

    Route::post('/bmi', [BmiController::class, 'calculate'])
        ->name('bmi.calculate');


    /*
    |--------------------------------------------------------------------------
    | DAILY PROGRESS
    |--------------------------------------------------------------------------
    */

    Route::get('/progress', [ProgressController::class, 'index'])
        ->name('progress.index');

    Route::post('/progress', [ProgressController::class, 'store'])
        ->name('progress.store');


    /*
    |--------------------------------------------------------------------------
    | GOALS
    |--------------------------------------------------------------------------
    */

    Route::get('/goals', [GoalController::class, 'index'])
        ->name('goals.index');

    Route::post('/goals', [GoalController::class, 'store'])
        ->name('goals.store');

    Route::patch('/goals/{goal}', [GoalController::class, 'update'])
        ->name('goals.update');

    Route::delete('/goals/{goal}', [GoalController::class, 'destroy'])
        ->name('goals.destroy');


    /*
    |--------------------------------------------------------------------------
    | ACHIEVEMENTS
    |--------------------------------------------------------------------------
    */

    Route::get('/achievements', [AchievementController::class, 'index'])
        ->name('achievements.index');


    /*
    |--------------------------------------------------------------------------
    | PREMIUM PAGE
    |--------------------------------------------------------------------------
    |
    | Authenticated users can view the Premium page and start payment.
    |
    */

    Route::get('/premium', [PremiumController::class, 'index'])
        ->name('premium.index');

    Route::get('/premium/pay', [PremiumController::class, 'initializePayment'])
        ->name('premium.pay');

    Route::get('/premium/callback', [PremiumController::class, 'callback'])
        ->name('premium.callback');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');


    /*
    |--------------------------------------------------------------------------
    | PREMIUM-ONLY ROUTES
    |--------------------------------------------------------------------------
    |
    | ONLY users whose hasPremium() returns true can access these.
    |
    */

    Route::middleware('premium')->group(function () {

        /*
        | AI COACH
        */

        Route::get('/ai-coach', [AIController::class, 'coach'])
            ->name('ai.coach');

        Route::post('/ai-coach', [AIController::class, 'chat'])
            ->name('ai.chat');


        /*
        | ANALYTICS
        */

        Route::get('/analytics', [AnalyticsController::class, 'index'])
            ->name('analytics');

    });

});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
|
| ONLY administrators can access these routes.
|
*/

Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | USER MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [AdminController::class, 'users'])
            ->name('users');


        /*
        |--------------------------------------------------------------------------
        | ADMIN PREMIUM TOGGLE
        |--------------------------------------------------------------------------
        */

        Route::post('/users/{user}/premium', [AdminController::class, 'togglePremium'])
            ->name('premium.toggle');


        /*
        |--------------------------------------------------------------------------
        | DELETE USER
        |--------------------------------------------------------------------------
        */

        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])
            ->name('users.destroy');

    });