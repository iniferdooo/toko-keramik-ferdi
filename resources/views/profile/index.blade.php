@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-3xl p-8 mb-6 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full -translate-y-24 translate-x-24"></div>
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center text-4xl font-extrabold border-2 border-white border-opacity-30">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-extrabold">{{ $user->name }}</h1>
                <p class="text-orange-100">{{ $user->email }}</p>
                <span class="inline-block mt-1 bg-white bg-opacity-20 text-white text-xs px-3 py-1 rounded-full font-semibold">
                    {{ $user->role === 'admin' ? '⚡ Admin' : '👤 Customer' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl mb-4 flex items-center gap-2">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-4 flex items-center gap-2">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Edit Profil --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-extrabold text-gray-800 mb-5">✏️ Edit Profil</h2>

            <form method="POST" action="/profil/update">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 text-red-600 px-4 py-3 rounded-xl mb-4 text-sm">
                        @foreach($errors->all() as $error)
                            <p>❌ {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                            Email
                        </label>
                        <input type="email" name="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                            No. Telepon
                        </label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="08xxxxxxxxxx"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                            Alamat
                        </label>
                        <textarea name="address" rows="3"
                                  placeholder="Alamat lengkap..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent transition resize-none">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 rounded-xl font-bold hover:shadow-lg hover:scale-105 transition">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Ganti Password --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-extrabold text-gray-800 mb-5">🔐 Ganti Password</h2>

            <form method="POST" action="/profil/password">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                            Password Lama
                        </label>
                        <input type="password" name="current_password"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent transition"
                               placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                            Password Baru
                        </label>
                        <input type="password" name="password"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent transition"
                               placeholder="Min. 8 karakter">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" name="password_confirmation"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent transition"
                               placeholder="Ulangi password baru">
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-gray-700 to-gray-800 text-white py-3 rounded-xl font-bold hover:shadow-lg hover:scale-105 transition">
                        🔑 Update Password
                    </button>
                </div>
            </form>

            {{-- Info Akun --}}
            <div class="mt-6 pt-6 border-t border-gray-100">
                <h3 class="text-sm font-bold text-gray-600 mb-3">📊 Info Akun</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Bergabung</span>
                        <span class="font-medium">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Total Pesanan</span>
                        <span class="font-medium text-orange-600">{{ $user->orders->count() }} pesanan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="grid grid-cols-2 gap-4 mt-6">
        <a href="/riwayat-pesanan"
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 card-hover">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">📋</div>
            <div>
                <p class="font-bold text-gray-800">Riwayat Pesanan</p>
                <p class="text-xs text-gray-400">Lihat semua pesanan</p>
            </div>
        </a>
        <a href="/keranjang"
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 card-hover">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">🛒</div>
            <div>
                <p class="font-bold text-gray-800">Keranjang</p>
                <p class="text-xs text-gray-400">Lihat keranjang belanja</p>
            </div>
        </a>
    </div>

</div>
@endsection