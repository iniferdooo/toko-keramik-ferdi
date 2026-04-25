<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminController;

// Redirect dashboard
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('products.index');
})->middleware(['auth'])->name('dashboard');

// PUBLIC ROUTES
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('products.detail');
Route::get('/kalkulator', function () {
    return view('calculator');
})->name('calculator');
Route::get('/perbandingan', function () {
    return view('product-comparison');
})->name('products.comparison');

// CUSTOMER ROUTES
Route::middleware(['auth'])->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
    Route::get('/checkout', function () {
        return view('checkout');
    })->name('checkout');
    Route::get('/riwayat-pesanan', [OrderController::class, 'history'])->name('orders.history');
});

// ADMIN ROUTES
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/produk', [AdminController::class, 'products'])->name('products');
    Route::get('/pesanan', [AdminController::class, 'orders'])->name('orders');
    Route::get('/stok', [AdminController::class, 'stock'])->name('stock');
});

require __DIR__.'/auth.php';