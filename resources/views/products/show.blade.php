@extends('layouts.main')

@section('content')
<div>
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="/" class="hover:text-orange-500 transition">Beranda</a>
        <span>›</span>
        <a href="/produk" class="hover:text-orange-500 transition">Produk</a>
        <span>›</span>
        <span class="text-gray-700 font-medium">{{ $product->name }}</span>
    </nav>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
        <div class="flex flex-col md:flex-row gap-10">

            {{-- Gambar --}}
            <div class="w-full md:w-96 flex-shrink-0">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl h-96 flex items-center justify-center overflow-hidden relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-9xl">🏺</span>
                    @endif
                    <div class="absolute top-3 left-3">
                        <span class="bg-orange-500 text-white text-xs px-3 py-1 rounded-full font-semibold">
                            {{ $product->category->name }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $product->name }}</h1>
                <p class="text-gray-400 text-sm mb-6">SKU: {{ $product->sku }}</p>

                <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-5 mb-6">
                    <p class="text-sm text-orange-600 font-medium mb-1">Harga per pcs</p>
                    <p class="text-4xl font-extrabold text-orange-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-6">
                    @foreach([
                        ['label' => 'Ukuran', 'value' => $product->size . ' cm', 'icon' => '📐'],
                        ['label' => 'Finish', 'value' => $product->finish ?? '-', 'icon' => '✨'],
                        ['label' => 'Motif', 'value' => $product->motif ?? '-', 'icon' => '🎨'],
                        ['label' => 'Warna', 'value' => $product->color ?? '-', 'icon' => '🖌️'],
                        ['label' => 'Brand', 'value' => $product->brand, 'icon' => '🏷️'],
                        ['label' => 'Stok', 'value' => $product->stock . ' pcs', 'icon' => '📦'],
                    ] as $spec)
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-lg mb-1">{{ $spec['icon'] }}</p>
                        <p class="text-xs text-gray-400 mb-0.5">{{ $spec['label'] }}</p>
                        <p class="text-sm font-bold text-gray-700">{{ $spec['value'] }}</p>
                    </div>
                    @endforeach
                </div>

                <p class="text-gray-600 text-sm leading-relaxed mb-6">{{ $product->description }}</p>

                @if($product->stock > 0)
                    @auth
                        <form method="POST" action="/keranjang/tambah" class="flex gap-3 mb-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                <button type="button" onclick="changeQty(-1)" class="px-4 py-3 text-gray-500 hover:bg-gray-100 font-bold">−</button>
                                <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}"
                                       class="w-16 text-center py-3 font-bold focus:outline-none">
                                <button type="button" onclick="changeQty(1)" class="px-4 py-3 text-gray-500 hover:bg-gray-100 font-bold">+</button>
                            </div>
                            <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 rounded-xl font-bold hover:shadow-xl hover:scale-105 transition">
                                🛒 Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <a href="/login"
                           class="block w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 rounded-xl font-bold text-center hover:shadow-xl transition mb-3 text-lg">
                            🔑 Login untuk Beli
                        </a>
                    @endauth
                @else
                    <button disabled class="w-full bg-gray-200 text-gray-400 py-4 rounded-xl font-bold cursor-not-allowed mb-3">
                        😔 Stok Habis
                    </button>
                @endif

                <a href="/perbandingan?add={{ $product->id }}"
                   class="block w-full border-2 border-orange-400 text-orange-500 py-3 rounded-xl font-bold text-center hover:bg-orange-50 transition">
                    ⚖️ Tambah ke Perbandingan
                </a>
            </div>
        </div>
    </div>

    {{-- Produk Terkait --}}
    @if($related->count() > 0)
    <div>
        <h2 class="text-xl font-extrabold text-gray-800 mb-4">🔥 Produk Terkait</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($related as $item)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover group">
                <div class="bg-gray-50 h-40 flex items-center justify-center overflow-hidden">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}"
                             alt="{{ $item->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <span class="text-5xl">🏺</span>
                    @endif
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-sm text-gray-800 line-clamp-2 mb-1">{{ $item->name }}</h3>
                    <p class="text-orange-600 font-extrabold text-sm mb-2">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </p>
                    <a href="{{ route('products.detail', $item->id) }}"
                       class="block bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">
                        Lihat →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    const max = parseInt(input.getAttribute('max'));
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > max) val = max;
    input.value = val;
}
</script>
@endsection