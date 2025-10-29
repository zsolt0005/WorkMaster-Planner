<?php declare(strict_types=1);

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeopleManagementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(static function () {
    Route::get('/login', [LoginController::class, 'default'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [CalendarController::class, 'default'])->name('calendar');
    Route::get('/dashboard', [DashboardController::class, 'default'])->name('dashboard');
    Route::get('/people_management', [PeopleManagementController::class, 'default'])->name('people_management');
    Route::get('/profile', [ProfileController::class, 'default'])->name('profile');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
