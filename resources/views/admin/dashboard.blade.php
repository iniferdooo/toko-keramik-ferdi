@extends('layouts.main')

@section('content')
<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">⚡ Admin Dashboard</h1>
            <p class="text-gray-400 text-sm">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
        <div class="text-sm text-gray-400 bg-white border border-gray-100 rounded-xl px-4 py-2 shadow-sm">
            📅 {{ now()->format('d M Y') }}
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 card-hover">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center shadow-lg mb-3">
                <span class="text-2xl">🏺</span>
            </div>
            <p class="text-2xl font-extrabold text-gray-800 mb-1">{{ $totalProducts }}</p>
            <p class="text-sm text-gray-400">Total Produk</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 card-hover">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg mb-3">
                <span class="text-2xl">📦</span>
            </div>
            <p class="text-2xl font-extrabold text-gray-800 mb-1">{{ $totalOrders }}</p>
            <p class="text-sm text-gray-400">Total Pesanan</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 card-hover">
            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg mb-3">
                <span class="text-2xl">👥</span>
            </div>
            <p class="text-2xl font-extrabold text-gray-800 mb-1">{{ $totalCustomers }}</p>
            <p class="text-sm text-gray-400">Total Customer</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 card-hover">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center shadow-lg mb-3">
                <span class="text-2xl">💰</span>
            </div>
            <p class="text-xl font-extrabold text-gray-800 mb-1">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </p>
            <p class="text-sm text-gray-400">Total Pendapatan</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('admin.products.create') }}"
           class="flex items-center gap-3 bg-orange-50 border-2 border-orange-200 text-orange-600 hover:bg-orange-100 rounded-2xl p-4 transition font-semibold text-sm card-hover">
            <span class="text-2xl">➕</span> Tambah Produk
        </a>
        <a href="{{ route('admin.products') }}"
           class="flex items-center gap-3 bg-blue-50 border-2 border-blue-200 text-blue-600 hover:bg-blue-100 rounded-2xl p-4 transition font-semibold text-sm card-hover">
            <span class="text-2xl">🏺</span> Kelola Produk
        </a>
        <a href="{{ route('admin.orders') }}"
           class="flex items-center gap-3 bg-green-50 border-2 border-green-200 text-green-600 hover:bg-green-100 rounded-2xl p-4 transition font-semibold text-sm card-hover">
            <span class="text-2xl">📦</span> Lihat Pesanan
        </a>
        <a href="{{ route('admin.stock') }}"
           class="flex items-center gap-3 bg-purple-50 border-2 border-purple-200 text-purple-600 hover:bg-purple-100 rounded-2xl p-4 transition font-semibold text-sm card-hover">
            <span class="text-2xl">📊</span> Kelola Stok
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Pesanan Terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-5">
                <h2 class="font-extrabold text-gray-800">📦 Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders') }}" class="text-orange-500 text-sm font-semibold hover:underline">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recentOrders as $order)
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl hover:bg-orange-50 transition">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                        #{{ $order->id }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm truncate">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-extrabold text-orange-600 text-sm">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </p>
                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold
                            {{ $order->status == 'pending'    ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $order->status == 'confirmed'  ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $order->status == 'processing' ? 'bg-indigo-100 text-indigo-700' : '' }}
                            {{ $order->status == 'shipped'    ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $order->status == 'delivered'  ? 'bg-green-100 text-green-700' : '' }}
                            {{ $order->status == 'cancelled'  ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-4xl mb-2">📭</p>
                    <p class="text-gray-400 text-sm">Belum ada pesanan</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Stok Menipis --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-5">
                <h2 class="font-extrabold text-gray-800">⚠️ Stok Menipis</h2>
                <a href="{{ route('admin.stock') }}" class="text-orange-500 text-sm font-semibold hover:underline">
                    Kelola →
                </a>
            </div>
            <div class="space-y-3">
                @forelse($lowStock as $product)
                <div class="flex items-center gap-3 p-3 bg-red-50 rounded-xl border border-red-100">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0 shadow-sm">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-xl">🏺</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm truncate">{{ $product->name }}</p>
                        <p class="text-xs text-gray-400">{{ $product->category->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-extrabold text-red-600">{{ $product->stock }}</p>
                        <p class="text-xs text-red-400">pcs</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-4xl mb-2">✅</p>
                    <p class="text-gray-400 text-sm">Semua stok aman!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection