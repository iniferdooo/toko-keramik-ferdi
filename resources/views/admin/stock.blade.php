@extends('layouts.main')

@section('content')
<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">📊 Kelola Stok</h1>
            <p class="text-gray-400 text-sm">Diurutkan dari stok paling sedikit</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-2xl mb-6 font-medium text-sm">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Ringkasan --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-red-50 border border-red-100 rounded-2xl p-5 text-center">
            <p class="text-3xl font-extrabold text-red-600">
                {{ $products->where('stock', 0)->count() }}
            </p>
            <p class="text-sm text-red-500 font-semibold mt-1">❌ Stok Habis</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-5 text-center">
            <p class="text-3xl font-extrabold text-yellow-600">
                {{ $products->where('stock', '>', 0)->where('stock', '<=', 10)->count() }}
            </p>
            <p class="text-sm text-yellow-600 font-semibold mt-1">⚠️ Stok Menipis</p>
        </div>
        <div class="bg-green-50 border border-green-100 rounded-2xl p-5 text-center">
            <p class="text-3xl font-extrabold text-green-600">
                {{ $products->where('stock', '>', 10)->count() }}
            </p>
            <p class="text-sm text-green-600 font-semibold mt-1">✅ Stok Aman</p>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Update Stok</th>
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
                        <td class="p-4">
                            <span class="text-lg font-extrabold px-3 py-1 rounded-full
                                {{ $product->stock == 0  ? 'bg-red-100 text-red-600' :
                                   ($product->stock <= 10 ? 'bg-yellow-100 text-yellow-700' :
                                                            'bg-green-100 text-green-700') }}">
                                {{ $product->stock }}
                            </span>
                            <span class="text-xs text-gray-400 ml-1">pcs</span>
                        </td>
                        <td class="p-4">
                            <form method="POST"
                                  action="{{ route('admin.stock.update', $product->id) }}"
                                  class="flex gap-2 items-center">
                                @csrf
                                <input type="number" name="stock"
                                       value="{{ $product->stock }}"
                                       min="0"
                                       class="w-24 border-2 border-gray-200 rounded-xl px-3 py-2 text-sm font-bold focus:outline-none focus:border-orange-400 transition">
                                <button type="submit"
                                        class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:shadow-lg transition">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-16 text-gray-400">
                            <p class="text-5xl mb-3">📦</p>
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