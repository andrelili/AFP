<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BagCheckoutController;
use App\Http\Controllers\SuccessfulOrderController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'show'])->name('home');
Route::match(['get', 'post'], '/register', [RegisterController::class, 'register'])->name('register');
Route::get('/bag-checkout', [BagCheckoutController::class, 'show'])->name('bag.checkout');
Route::get('/items/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('items.show');
Route::get('/successful-order', [SuccessfulOrderController::class, 'show'])->name('successful.order');
Route::get('/favorites', [FavoritesController::class, 'show'])->name('favorites.show');

Route::get('/', [HomeController::class, 'show'])->name('home');
Route::get('/items/{id}', [ItemController::class, 'show'])->name('items.show');

Route::get('/bag', [BagCheckoutController::class, 'index'])->name('bag.index');
Route::post('/bag/add/{id}', [BagCheckoutController::class, 'add'])->name('bag.add');
Route::post('/bag/update/{id}', [BagCheckoutController::class, 'update'])->name('bag.update');
Route::post('/bag/remove/{id}', [BagCheckoutController::class, 'remove'])->name('bag.remove');
Route::post('/bag/clear', [BagCheckoutController::class, 'clear'])->name('bag.clear');
Route::post('/bag/order', [BagCheckoutController::class, 'order'])->name('bag.order');


Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
Route::post('/admin/update', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
