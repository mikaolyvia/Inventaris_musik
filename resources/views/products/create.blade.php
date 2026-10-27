@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 flex items-center space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-lavender-600">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('products.index') }}" class="hover:text-lavender-600">Produk</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 font-medium">Tambah</span>
    </nav>

    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-lavender-50">
                <h2 class="text-lg font-semibold text-lavender-800">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Produk Baru
                </h2>
            </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- SKU -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SKU <span class="text-red-500">*</span></label>
                        <input type="text" name="sku" value="{{ old('sku') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border @error('sku') border-red-400 @enderror"
                               placeholder="MUS-001">
                        @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border @error('category_id') border-red-400 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border @error('name') border-red-400 @enderror"
                           placeholder="Gitar Akustik Yamaha F310">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border"
                              placeholder="Deskripsi produk (opsional)">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Harga Beli -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-sm text-gray-500">Rp</span>
                            <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" min="0" step="1000"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm pl-10 pr-3 py-2 border @error('purchase_price') border-red-400 @enderror"
                                   placeholder="0">
                        </div>
                        @error('purchase_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Harga Jual -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-sm text-gray-500">Rp</span>
                            <input type="number" name="selling_price" value="{{ old('selling_price') }}" min="0" step="1000"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm pl-10 pr-3 py-2 border @error('selling_price') border-red-400 @enderror"
                                   placeholder="0">
                        </div>
                        @error('selling_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border @error('stock') border-red-400 @enderror">
                        @error('stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Minimum Stok -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="minimum_stock" value="{{ old('minimum_stock', 0) }}" min="0"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border @error('minimum_stock') border-red-400 @enderror">
                        <p class="text-xs text-gray-400 mt-1">Alert stok rendah jika di bawah angka ini</p>
                        @error('minimum_stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Gambar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-lavender-50 file:text-lavender-700 hover:file:bg-lavender-100">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, GIF. Maks 2MB (opsional)</p>
                    @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-lavender-600 hover:bg-lavender-700 text-white font-semibold rounded-lg shadow transition">
                        <i class="fas fa-save mr-2"></i> Simpan Produk
                    </button>
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow transition">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
