<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BagCheckoutController;
use App\Http\Controllers\SuccessfulOrderController;
use App\Http\Controllers\FavouritesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;


Route::get('/', [HomeController::class, 'show'])->name('home');
Route::match(['get', 'post'], '/register', [RegisterController::class, 'register'])->name('register');
Route::get('/bag-checkout', [BagCheckoutController::class, 'show'])->name('bag.checkout');
Route::get('/items/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('items.show');
Route::get('/successful-order', [SuccessfulOrderController::class, 'show'])->name('successful.order');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');

Route::get('/', [HomeController::class, 'show'])->name('home');
Route::get('/items/{id}', [ItemController::class, 'show'])->name('items.show');

Route::get('/bag', [BagCheckoutController::class, 'index'])->name('bag.index');
Route::post('/bag/add/{id}', [BagCheckoutController::class, 'add'])->name('bag.add');
Route::post('/bag/update/{id}', [BagCheckoutController::class, 'update'])->name('bag.update');
Route::post('/bag/remove/{id}', [BagCheckoutController::class, 'remove'])->name('bag.remove');
Route::post('/bag/clear', [BagCheckoutController::class, 'clear'])->name('bag.clear');
Route::post('/bag/order', [BagCheckoutController::class, 'order'])->name('bag.order');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/order/successful', function () {
    return view('successful-order');
})->name('successful.order');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
Route::post('/admin/update', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.delete');


Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/favorites', [FavouritesController::class, 'show'])->name('favorites.show');
Route::get('/favourites', [FavouritesController::class, 'index'])->name('favourites.index');
Route::post('/favourites/add/{id}', [FavouritesController::class, 'add'])->name('favourites.add');
Route::delete('/favourites/{id}', [FavouritesController::class, 'remove'])->name('favourites.remove');
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/kep', [ProfileController::class, 'updatePicture'])->name('profile.updatePicture');
});
