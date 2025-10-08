<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

Route::get('/', function() {
    return redirect('/register');
});

Route::get('/register', [RegisterController::class, 'show']);
