@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="text-center mb-10">
        <div class="w-20 h-20 bg-gradient-to-br from-orange-400 to-orange-600 rounded-3xl flex items-center justify-center shadow-xl mx-auto mb-4">
            <span class="text-4xl">🧮</span>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Kalkulator Keramik</h1>
        <p class="text-gray-500">Hitung kebutuhan keramik untuk ruanganmu secara otomatis!</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
        <form method="POST" action="{{ route('calculator.calculate') }}">
            @csrf

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-5">
                @foreach($errors->all() as $error)
                <p class="text-sm text-red-600">• {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">📏 Panjang Ruangan (meter)</label>
                    <input type="number" name="room_length" step="0.01" min="0.1"
                           value="{{ old('room_length', $input['room_length'] ?? '') }}"
                           placeholder="Contoh: 4.5"
                           class="w-full border-2 border-gray-200 rounded-2xl px-5 py-4 text-base font-semibold focus:outline-none focus:border-orange-400 transition">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">📐 Lebar Ruangan (meter)</label>
                    <input type="number" name="room_width" step="0.01" min="0.1"
                           value="{{ old('room_width', $input['room_width'] ?? '') }}"
                           placeholder="Contoh: 3.5"
                           class="w-full border-2 border-gray-200 rounded-2xl px-5 py-4 text-base font-semibold focus:outline-none focus:border-orange-400 transition">
                </div>
            </div>

            <div class="mb-6">
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 block">🔲 Ukuran Keramik</label>
                <div class="grid grid-cols-4 gap-3">
                    @foreach(['20x20', '30x30', '40x40', '50x50', '60x60', '80x80', '100x100', '120x120'] as $size)
                    <label class="cursor-pointer">
                        <input type="radio" name="tile_size" value="{{ $size }}"
                               {{ old('tile_size', $input['tile_size'] ?? '60x60') == $size ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="border-2 border-gray-200 rounded-xl py-3 text-center text-sm font-bold text-gray-600 peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-600 hover:border-orange-300 transition">
                            {{ $size }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">
                    ➕ Persentase Susut/Cadangan:
                    <span class="text-orange-500" id="wasteVal">{{ old('waste', $input['waste'] ?? 10) }}%</span>
                </label>
                <input type="range" name="waste" min="0" max="30" step="1"
                       value="{{ old('waste', $input['waste'] ?? 10) }}"
                       oninput="document.getElementById('wasteVal').textContent = this.value + '%'"
                       class="w-full accent-orange-500 h-2 cursor-pointer">
                <div class="flex justify-between text-xs text-gray-400 mt-1">
                    <span>0%</span>
                    <span>10% (Standar)</span>
                    <span>30% (Aman)</span>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 rounded-2xl font-extrabold text-lg hover:shadow-xl hover:scale-105 transition">
                🧮 Hitung Sekarang
            </button>
        </form>
    </div>

    @if(isset($calculated) && $calculated)
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl p-8 text-white mb-6 shadow-2xl">
        <h2 class="text-xl font-extrabold mb-6 text-center">🎉 Hasil Perhitungan</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Luas Ruangan', 'value' => number_format($roomArea, 2) . ' m²', 'icon' => '📐'],
                ['label' => 'Keramik Dasar', 'value' => $baseCount . ' pcs', 'icon' => '🔢'],
                ['label' => 'Total + Susut', 'value' => $totalCount . ' pcs', 'icon' => '✅'],
                ['label' => 'Perkiraan Dus', 'value' => $boxCount . ' m²', 'icon' => '📦'],
            ] as $stat)
            <div class="bg-white bg-opacity-15 rounded-2xl p-4 text-center">
                <p class="text-2xl mb-1">{{ $stat['icon'] }}</p>
                <p class="text-2xl font-extrabold">{{ $stat['value'] }}</p>
                <p class="text-orange-100 text-xs mt-1">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white bg-opacity-15 rounded-2xl p-4 text-center">
            <p class="text-orange-100 text-sm mb-1">Susut yang ditambahkan</p>
            <p class="text-2xl font-extrabold">{{ $wasteCount }} pcs</p>
            <p class="text-orange-200 text-xs mt-1">({{ $input['waste'] }}% dari keramik dasar)</p>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('products.index') }}?size={{ explode('x', $input['tile_size'])[0] }}"
           class="inline-flex items-center gap-2 bg-white border-2 border-orange-500 text-orange-600 px-8 py-4 rounded-2xl font-extrabold hover:bg-orange-50 transition hover:scale-105">
            🏺 Lihat Produk {{ $input['tile_size'] }} cm →
        </a>
    </div>
    @else
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
        <h3 class="font-bold text-blue-700 mb-3">💡 Tips Perhitungan</h3>
        <ul class="space-y-2 text-sm text-blue-600">
            <li>• Tambahkan 10% untuk pemotongan dan patah selama pemasangan</li>
            <li>• Keramik dijual per dus, isi bervariasi tergantung ukuran</li>
            <li>• Ukuran 60×60 biasanya isi 4 pcs/dus, 30×30 isi 16 pcs/dus</li>
            <li>• Selalu beli sedikit lebih untuk cadangan renovasi</li>
        </ul>
    </div>
    @endif
</div>
@endsection