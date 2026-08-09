<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('auth.login');

Route::get('/recover-password', function () {
    return view('auth.recover-password');
})->name('recover.password');

Route::get('/new-password', function () {
    return view('auth.new-password');
})->name('auth.new-password');
