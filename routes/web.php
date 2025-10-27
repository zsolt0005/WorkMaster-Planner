<?php

use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('index');
})->name('index');

Route::get('/dashboard', static function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/people_management', static function () {
    return view('people_management');
})->name('people_management');

Route::get('/profile', static function () {
    return view('profile');
})->name('profile');
