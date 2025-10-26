<?php

use Illuminate\Support\Facades\Route;

// index
Route::get('/', static function () {
    return view('index');
})->name('index');

// dashboard
Route::get('/dashboard', static function () {
    return view('dashboard');
})->name('dashboard');

// people_management
Route::get('/people_management', static function () {
    return view('people_management');
})->name('people_management');

// profile
Route::get('/profile', static function () {
    return view('profile');
})->name('profile');
