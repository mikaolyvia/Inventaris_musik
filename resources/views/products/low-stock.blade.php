@extends('layouts.app')

@section('title', 'Stok Rendah')

@section('content')
<div class="space-y-6">
    <nav class="text-sm text-gray-500 flex items-center space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-lavender-600">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('products.index') }}" class="hover:text-lavender-600">Produk</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 font-medium">Stok Rendah</span>
    </nav>

    <!-- Warning Banner -->
    @if($products->count() > 0)
    <div class="bg-red-50 border border-red-200 rounded-xl p-5 flex items-start gap-4">
        <i class="fas fa-exclamation-triangle text-red-500 text-2xl mt-0.5"></i>
        <div>
            <h3 class="font-semibold text-red-800">Peringatan: {{ $products->total() }} Produk Perlu Restock!</h3>
            <p class="text-sm text-red-600 mt-1">Produk berikut memiliki stok di bawah batas minimum. Segera lakukan pembelian untuk menghindari kehabisan stok.</p>
        </div>
    </div>
    @endif

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Produk Stok Rendah</h1>
        <a href="{{ route('purchases.create') }}"
           class="inline-flex items-center px-4 py-2 bg-lavender-600 hover:bg-lavender-700 text-white font-semibold rounded-lg shadow transition text-sm">
            <i class="fas fa-shopping-cart mr-2"></i> Buat Pembelian
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-700 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-700 uppercase tracking-wider">SKU</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-700 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-700 uppercase tracking-wider">Kategori</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-red-700 uppercase tracking-wider">Stok Saat Ini</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-red-700 uppercase tracking-wider">Min. Stok</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-red-700 uppercase tracking-wider">Kekurangan</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-red-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $index => $product)
                    @php $kekurangan = max(0, $product->minimum_stock - $product->stock); @endphp
                    <tr class="{{ $product->stock <= 0 ? 'bg-red-50' : 'hover:bg-amber-50/40' }} transition-colors">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $products->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $product->sku }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs">{{ $product->category->name ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-lg font-bold {{ $product->stock <= 0 ? 'text-red-600' : 'text-amber-600' }}">
                                {{ $product->stock }}
                            </span>
                            @if($product->stock <= 0)
                                <span class="block text-xs text-red-500 font-semibold">HABIS</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-600">{{ $product->minimum_stock }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                -{{ $kekurangan }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('products.show', $product) }}"
                               class="inline-flex items-center px-2.5 py-1.5 bg-lavender-100 hover:bg-lavender-200 text-lavender-700 text-xs font-semibold rounded-lg transition">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-check-circle text-5xl text-green-300 mb-4"></i>
                                <p class="text-gray-500 font-medium">Semua stok dalam kondisi aman!</p>
                                <p class="text-gray-400 text-sm mt-1">Tidak ada produk yang perlu direstok saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
