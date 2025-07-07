<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

use Illuminate\Support\Facades\Auth;  

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();                        // genera /register, /login, etc.

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
      ->name('home');