@extends('layouts.main')

@section('content')
<div>
    {{-- HERO --}}
    <div class="bg-gradient-to-r from-orange-500 to-orange-700 text-white rounded-2xl p-8 mb-8">
        <h1 class="text-3xl font-bold mb-1">🏺 Toko Keramik Ferdi</h1>
        <p class="text-orange-100 mb-4">Keramik berkualitas untuk rumah impian Anda</p>
        <form method="GET" action="/produk">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="🔍 Cari nama, motif, warna keramik..."
                class="w-full max-w-lg px-4 py-3 rounded-xl text-gray-800 focus:outline-none"
            />
        </form>
    </div>

    <div class="flex gap-6">
        {{-- SIDEBAR --}}
        <div class="w-56 flex-shrink-0">
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-gray-700">Filter</h3>
                    <a href="/produk" class="text-xs text-orange-500 hover:underline">Reset</a>
                </div>

                <form method="GET" action="/produk" id="filterForm">
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <p class="text-sm font-semibold text-gray-600 mb-2">🗂️ Kategori</p>
                    <div class="space-y-1 mb-4">
                        <label class="flex items-center gap-2 cursor-pointer text-sm">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                            <span>Semua</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center gap-2 cursor-pointer text-sm">
                            <input type="radio" name="category" value="{{ $cat->slug }}"
                                {{ request('category') == $cat->slug ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <span>{{ $cat->icon }} {{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>

                    <p class="text-sm font-semibold text-gray-600 mb-2">📐 Ukuran</p>
                    <select name="size" class="w-full border rounded-lg px-2 py-2 text-sm mb-4" onchange="this.form.submit()">
                        <option value="">Semua Ukuran</option>
                        @foreach($sizes as $s)
                        <option value="{{ $s }}" {{ request('size') == $s ? 'selected' : '' }}>{{ $s }} cm</option>
                        @endforeach
                    </select>

                    <p class="text-sm font-semibold text-gray-600 mb-2">✨ Finish</p>
                    <select name="finish" class="w-full border rounded-lg px-2 py-2 text-sm" onchange="this.form.submit()">
                        <option value="">Semua Finish</option>
                        <option value="Glossy" {{ request('finish') == 'Glossy' ? 'selected' : '' }}>Glossy</option>
                        <option value="Matte" {{ request('finish') == 'Matte' ? 'selected' : '' }}>Matte</option>
                        <option value="Anti Slip" {{ request('finish') == 'Anti Slip' ? 'selected' : '' }}>Anti Slip</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- PRODUK --}}
        <div class="flex-1">
            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-500 text-sm">
                    Ditemukan <strong>{{ $products->total() }}</strong> produk
                </p>
                <form method="GET" action="/produk">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="size" value="{{ request('size') }}">
                    <input type="hidden" name="finish" value="{{ request('finish') }}">
                    <select name="sort" class="border rounded-lg px-3 py-2 text-sm" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                    </select>
                </form>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-xl shadow">
                    <p class="text-6xl mb-4">😔</p>
                    <p class="text-gray-500 text-lg">Produk tidak ditemukan</p>
                    <a href="/produk" class="mt-4 inline-block bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">
                        Reset Filter
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden group">
                        <div class="bg-gray-100 h-44 flex items-center justify-center overflow-hidden relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <span class="text-6xl">🏺</span>
                            @endif
                            @if($product->stock == 0)
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-bold">HABIS</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <span class="text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">
                                {{ $product->category->name }}
                            </span>
                            <h3 class="font-semibold text-gray-800 mt-1 text-sm leading-tight">
                                {{ $product->name }}
                            </h3>
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-400">{{ $product->size }} cm</span>
                                <span class="text-xs text-gray-400">{{ $product->finish }}</span>
                            </div>
                            <p class="text-orange-600 font-bold mt-2 text-sm">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                <span class="text-xs text-gray-400 font-normal">/pcs</span>
                            </p>
                            @if($product->stock > 10)
                                <p class="text-xs text-green-600">✅ Stok: {{ $product->stock }}</p>
                            @elseif($product->stock > 0)
                                <p class="text-xs text-yellow-600">⚠️ Terbatas: {{ $product->stock }}</p>
                            @else
                                <p class="text-xs text-red-500">❌ Habis</p>
                            @endif
                            <a href="{{ route('products.detail', $product->id) }}"
                               class="block mt-2 bg-orange-500 text-white text-center py-2 rounded-lg text-sm hover:bg-orange-600 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection