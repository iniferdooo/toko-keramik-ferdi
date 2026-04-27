@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.products') }}"
           class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-50 transition shadow-sm text-gray-600">
            ←
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">
                {{ isset($product) ? '✏️ Edit Produk' : '➕ Tambah Produk' }}
            </h1>
            <p class="text-gray-400 text-sm">Lengkapi semua data produk</p>
        </div>
    </div>

    <form method="POST"
          action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
          enctype="multipart/form-data"
          class="space-y-5">
        @csrf
        @if(isset($product))
            @method('POST')
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
            <p class="font-bold text-red-700 mb-2">⚠️ Ada kesalahan:</p>
            @foreach($errors->all() as $error)
            <p class="text-sm text-red-600">• {{ $error }}</p>
            @endforeach
        </div>
        @endif

        {{-- Info Dasar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-sm">📝</span>
                Informasi Dasar
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Nama Produk *</label>
                    <input type="text" name="name"
                           value="{{ old('name', $product->name ?? '') }}"
                           required
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">SKU *</label>
                        <input type="text" name="sku"
                               value="{{ old('sku', $product->sku ?? '') }}"
                               required
                               class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Brand</label>
                        <input type="text" name="brand"
                               value="{{ old('brand', $product->brand ?? '') }}"
                               class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Deskripsi *</label>
                    <textarea name="description" rows="4" required
                              class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition resize-none">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Spesifikasi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-sm">📐</span>
                Spesifikasi
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Kategori *</label>
                    <select name="category_id" required
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Ukuran *</label>
                    <select name="size" required
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                        <option value="">Pilih Ukuran</option>
                        @foreach(['20x20', '30x30', '40x40', '50x50', '60x60', '80x80', '100x100', '120x120'] as $s)
                        <option value="{{ $s }}"
                            {{ old('size', $product->size ?? '') == $s ? 'selected' : '' }}>
                            {{ $s }} cm
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Finish</label>
                    <select name="finish"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                        <option value="">Pilih Finish</option>
                        @foreach(['Glossy', 'Matte', 'Anti Slip', 'Wood Look', 'Stone Look'] as $f)
                        <option value="{{ $f }}"
                            {{ old('finish', $product->finish ?? '') == $f ? 'selected' : '' }}>
                            {{ $f }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Motif</label>
                    <input type="text" name="motif"
                           value="{{ old('motif', $product->motif ?? '') }}"
                           placeholder="Marmer, Granit, Polos..."
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Warna</label>
                    <input type="text" name="color"
                           value="{{ old('color', $product->color ?? '') }}"
                           placeholder="Putih, Cream, Abu..."
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Tersedia</label>
                    <select name="is_available"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                        <option value="1" {{ old('is_available', $product->is_available ?? 1) == 1 ? 'selected' : '' }}>
                            ✅ Tersedia
                        </option>
                        <option value="0" {{ old('is_available', $product->is_available ?? 1) == 0 ? 'selected' : '' }}>
                            ❌ Tidak Tersedia
                        </option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Harga & Stok --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-sm">💰</span>
                Harga & Stok
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Harga per pcs (Rp) *</label>
                    <input type="number" name="price"
                           value="{{ old('price', $product->price ?? '') }}"
                           required min="0"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Stok (pcs) *</label>
                    <input type="number" name="stock"
                           value="{{ old('stock', $product->stock ?? 0) }}"
                           required min="0"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
            </div>
        </div>

        {{-- Upload Foto --}}
<div class="mt-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>

    @if(isset($product) && $product->image)
        <div class="mb-3">
            <img id="currentImage" src="{{ asset('storage/' . $product->image) }}"
                 class="w-32 h-32 object-cover rounded-xl border-2 border-orange-200">
        </div>
    @endif

    {{-- Preview --}}
    <div id="imagePreview" class="hidden mb-3">
        <img id="previewImg" src="" class="w-32 h-32 object-cover rounded-xl border-2 border-orange-300">
        <button type="button" onclick="clearImage()"
                class="mt-1 text-xs text-red-500 hover:underline block">
            × Hapus gambar
        </button>
    </div>

    {{-- Drop Zone --}}
    <div id="dropZone"
         class="border-2 border-dashed border-orange-300 rounded-xl p-8 text-center cursor-pointer hover:border-orange-500 hover:bg-orange-50 transition"
         onclick="document.getElementById('imageInput').click()"
         ondragover="event.preventDefault(); this.classList.add('border-orange-500', 'bg-orange-50')"
         ondragleave="this.classList.remove('border-orange-500', 'bg-orange-50')"
         ondrop="handleDrop(event)">
        <p class="text-4xl mb-2">🖼️</p>
        <p class="text-sm font-semibold text-gray-600">Klik, Drag & Drop, atau Paste gambar</p>
        <p class="text-xs text-gray-400 mt-1">JPG, PNG max 2MB</p>
    </div>

    {{-- Input file tersembunyi --}}
    <input type="file" id="imageInput" name="image" accept="image/*"
           class="hidden" onchange="previewImage(this)">

    {{-- Hidden input untuk paste --}}
    <input type="hidden" id="pastedImageData" name="pasted_image">
</div>

<script>
// Preview dari file input
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => showPreview(e.target.result);
        reader.readAsDataURL(input.files[0]);
    }
}

// Handle drag & drop
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('dropZone').classList.remove('border-orange-500', 'bg-orange-50');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('imageInput').files = dt.files;
        const reader = new FileReader();
        reader.onload = (ev) => showPreview(ev.target.result);
        reader.readAsDataURL(file);
    }
}

// Handle paste (Ctrl+V)
document.addEventListener('paste', function(e) {
    const items = e.clipboardData.items;
    for (let item of items) {
        if (item.type.startsWith('image/')) {
            const file = item.getAsFile();
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('imageInput').files = dt.files;
            const reader = new FileReader();
            reader.onload = (ev) => showPreview(ev.target.result);
            reader.readAsDataURL(file);
            break;
        }
    }
});

function showPreview(src) {
    document.getElementById('previewImg').src = src;
    document.getElementById('imagePreview').classList.remove('hidden');
    document.getElementById('dropZone').classList.add('hidden');
}

function clearImage() {
    document.getElementById('imageInput').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('dropZone').classList.remove('hidden');
}

</script>

        {{-- BUTTON SUBMIT --}}
        <div class="flex gap-3">
            <button type="submit"
                    class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 rounded-2xl font-bold text-base hover:shadow-xl hover:scale-105 transition flex items-center justify-center gap-2">
                {{ isset($product) ? '💾 Update Produk' : '➕ Tambah Produk' }}
            </button>
            <a href="{{ route('admin.products') }}"
               class="flex-1 bg-gray-100 text-gray-600 py-4 rounded-2xl font-bold text-base text-center hover:bg-gray-200 transition flex items-center justify-center gap-2">
                ✕ Batal
            </a>
        </div>

    </form>
</div>
@endsection