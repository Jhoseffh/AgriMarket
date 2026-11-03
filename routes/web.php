<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

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

    // Accept an order request
    Route::patch('/orders/requests/{requestId}/accept', [OrderController::class, 'acceptOrderRequest'])
        ->name('orders.requests.accept');

    // Decline an order request
    Route::patch('/orders/requests/{requestId}/decline', [OrderController::class, 'declineOrderRequest'])
        ->name('orders.requests.decline');

    // Settings page
    Route::get('/settings', [UserController::class, 'settings'])
        ->name('settings');

    // Settings updates
    Route::post('/settings/name', [UserController::class, 'updateName'])
        ->name('settings.update-name');

    Route::post('/settings/password', [UserController::class, 'updatePassword'])
        ->name('settings.update-password');

    Route::post('/settings/real-name', [UserController::class, 'updateRealName'])
        ->name('settings.update-real-name');

    Route::post('/settings/email', [UserController::class, 'updateEmail'])
        ->name('settings.update-email');

    Route::post('/settings/phone', [UserController::class, 'updatePhone'])
        ->name('settings.update-phone');

    Route::post('/settings/bio', [UserController::class, 'updateBio'])
        ->name('settings.update-bio');

    // Saved address management
    Route::post('/settings/addresses', [UserController::class, 'storeAddress'])
        ->name('settings.addresses.store');

    Route::patch('/settings/addresses/{slot}/active', [UserController::class, 'selectAddress'])
        ->name('settings.addresses.select');

    Route::delete('/settings/addresses/{slot}', [UserController::class, 'deleteAddress'])
        ->name('settings.addresses.delete');

    // Cart / My Purchases page
    Route::get('/cart', [OrderController::class, 'cart'])
        ->name('cart');
    
    // Cancel a pending purchase (buyer)
    Route::delete('/orders/purchases/{requestId}/cancel', [OrderController::class, 'cancelPurchase'])
        ->name('orders.cancelPurchase');

    // Add to Cart
    Route::post('/cart/add', [CartController::class, 'addToCart'])
        ->name('cart.add');

     // Get cart items from database
    Route::get('/cart/items', [CartController::class, 'getCartItems'])
        ->name('cart.items');

    // Remove an item from cart
    Route::delete('/cart/remove/{cartId}', [CartController::class, 'removeFromCart'])
        ->name('cart.remove');

    // Profile page
    Route::get('/profile', [UserController::class, 'profile'])
        ->name('profile');

    // Update profile picture
    Route::post('/profile/picture', [UserController::class, 'updateProfilePicture'])
        ->name('profile.update-picture');

    // Report page
    Route::get('/report', [UserController::class, 'report'])
        ->name('report');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
