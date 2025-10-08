<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

Route::view('/', 'home')->name('home');          
Route::view('/register', 'register')->name('register'); 
Route::view('/welcome', 'welcome')->name('welcome');

Route::get('/register', [RegisterController::class, 'show']);
