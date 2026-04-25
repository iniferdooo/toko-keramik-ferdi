<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Daftarkan semua Livewire components
        Livewire::component('product-index', \App\Http\Livewire\ProductIndex::class);
        Livewire::component('product-detail', \App\Http\Livewire\ProductDetail::class);
        Livewire::component('product-comparison', \App\Http\Livewire\ProductComparison::class);
        Livewire::component('needs-calculator', \App\Http\Livewire\NeedsCalculator::class);
        Livewire::component('cart', \App\Http\Livewire\Cart::class);
        Livewire::component('checkout', \App\Http\Livewire\Checkout::class);
        Livewire::component('order-history', \App\Http\Livewire\OrderHistory::class);
        Livewire::component('admin.dashboard', \App\Http\Livewire\Admin\Dashboard::class);
        Livewire::component('admin.product-management', \App\Http\Livewire\Admin\ProductManagement::class);
        Livewire::component('admin.order-management', \App\Http\Livewire\Admin\OrderManagement::class);
        Livewire::component('admin.stock-update', \App\Http\Livewire\Admin\StockUpdate::class);
    }
}