<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
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

Route::get('/?page={page}', [ShopController::class, 'show'])->name('page');
Route::any('/', [ShopController::class, 'show'])->name('main');
Route::post('/', [ShopController::class, 'show'])->name('filtering');
Route::any('/categories/{category}', [ShopController::class, 'show'])->name('categories');

Route::get('/google-auth/redirect', [UserController::class, 'googleAuth'])->name('authGoogle');
Route::get('/google-auth/callback', [UserController::class, 'googleAuthCallback']);

Route::middleware('auth', 'verified')->group(function () {
    Route::middleware('role:simple-user')->group(function () {
        Route::get('/product-services/{id}', [ShopController::class, 'additionalServices'])->name('services');
        Route::any('/shopping-cart', [ShopController::class, 'cart'])->name('cart');
        Route::post('/shopping-cart/delete/{id}', [ShopController::class, 'deleteFromCart'])->name('deleteFromCart');
    });
    Route::middleware('role:administrative-user')->group(function () {
        Route::get('/add-product', [ShopController::class, 'create'])->name('create');
        Route::post('/add-product', [ShopController::class, 'store'])->name('store');
        Route::get('/edit-product/{id}', [ShopController::class, 'edit'])->name('edit');
        Route::post('/edit-product/{id}', [ShopController::class, 'update'])->name('update');
        Route::post('/delete-product/{id}', [ShopController::class, 'delete'])->name('delete');
        Route::post('/send-prices', [ShopController::class, 'sendPricesToRabbit'])->name('sendPrices');
        Route::get('/show-exports', [ShopController::class, 'showExports'])->name('showExports');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
