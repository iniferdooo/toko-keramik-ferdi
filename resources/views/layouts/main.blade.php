<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Toko Keramik Ferdi' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-hero { background: linear-gradient(135deg, #ff6b35 0%, #f7c59f 50%, #ff6b35 100%); background-size: 200% 200%; animation: gradientShift 6s ease infinite; }
        @keyframes gradientShift { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
        .glass { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: #ff6b35; transition: width 0.3s; }
        .nav-link:hover::after { width: 100%; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #ff6b35; border-radius: 3px; }
        .badge-pulse { animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.7} }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- NAVBAR --}}
    <nav class="glass shadow-sm sticky top-0 z-50 border-b border-orange-100">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                        <span class="text-xl">🏺</span>
                    </div>
                    <div>
                        <span class="text-lg font-800 bg-gradient-to-r from-orange-500 to-orange-700 bg-clip-text text-transparent font-extrabold">
                            Keramik Ferdi
                        </span>
                        <p class="text-xs text-gray-400 -mt-1">Premium Tiles Store</p>
                    </div>
                </a>

                {{-- Nav Links --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="/produk" class="nav-link text-gray-600 hover:text-orange-600 font-medium text-sm transition">Produk</a>
                    <a href="/kalkulator" class="nav-link text-gray-600 hover:text-orange-600 font-medium text-sm transition">Kalkulator</a>
                    <a href="/perbandingan" class="nav-link text-gray-600 hover:text-orange-600 font-medium text-sm transition">Bandingkan</a>
                </div>

                {{-- Auth --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="/keranjang" class="relative flex items-center gap-1 bg-orange-50 text-orange-600 px-3 py-2 rounded-xl hover:bg-orange-100 transition text-sm font-medium">
                            🛒 Keranjang
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="/admin" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">
                                ⚡ Admin
                            </a>
                        @endif
                        <a href="/profil" class="flex items-center gap-2 bg-gray-100 hover:bg-orange-50 rounded-xl px-3 py-2 transition">
    <div class="w-7 h-7 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </div>
    <span class="text-sm font-medium text-gray-700 hidden md:block">{{ auth()->user()->name }}</span>
</a>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition text-sm">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="/login" class="text-gray-600 hover:text-orange-600 font-medium text-sm transition">Masuk</a>
                        <a href="/register" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:scale-105 transition">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gradient-to-br from-gray-900 to-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center">
                            <span class="text-xl">🏺</span>
                        </div>
                        <span class="text-xl font-extrabold text-orange-400">Keramik Ferdi</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Toko keramik terpercaya untuk kontraktor, kuli bangunan, dan pemilik rumah sejak 2010.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">🔗 Menu</h4>
                    <div class="space-y-2">
                        <a href="/produk" class="block text-gray-400 hover:text-orange-400 text-sm transition">Produk Keramik</a>
                        <a href="/kalkulator" class="block text-gray-400 hover:text-orange-400 text-sm transition">Kalkulator Keramik</a>
                        <a href="/perbandingan" class="block text-gray-400 hover:text-orange-400 text-sm transition">Bandingkan Produk</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">📞 Kontak</h4>
                    <div class="space-y-2 text-sm text-gray-400">
                        <p>📍 Jl. Keramik No. 1, Malang</p>
                        <p>📞 081234567890</p>
                        <p>✉️ ferdi@tokokeramik.com</p>
                        <p>🕐 Senin-Sabtu, 08.00-17.00</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-6 text-center">
                <p class="text-gray-500 text-sm">© 2024 Toko Keramik Ferdi. Made with ❤️ in Malang</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>