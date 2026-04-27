@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
            <span class="text-2xl">📦</span>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Checkout</h1>
            <p class="text-gray-400 text-sm">Lengkapi data pengiriman kamu</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Form --}}
        <div class="flex-1">
            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-5">
                    <p class="font-bold text-red-700 mb-2">⚠️ Ada kesalahan:</p>
                    @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600">• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                {{-- Data Penerima --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                    <h2 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-sm">👤</span>
                        Data Penerima
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Nama Lengkap *</label>
                            <input type="text" name="recipient_name"
                                   value="{{ old('recipient_name', auth()->user()->name) }}"
                                   required
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">No. WhatsApp *</label>
                            <input type="text" name="shipping_phone"
                                   value="{{ old('shipping_phone') }}"
                                   placeholder="08xxxxxxxxxx"
                                   required
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                        </div>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                    <h2 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-sm">📍</span>
                        Alamat Pengiriman
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Alamat Lengkap *</label>
                            <textarea name="shipping_address" rows="3"
                                      placeholder="Jl. Contoh No. 1, RT/RW, Kelurahan..."
                                      required
                                      class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition resize-none">{{ old('shipping_address') }}</textarea>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Kota *</label>
                            <input type="text" name="shipping_city"
                                   value="{{ old('shipping_city') }}"
                                   placeholder="Malang"
                                   required
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Catatan (opsional)</label>
                            <textarea name="notes" rows="2"
                                      placeholder="Catatan tambahan untuk kurir..."
                                      class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition resize-none">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 rounded-2xl font-extrabold text-lg hover:shadow-xl hover:scale-105 transition">
                    ✅ Konfirmasi Pesanan
                </button>
            </form>
        </div>

        {{-- Summary --}}
        <div class="w-full lg:w-72 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h2 class="font-extrabold text-gray-800 mb-4">🛒 Pesananmu</h2>

                <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                    @foreach($cart as $item)
                    <div class="flex gap-3">
                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                            @if(!empty($item['image']))
                                <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xl">🏺</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-700 truncate">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-400">×{{ $item['quantity'] }}</p>
                            <p class="text-xs font-bold text-orange-600">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-dashed border-gray-200 pt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500">Ongkir</span>
                        <span class="text-green-600 font-bold text-sm">Gratis 🎉</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-extrabold text-gray-800">Total</span>
                        <span class="text-xl font-extrabold text-orange-600">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection