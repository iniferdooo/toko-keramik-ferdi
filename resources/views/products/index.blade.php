@extends('layouts.main')

@section('content')
<div>
    {{-- HERO --}}
    <div class="gradient-hero text-white rounded-3xl p-10 mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-32 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full translate-y-24 -translate-x-24"></div>
        <div class="relative z-10">
            <div class="inline-block bg-white bg-opacity-20 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4">
                ✨ Premium Ceramic Store
            </div>
            <h1 class="text-4xl font-extrabold mb-2">Temukan Keramik<br>Impian Kamu 🏺</h1>
            <p class="text-orange-100 mb-6 text-lg">Koleksi lengkap untuk lantai, dinding, kamar mandi & lebih!</p>
            <form method="GET" action="/produk" class="relative max-w-xl">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari keramik, motif, warna..."
                       class="w-full pl-12 pr-4 py-4 rounded-2xl text-gray-800 font-medium focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-30 shadow-xl text-base">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    {{-- KATEGORI SHORTCUT --}}
    <div class="flex gap-3 mb-6 overflow-x-auto pb-2">
        <a href="/produk" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-semibold {{ !request('category') ? 'bg-orange-500 text-white shadow-lg' : 'bg-white text-gray-600 shadow hover:bg-orange-50' }} transition">
            🏠 Semua
        </a>
        @foreach($categories as $cat)
        <a href="/produk?category={{ $cat->slug }}" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-semibold {{ request('category') == $cat->slug ? 'bg-orange-500 text-white shadow-lg' : 'bg-white text-gray-600 shadow hover:bg-orange-50' }} transition">
            {{ $cat->icon }} {{ $cat->name }}
        </a>
        @endforeach
    </div>

    <div class="flex gap-6">

        {{-- SIDEBAR FILTER --}}
        <div class="w-56 flex-shrink-0 hidden md:block">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-24">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800">Filter</h3>
                    <a href="/produk" class="text-xs text-orange-500 hover:underline font-medium">Reset</a>
                </div>

                <form method="GET" action="/produk" id="filterForm">
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Ukuran</p>
                    <select name="size" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm mb-4 focus:outline-none focus:ring-2 focus:ring-orange-300" onchange="this.form.submit()">
                        <option value="">Semua Ukuran</option>
                        @foreach($sizes as $s)
                        <option value="{{ $s }}" {{ request('size') == $s ? 'selected' : '' }}>{{ $s }} cm</option>
                        @endforeach
                    </select>

                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Finish</p>
                    <div class="space-y-2 mb-4">
                        @foreach(['Glossy' => '✨', 'Matte' => '🪨', 'Anti Slip' => '🛡️'] as $finish => $icon)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="finish" value="{{ $finish }}"
                                   {{ request('finish') == $finish ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="accent-orange-500">
                            <span class="text-sm text-gray-600">{{ $icon }} {{ $finish }}</span>
                        </label>
                        @endforeach
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="finish" value=""
                                   {{ !request('finish') ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="accent-orange-500">
                            <span class="text-sm text-gray-600">Semua</span>
                        </label>
                    </div>
                </form>
            </div>
        </div>

        {{-- KONTEN PRODUK --}}
        <div class="flex-1">

            {{-- Sort & Total --}}
            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-500 text-sm">
                    <span class="font-bold text-gray-800">{{ $products->total() }}</span> produk ditemukan
                </p>
                <form method="GET" action="/produk">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="size" value="{{ request('size') }}">
                    <input type="hidden" name="finish" value="{{ request('finish') }}">
                    <select name="sort" class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300" onchange="this.form.submit()">
                        <option value="latest">✨ Terbaru</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>💰 Termurah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>💎 Termahal</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>🔤 A-Z</option>
                    </select>
                </form>
            </div>

            {{-- Kosong --}}
            @if($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-7xl mb-4">🔍</p>
                    <p class="text-gray-700 font-bold text-xl mb-2">Produk tidak ditemukan</p>
                    <p class="text-gray-400 mb-6">Coba kata kunci lain atau reset filter</p>
                    <a href="/produk" class="bg-orange-500 text-white px-6 py-3 rounded-xl hover:bg-orange-600 transition font-semibold">
                        Reset Filter
                    </a>
                </div>
            @else
                {{-- Grid Produk --}}
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover group flex flex-col">

                        {{-- Gambar --}}
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 h-48 flex items-center justify-center overflow-hidden relative flex-shrink-0">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <span class="text-6xl group-hover:scale-110 transition duration-300">🏺</span>
                            @endif

                            @if($product->stock == 0)
                                <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                                    <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-bold tracking-wider">HABIS</span>
                                </div>
                            @elseif($product->stock <= 10)
                                <div class="absolute top-2 right-2">
                                    <span class="bg-yellow-400 text-yellow-900 text-xs px-2 py-0.5 rounded-full font-bold badge-pulse">Terbatas!</span>
                                </div>
                            @endif

                            <div class="absolute top-2 left-2">
                                <span class="bg-white bg-opacity-90 text-orange-600 text-xs px-2 py-0.5 rounded-full font-semibold shadow">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                        </div>

                        {{-- Konten --}}
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-bold text-gray-800 text-sm leading-tight mb-2 line-clamp-2 flex-1">
                                {{ $product->name }}
                            </h3>

                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-lg">{{ $product->size }} cm</span>
                                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-lg">{{ $product->finish }}</span>
                            </div>

                            <p class="text-orange-600 font-extrabold text-base mb-1">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                <span class="text-xs text-gray-400 font-normal">/pcs</span>
                            </p>

                            @if($product->stock > 10)
                                <p class="text-xs text-green-600 font-medium mb-3">✅ Stok {{ $product->stock }}</p>
                            @elseif($product->stock > 0)
                                <p class="text-xs text-yellow-600 font-medium mb-3">⚠️ Sisa {{ $product->stock }}</p>
                            @else
                                <p class="text-xs text-red-500 font-medium mb-3">❌ Habis</p>
                            @endif

                            <a href="{{ route('products.detail', $product->id) }}"
                               class="block bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg hover:scale-105 transition duration-200 mt-auto">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                <div class="mt-10 mb-4">
                    {{ $products->links() }}
                </div>

            @endif

        </div>
    </div>
</div>
@endsection