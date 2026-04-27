@extends('layouts.main')

@section('content')
<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">🏺 Kelola Produk</h1>
            <p class="text-gray-400 text-sm">{{ $products->total() }} produk terdaftar</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-5 py-3 rounded-2xl font-bold hover:shadow-xl hover:scale-105 transition flex items-center gap-2">
            ➕ Tambah Produk
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-2xl mb-6 font-medium text-sm">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
        <form method="GET" action="{{ route('admin.products') }}" class="flex gap-3 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="🔍 Cari produk..."
                   class="flex-1 min-w-48 border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
            <select name="category"
                    class="border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
            <button type="submit"
                    class="bg-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-700 transition">
                Filter
            </button>
            @if(request('search') || request('category'))
            <a href="{{ route('admin.products') }}"
               class="bg-gray-100 text-gray-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ukuran</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-orange-50 transition">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl">🏺</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $product->sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="bg-orange-50 text-orange-600 text-xs px-3 py-1 rounded-full font-semibold">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-600 font-medium">{{ $product->size }} cm</td>
                        <td class="p-4 font-extrabold text-orange-600 text-sm">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            <span class="text-sm font-bold px-3 py-1 rounded-full
                                {{ $product->stock == 0  ? 'bg-red-100 text-red-600' :
                                   ($product->stock <= 10 ? 'bg-yellow-100 text-yellow-700' :
                                                            'bg-green-100 text-green-700') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-xl text-xs font-bold transition">
                                    ✏️ Edit
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.products.delete', $product->id) }}"
                                      onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    <button type="submit"
                                            class="bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1.5 rounded-xl text-xs font-bold transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-gray-400">
                            <p class="text-5xl mb-3">🏺</p>
                            <p class="font-semibold">Belum ada produk</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection