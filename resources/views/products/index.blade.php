@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 flex items-center space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-lavender-600 transition">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 font-medium">Produk</span>
    </nav>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Produk</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data produk alat musik</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('products.low-stock') }}"
               class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow transition text-sm">
                <i class="fas fa-exclamation-triangle mr-2"></i> Stok Rendah
            </a>
            <a href="{{ route('products.create') }}"
               class="inline-flex items-center px-4 py-2 bg-lavender-600 hover:bg-lavender-700 text-white font-semibold rounded-lg shadow transition text-sm">
                <i class="fas fa-plus mr-2"></i> Tambah Produk
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Cari SKU / Nama</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari produk..."
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
                <select name="category_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-lavender-600 hover:bg-lavender-700 text-white rounded-lg font-medium transition text-sm">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                @if(request()->hasAny(['search','category_id']))
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition text-sm">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-lavender-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">SKU</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">Kategori</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-lavender-700 uppercase tracking-wider">Harga Beli</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-lavender-700 uppercase tracking-wider">Harga Jual</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-lavender-700 uppercase tracking-wider">Stok</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-lavender-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $index => $product)
                    <tr class="hover:bg-purple-50/40 transition-colors">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $products->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-mono bg-lavender-100 text-lavender-700 px-2 py-1 rounded">{{ $product->sku }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                            @if($product->description)
                                <p class="text-xs text-gray-500 truncate max-w-xs">{{ $product->description }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs">{{ $product->category->name ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 text-right">
                            Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800 text-right">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($product->stock <= 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fas fa-times-circle mr-1"></i> {{ $product->stock }} (Habis)
                                </span>
                            @elseif($product->stock <= $product->minimum_stock)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> {{ $product->stock }} (Rendah)
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <i class="fas fa-check-circle mr-1"></i> {{ $product->stock }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-1.5">
                                <a href="{{ route('products.show', $product) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 bg-lavender-100 hover:bg-lavender-200 text-lavender-700 text-xs font-semibold rounded-lg transition">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                                <a href="{{ route('products.edit', $product) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded-lg transition">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-box-open text-5xl text-gray-200 mb-4"></i>
                                <p class="text-gray-500 font-medium">Belum ada produk</p>
                                <p class="text-gray-400 text-sm mt-1">Tambah produk pertama untuk memulai</p>
                                <a href="{{ route('products.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-lavender-600 text-white rounded-lg text-sm hover:bg-lavender-700 transition">
                                    <i class="fas fa-plus mr-2"></i> Tambah Produk
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $products->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
