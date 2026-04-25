<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Toko Keramik Ferdi' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2">
                <span class="text-2xl">🏺</span>
                <span class="text-xl font-bold text-orange-600">Toko Keramik Ferdi</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="/produk" class="text-gray-600 hover:text-orange-600 font-medium">Produk</a>
                <a href="/kalkulator" class="text-gray-600 hover:text-orange-600 font-medium">Kalkulator</a>
                <a href="/perbandingan" class="text-gray-600 hover:text-orange-600 font-medium">Perbandingan</a>
                @auth
                    <a href="/keranjang" class="text-gray-600 hover:text-orange-600 font-medium">🛒 Keranjang</a>
                    @if(auth()->user()->isAdmin())
                        <a href="/admin" class="bg-red-600 text-white px-3 py-1 rounded-lg text-sm">Admin</a>
                    @endif
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 font-medium">Logout</button>
                    </form>
                @else
                    <a href="/login" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">Login</a>
                    <a href="/register" class="border border-orange-600 text-orange-600 px-4 py-2 rounded-lg hover:bg-orange-50">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-lg font-bold mb-2">🏺 Toko Keramik Ferdi</p>
            <p class="text-gray-400">Jl. Keramik No. 1, Malang | 📞 081234567890</p>
            <p class="text-gray-500 text-sm mt-2">© 2024 Toko Keramik Ferdi. All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>