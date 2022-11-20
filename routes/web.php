<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'show'])->name('home');

Route::middleware('auth', 'verified')->group(function() {
    Route::get('/product-services/{id}', [ShopController::class, 'additionalServices'])->name('services');
    Route::any('/shopping-cart', [ShopController::class, 'cart'])->name('cart');
    Route::get('/add-product', [ShopController::class, 'create'])->name('create');
    Route::post('/add-product', [ShopController::class, 'store'])->name('store');
    Route::get('/edit-product/{id}', [ShopController::class, 'edit'])->name('edit');
    Route::post('/edit-product/{id}', [ShopController::class, 'update'])->name('update');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
