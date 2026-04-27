@extends('layouts.main')

@section('content')
<div>
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
            <span class="text-2xl">🛒</span>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Keranjang Belanja</h1>
            <p class="text-gray-400 text-sm">{{ count($cart) }} produk dipilih</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-2xl mb-6 font-medium text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-2xl mb-6 font-medium text-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if(empty($cart))
        <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
            <p class="text-8xl mb-6">🛒</p>
            <p class="text-2xl font-extrabold text-gray-700 mb-2">Keranjang Kosong</p>
            <p class="text-gray-400 mb-8">Yuk belanja dulu, banyak pilihan keramik keren!</p>
            <a href="/produk" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-xl hover:scale-105 transition text-lg">
                🏺 Lihat Produk
            </a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- Cart Items --}}
            <div class="flex-1 space-y-4">
                @foreach($cart as $id => $item)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-4 card-hover">

                    {{-- Gambar --}}
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                        @if(!empty($item['image']))
                            <img src="{{ asset('storage/' . $item['image']) }}"
                                 alt="{{ $item['name'] }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl">🏺</span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-gray-800 mb-1">{{ $item['name'] }}</h3>
                                <div class="flex gap-2 mb-2">
                                    <span class="text-xs bg-orange-50 text-orange-600 px-2 py-0.5 rounded-lg font-medium">
                                        {{ $item['size'] }} cm
                                    </span>
                                </div>
                                <p class="text-orange-600 font-extrabold text-lg">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    <span class="text-xs text-gray-400 font-normal">/pcs</span>
                                </p>
                            </div>

                            {{-- Hapus --}}
                            <form method="POST" action="/keranjang/hapus">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <button type="submit" class="text-gray-300 hover:text-red-500 transition text-xl p-1">✕</button>
                            </form>
                        </div>

                        {{-- Update Qty --}}
                        <div class="flex items-center justify-between mt-3">
                            <form method="POST" action="/keranjang/update" class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                        class="px-3 py-2 text-gray-500 hover:bg-gray-100 font-bold transition">−</button>
                                <span class="w-10 text-center font-bold text-gray-800">{{ $item['quantity'] }}</span>
                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                        class="px-3 py-2 text-gray-500 hover:bg-gray-100 font-bold transition">+</button>
                            </form>

                            <p class="font-extrabold text-gray-800 text-lg">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="flex justify-between items-center pt-2">
                    <a href="/produk" class="text-orange-500 hover:text-orange-600 font-semibold text-sm flex items-center gap-1 transition">
                        ← Lanjut Belanja
                    </a>
                    <form method="POST" action="/keranjang/kosongkan">
                        @csrf
                        <button type="submit" class="text-sm text-gray-400 hover:text-red-500 transition font-medium">
                            🗑️ Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="w-full lg:w-80 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="font-extrabold text-gray-800 text-lg mb-5">📋 Ringkasan Pesanan</h2>

                    <div class="space-y-3 mb-5">
                        @foreach($cart as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 truncate mr-2">
                                {{ $item['name'] }} ×{{ $item['quantity'] }}
                            </span>
                            <span class="font-semibold text-gray-700 flex-shrink-0">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-dashed border-gray-200 pt-4 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-700">Total</span>
                            <span class="text-2xl font-extrabold text-orange-600">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="/checkout"
                       class="block bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center py-4 rounded-2xl font-extrabold text-lg hover:shadow-xl hover:scale-105 transition">
                        Checkout Sekarang →
                    </a>

                    <div class="flex items-center gap-2 mt-4 text-xs text-gray-400 justify-center">
                        <span>🔒</span>
                        <span>Transaksi aman & terenkripsi</span>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
@endsection