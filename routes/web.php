
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;

// Login page
Route::get('/', [AuthController::class, 'index'])->name('login');

// Process login
Route::post('/shop', [AuthController::class, 'login'])->name('login.process');

// Register
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Protected pages (Login required)
Route::middleware('auth')->group(function () {

    // Shop page
    Route::get('/shop', [ShopController::class, 'shop'])
        ->name('shop');

    // Search
    Route::get('/search/{product_name}', [ShopController::class, 'search'])
        ->name('products.search');

    // Category
    Route::get('/category/{category}', [ShopController::class, 'category'])
        ->name('products.category');

    // My Orders page
    Route::get('/orders', [OrderController::class, 'orders'])
        ->name('orders');

});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
