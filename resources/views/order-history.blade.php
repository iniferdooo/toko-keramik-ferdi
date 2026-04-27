@extends('layouts.main')

@section('content')
<div>
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
            <span class="text-2xl">📋</span>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Riwayat Pesanan</h1>
            <p class="text-gray-400 text-sm">Semua pesanan kamu ada di sini</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-2xl mb-6 font-medium text-sm">
        ✅ {{ session('success') }}
    </div>
    @endif

    @if($orders->isEmpty())
    <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
        <p class="text-8xl mb-6">📋</p>
        <p class="text-2xl font-extrabold text-gray-700 mb-2">Belum Ada Pesanan</p>
        <p class="text-gray-400 mb-8">Yuk mulai belanja keramik impianmu!</p>
        <a href="{{ route('products.index') }}"
           class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-4 rounded-2xl font-bold hover:shadow-xl hover:scale-105 transition text-lg">
            🏺 Mulai Belanja
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                <div>
                    <p class="font-extrabold text-gray-800 text-lg">{{ $order->order_number }}</p>
                    <p class="text-gray-400 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <span class="mt-2 md:mt-0 px-4 py-1.5 rounded-full text-sm font-bold
                    {{ $order->status === 'pending'    ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $order->status === 'confirmed'  ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $order->status === 'processing' ? 'bg-indigo-100 text-indigo-700' : '' }}
                    {{ $order->status === 'shipped'    ? 'bg-purple-100 text-purple-700' : '' }}
                    {{ $order->status === 'delivered'  ? 'bg-green-100 text-green-700' : '' }}
                    {{ $order->status === 'cancelled'  ? 'bg-red-100 text-red-700' : '' }}">
                    {{ $order->status_label }}
                </span>
            </div>

            {{-- Items --}}
            <div class="space-y-2 mb-4 bg-gray-50 rounded-xl p-4">
                @foreach($order->items as $item)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">
                        {{ $item->product_name }}
                        <span class="text-gray-400">×{{ $item->quantity }}</span>
                    </span>
                    <span class="font-semibold text-gray-700">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                <div>
                    <p class="text-xs text-gray-400">Total Pesanan</p>
                    <p class="font-extrabold text-orange-600 text-xl">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </p>
                </div>
                <a href="{{ route('orders.show', $order->id) }}"
                   class="bg-orange-50 text-orange-600 border border-orange-200 px-4 py-2 rounded-xl text-sm font-bold hover:bg-orange-100 transition">
                    Lihat Detail →
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection