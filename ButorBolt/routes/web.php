<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', [HomeController::class, 'show']);
Route::get('/register', [RegisterController::class, 'show']);
Route::get('/login', [LoginController::class, 'show']);
