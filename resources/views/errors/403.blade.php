<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center bg-white p-10 rounded-xl shadow-lg max-w-md">
        <div class="text-8xl mb-4">🚫</div>
        <h1 class="text-4xl font-bold text-red-600 mb-2">403</h1>
        <p class="text-xl font-semibold text-gray-800 mb-2">Akses Ditolak</p>
        <p class="text-gray-500 mb-6">Halaman ini khusus untuk admin. Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <div class="flex gap-3 justify-center">
            <a href="/" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                🏠 Beranda
            </a>
            <a href="{{ route('login') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                🔑 Login
            </a>
        </div>
    </div>
</body>
</html>