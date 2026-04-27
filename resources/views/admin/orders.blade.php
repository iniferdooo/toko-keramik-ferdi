@extends('layouts.main')

@section('content')
<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">📦 Kelola Pesanan</h1>
            <p class="text-gray-400 text-sm">{{ $orders->total() }} total pesanan</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-2xl mb-6 font-medium text-sm">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Filter Status --}}
    <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
        <a href="{{ route('admin.orders') }}"
           class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-semibold transition
               {{ !request('status') ? 'bg-orange-500 text-white shadow-lg' : 'bg-white text-gray-600 shadow hover:bg-orange-50' }}">
            Semua
        </a>
        @foreach([
            'pending'    => '⏳ Pending',
            'confirmed'  => '✅ Dikonfirmasi',
            'processing' => '⚙️ Diproses',
            'shipped'    => '🚚 Dikirim',
            'delivered'  => '🎉 Selesai',
            'cancelled'  => '❌ Dibatalkan',
        ] as $val => $label)
        <a href="{{ route('admin.orders') }}?status={{ $val }}"
           class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-semibold transition
               {{ request('status') == $val ? 'bg-orange-500 text-white shadow-lg' : 'bg-white text-gray-600 shadow hover:bg-orange-50' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-orange-50 transition">
                        <td class="p-4">
                            <p class="font-bold text-gray-800 text-sm">{{ $order->order_number }}</p>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-gray-800 text-sm">{{ $order->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $order->shipping_city }}</p>
                        </td>
                        <td class="p-4 font-extrabold text-orange-600 text-sm">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            <span class="text-xs px-3 py-1 rounded-full font-bold
                                {{ $order->status == 'pending'    ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $order->status == 'confirmed'  ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $order->status == 'processing' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                {{ $order->status == 'shipped'    ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $order->status == 'delivered'  ? 'bg-green-100 text-green-700' : '' }}
                                {{ $order->status == 'cancelled'  ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y') }}
                        </td>
                        <td class="p-4">
                            <form method="POST"
                                  action="{{ route('admin.orders.status', $order->id) }}"
                                  class="flex gap-2 items-center">
                                @csrf
                                <select name="status"
                                        class="border border-gray-200 rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:border-orange-400 transition">
                                    @foreach([
                                        'pending'    => 'Pending',
                                        'confirmed'  => 'Dikonfirmasi',
                                        'processing' => 'Diproses',
                                        'shipped'    => 'Dikirim',
                                        'delivered'  => 'Selesai',
                                        'cancelled'  => 'Dibatalkan',
                                    ] as $val => $label)
                                    <option value="{{ $val }}" {{ $order->status == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="bg-orange-500 text-white px-3 py-1.5 rounded-xl text-xs font-bold hover:bg-orange-600 transition">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-gray-400">
                            <p class="text-5xl mb-3">📭</p>
                            <p class="font-semibold">Belum ada pesanan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection