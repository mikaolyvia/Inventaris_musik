@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="space-y-6">
    <nav class="text-sm text-gray-500 flex items-center space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-lavender-600">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('products.index') }}" class="hover:text-lavender-600">Produk</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 font-medium">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Product Info Card -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-lavender-50 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-lavender-800">
                    <i class="fas fa-box mr-2"></i> Detail Produk
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('products.edit', $product) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded-lg transition">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center px-3 py-1.5 bg-gray-500 hover:bg-gray-600 text-white text-xs font-semibold rounded-lg transition">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-6">
                    <!-- Image -->
                    <div class="flex-shrink-0">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                 class="w-36 h-36 object-cover rounded-xl border border-gray-200 shadow-sm">
                        @else
                            <div class="w-36 h-36 bg-lavender-100 rounded-xl flex items-center justify-center border border-lavender-200">
                                <i class="fas fa-music text-5xl text-lavender-400"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="flex-1 space-y-3">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $product->name }}</h3>
                            <span class="inline-block mt-1 text-xs font-mono bg-lavender-100 text-lavender-700 px-2 py-0.5 rounded">{{ $product->sku }}</span>
                        </div>

                        @if($product->description)
                        <p class="text-sm text-gray-600">{{ $product->description }}</p>
                        @endif

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Kategori</p>
                                <p class="text-sm font-medium text-gray-800">{{ $product->category->name ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Status Stok</p>
                                @if($product->stock <= 0)
                                    <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Habis</span>
                                @elseif($product->stock <= $product->minimum_stock)
                                    <span class="text-xs font-semibold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">Stok Rendah</span>
                                @else
                                    <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">Tersedia</span>
                                @endif
                            </div>
                            <div class="bg-green-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Harga Beli</p>
                                <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-lavender-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Harga Jual</p>
                                <p class="text-sm font-bold text-lavender-700">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Stok Saat Ini</p>
                                <p class="text-xl font-bold {{ $product->stock <= $product->minimum_stock ? 'text-red-600' : 'text-blue-700' }}">{{ $product->stock }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Minimum Stok</p>
                                <p class="text-xl font-bold text-gray-700">{{ $product->minimum_stock }}</p>
                            </div>
                        </div>

                        <div class="text-xs text-gray-400 pt-1 flex gap-4">
                            <span><i class="fas fa-clock mr-1"></i> Dibuat: {{ $product->created_at->format('d M Y H:i') }}</span>
                            <span><i class="fas fa-pencil-alt mr-1"></i> Diupdate: {{ $product->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Info Sidebar -->
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-3"><i class="fas fa-chart-bar mr-2 text-lavender-500"></i>Info Margin</h3>
                @php
                    $margin = $product->selling_price - $product->purchase_price;
                    $marginPct = $product->purchase_price > 0 ? ($margin / $product->purchase_price * 100) : 0;
                @endphp
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Margin</span>
                        <span class="font-semibold text-green-600">Rp {{ number_format($margin, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">% Margin</span>
                        <span class="font-semibold text-green-600">{{ number_format($marginPct, 1) }}%</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Nilai Stok</span>
                        <span class="font-semibold text-lavender-600">Rp {{ number_format($product->stock * $product->purchase_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
