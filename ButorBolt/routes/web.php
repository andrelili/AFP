<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;


Route::get('/', [HomeController::class, 'show']);
Route::get('/register', [RegisterController::class, 'show']);
