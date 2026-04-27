<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KalkulatorController;
use App\Http\Controllers\PerbandinganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;

// =====================
// REDIRECT DASHBOARD
// =====================
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('products.index');
})->middleware(['auth'])->name('dashboard');

// =====================
// PUBLIC ROUTES
// =====================
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('products.detail');
Route::get('/kalkulator', [KalkulatorController::class, 'index'])->name('calculator');
Route::post('/kalkulator', [KalkulatorController::class, 'calculate'])->name('calculator.calculate');
Route::get('/perbandingan', [PerbandinganController::class, 'index'])->name('products.comparison');

// =====================
// CUSTOMER ROUTES
// =====================
Route::middleware(['auth'])->group(function () {
    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::post('/keranjang/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/keranjang/hapus', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout & Pesanan
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/riwayat-pesanan', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Profil
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profil/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// =====================
// ADMIN ROUTES
// =====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Produk
    Route::get('/produk', [AdminController::class, 'products'])->name('products');
    Route::get('/produk/tambah', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/produk/tambah', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/produk/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::post('/produk/{id}/edit', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::post('/produk/{id}/hapus', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // Pesanan
    Route::get('/pesanan', [AdminController::class, 'orders'])->name('orders');
    Route::post('/pesanan/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    // Stok
    Route::get('/stok', [AdminController::class, 'stock'])->name('stock');
    Route::post('/stok/{id}', [AdminController::class, 'updateStock'])->name('stock.update');
});

require __DIR__.'/auth.php';