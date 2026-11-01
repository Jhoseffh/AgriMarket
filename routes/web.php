
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

// Protected pages
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

    // My Stock / My Orders page
    Route::get('/orders', [OrderController::class, 'orders'])
        ->name('orders');

    // Add a product
    Route::post('/orders/products', [OrderController::class, 'addProduct'])
        ->name('orders.products.add');

    // Increase or decrease quantity
    Route::patch('/orders/products/{productId}/quantity', [OrderController::class, 'updateQuantity'])
        ->name('orders.products.quantity');

    // Remove a product
    Route::delete('/orders/products/{productId}', [OrderController::class, 'removeProduct'])
        ->name('orders.products.remove');

    // Order Summary page
    Route::post('/ordersummary', [OrderController::class, 'orderSummary'])
    ->name('ordersummary');

    // Store order request
    Route::post('/orders/store', [OrderController::class, 'storeOrder'])
        ->name('orders.store');
    
    // Accept an order request.
    Route::patch('/orders/requests/{requestId}/accept', [OrderController::class, 'acceptOrderRequest'])
        ->name('orders.requests.accept');

    // Decline an order request.
    Route::patch('/orders/requests/{requestId}/decline', [OrderController::class, 'declineOrderRequest'])
        ->name('orders.requests.decline');

});


// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
