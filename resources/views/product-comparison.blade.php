@extends('layouts.main')

@section('content')
<div>
    <div class="text-center mb-10">
        <div class="w-20 h-20 bg-gradient-to-br from-orange-400 to-orange-600 rounded-3xl flex items-center justify-center shadow-xl mx-auto mb-4">
            <span class="text-4xl">⚖️</span>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Bandingkan Produk</h1>
        <p class="text-gray-500">Pilih hingga 3 produk untuk dibandingkan</p>
    </div>

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-2xl mb-6 font-medium text-sm">
        ❌ {{ session('error') }}
    </div>
    @endif

    {{-- Tambah Produk --}}
    @if($products->count() < 3)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="font-extrabold text-gray-800 mb-4">➕ Tambah Produk untuk Dibandingkan</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($allProducts as $item)
                @if(!in_array($item->id, $compareIds))
                <a href="{{ route('products.comparison') }}?add={{ $item->id }}"
                   class="bg-gray-50 border-2 border-gray-200 hover:border-orange-400 rounded-xl p-3 text-center transition group">
                    <p class="text-xs font-semibold text-gray-700 line-clamp-2 mb-1">{{ $item->name }}</p>
                    <p class="text-xs text-orange-500 font-bold group-hover:underline">+ Tambah</p>
                </a>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    @if($products->count() == 0)
    <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
        <p class="text-7xl mb-4">⚖️</p>
        <p class="text-xl font-extrabold text-gray-700 mb-2">Belum ada produk</p>
        <p class="text-gray-400 mb-6">Tambahkan produk di atas untuk mulai membandingkan</p>
        <a href="{{ route('products.index') }}"
           class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-2xl font-bold hover:shadow-lg transition">
            🏺 Browse Produk
        </a>
    </div>
    @else
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-orange-50 to-orange-100">
                        <th class="p-5 text-left text-sm font-bold text-gray-500 w-36">Spesifikasi</th>
                        @foreach($products as $product)
                        <th class="p-5 text-center min-w-48">
                            <div class="w-24 h-24 bg-gray-100 rounded-2xl mx-auto mb-3 overflow-hidden flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl">🏺</span>
                                @endif
                            </div>
                            <p class="font-extrabold text-gray-800 text-sm leading-tight mb-1">{{ $product->name }}</p>
                            <a href="{{ route('products.comparison') }}?remove={{ $product->id }}"
                               class="text-xs text-red-400 hover:text-red-600 transition">✕ Hapus</a>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['label' => '💰 Harga', 'field' => 'price', 'format' => 'currency'],
                        ['label' => '📂 Kategori', 'field' => 'category.name', 'format' => 'text'],
                        ['label' => '📐 Ukuran', 'field' => 'size', 'format' => 'size'],
                        ['label' => '✨ Finish', 'field' => 'finish', 'format' => 'text'],
                        ['label' => '🎨 Motif', 'field' => 'motif', 'format' => 'text'],
                        ['label' => '🖌️ Warna', 'field' => 'color', 'format' => 'text'],
                        ['label' => '🏷️ Brand', 'field' => 'brand', 'format' => 'text'],
                        ['label' => '📦 Stok', 'field' => 'stock', 'format' => 'stock'],
                    ] as $index => $spec)
                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} border-t border-gray-100">
                        <td class="p-4 text-sm font-bold text-gray-600">{{ $spec['label'] }}</td>
                        @foreach($products as $product)
                        <td class="p-4 text-center text-sm font-medium">
                            @php
                                $keys = explode('.', $spec['field']);
                                $val = $product;
                                foreach($keys as $k) { $val = is_object($val) ? ($val->$k ?? '-') : '-'; }
                            @endphp
                            @if($spec['format'] == 'currency')
                                <span class="font-extrabold text-orange-600 text-base">Rp {{ number_format($val, 0, ',', '.') }}</span>
                            @elseif($spec['format'] == 'size')
                                <span>{{ $val }} cm</span>
                            @elseif($spec['format'] == 'stock')
                                @if($val > 10)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold">✅ {{ $val }}</span>
                                @elseif($val > 0)
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-bold">⚠️ {{ $val }}</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold">❌ Habis</span>
                                @endif
                            @else
                                {{ $val }}
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach

                    {{-- CTA --}}
                    <tr class="bg-white border-t-2 border-orange-100">
                        <td class="p-4"></td>
                        @foreach($products as $product)
                        <td class="p-4 text-center">
                            <a href="{{ route('products.detail', $product->id) }}"
                               class="inline-block bg-gradient-to-r from-orange-500 to-orange-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg transition">
                                Beli Sekarang →
                            </a>
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('products.comparison') }}?reset=1"
           class="text-sm text-gray-400 hover:text-red-500 transition font-medium">
            🗑️ Reset Perbandingan
        </a>
    </div>
    @endif
</div>
@endsection