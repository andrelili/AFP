<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BagCheckoutController;

Route::get('/', [HomeController::class, 'show'])->name('home');
Route::match(['get', 'post'], '/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::get('/bag-checkout', [BagCheckoutController::class, 'show'])->name('bag.checkout');
