<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CMS\Auth\LoginController;
use App\Http\Controllers\CMS\Auth\LogoutController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\Modules\ShareController;
use App\Http\Controllers\CMS\Modules\UserController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/

Route::get('/locale/switch/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
Route::get('/app/clear', [AppController::class, 'clear'])->name('app.clear');
Route::get('/app/optimize', [AppController::class, 'optimize'])->name('app.optimize');

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
*/

Route::prefix('/system')->as('cms.')->middleware('locale.use:en')->group(function () {
    // CMS Guest
    Route::middleware('guest:cms')->group(function () {
        // CMS Login
        Route::prefix('/auth/login')->as('auth.login.')->group(function () {
            Route::get('/', [LoginController::class, 'index'])->name('index');
            Route::post('/process', [LoginController::class, 'process'])->name('process');
        });
    });

    // CMS Authenticated
    Route::middleware('auth:cms')->group(function () {
        // CMS Dashboard
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

        // CMS Module Users
        Route::prefix('/users')->as('users.')->group(function () {
            Route::post('/{user}/toggle', [UserController::class, 'toggle'])->name('toggle');
            Route::get('/excel', [UserController::class, 'excel'])->name('excel');
        });

        // CMS Module Files
        Route::prefix('/shares')->as('shares.')->group(function () {
            Route::post('/{share}/toggle', [ShareController::class, 'toggle'])->name('toggle');
        });

        // CMS Resources
        Route::resources([
            'users' => UserController::class,
            'shares' => ShareController::class
        ]);

        // CMS Logout
        Route::prefix('/auth/logout')->as('auth.logout.')->group(function () {
            Route::get('/', [LogoutController::class, 'process'])->name('process');
        });
    });
});

// Temporary Redirect
Route::redirect('/', '/system');
