@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-lavender-600 to-lavender-800 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name ?? 'User' }}! 👋</h2>
                <p class="mt-1 text-lavender-200 text-sm">
                    Berikut ringkasan data inventaris dan penjualan alat musik Anda.
                </p>
            </div>
            <div class="hidden sm:block text-6xl opacity-20">🎵</div>
        </div>
    </div>

    <!-- Stats Row 1 -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">

        <!-- Total Produk -->
        <a href="{{ route('products.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Produk</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalProducts ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-lavender-100 flex items-center justify-center">
                    <i class="fas fa-box text-xl text-lavender-600"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-400">
                <i class="fas fa-database mr-1"></i>
                <span>Produk terdaftar</span>
            </div>
        </a>

        <!-- Total Kategori -->
        <a href="{{ route('categories.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Kategori</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalCategories ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-folder text-xl text-blue-600"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-400">
                <i class="fas fa-tags mr-1"></i>
                <span>Kategori produk</span>
            </div>
        </a>

        <!-- Penjualan Hari Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Penjualan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($todaySalesCount ?? 0) }}</p>
                    <p class="text-sm font-semibold text-green-600 mt-0.5">
                        Rp {{ number_format($todaySalesRevenue ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="fas fa-cash-register text-xl text-green-600"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-400">
                <i class="fas fa-calendar-day mr-1"></i>
                <span>{{ now()->format('d M Y') }}</span>
            </div>
        </div>

        <!-- Stok Rendah -->
        <a href="{{ route('products.low-stock') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow group block">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Stok Rendah</p>
                    <p class="text-2xl font-bold {{ ($lowStockProducts->count() ?? 0) > 0 ? 'text-red-600' : 'text-gray-800' }} mt-1">
                        {{ number_format($lowStockProducts->count() ?? 0) }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl {{ ($lowStockProducts->count() ?? 0) > 0 ? 'bg-red-100' : 'bg-yellow-100' }} flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-xl {{ ($lowStockProducts->count() ?? 0) > 0 ? 'text-red-600' : 'text-yellow-600' }}"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-lavender-500 group-hover:text-lavender-700">
                <span>Lihat detail</span>
                <i class="fas fa-arrow-right ml-1"></i>
            </div>
        </a>
    </div>

    <!-- Stats Row 2 -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">

        <!-- Penjualan Bulan Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Penjualan Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($monthSalesCount ?? 0) }}</p>
                    <p class="text-sm font-semibold text-green-600 mt-0.5">
                        Rp {{ number_format($monthSalesRevenue ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-chart-line text-xl text-emerald-600"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-400">
                <i class="fas fa-calendar mr-1"></i>
                <span>{{ now()->translatedFormat('F Y') }}</span>
            </div>
        </div>

        <!-- Total Pembelian -->
        <a href="{{ route('purchases.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pembelian</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalPurchases ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-xl text-orange-600"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-400">
                <i class="fas fa-receipt mr-1"></i>
                <span>Transaksi pembelian</span>
            </div>
        </a>

        <!-- Total Supplier -->
        <a href="{{ route('suppliers.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Supplier</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalSuppliers ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center">
                    <i class="fas fa-truck text-xl text-indigo-600"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-400">
                <i class="fas fa-handshake mr-1"></i>
                <span>Supplier terdaftar</span>
            </div>
        </a>

        <!-- Total User (Admin Only) -->
        @if(auth()->user() && auth()->user()->role === 'admin')
        <a href="{{ route('users.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total User</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalUsers ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-pink-100 flex items-center justify-center">
                    <i class="fas fa-users text-xl text-pink-600"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-400">
                <i class="fas fa-user-shield mr-1"></i>
                <span>Pengguna sistem</span>
            </div>
        </a>
        @else
        <div class="hidden xl:block"></div>
        @endif
    </div>

    <!-- Low Stock Alert -->
    @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-amber-500 text-xl mt-0.5"></i>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-sm font-semibold text-amber-800">⚠️ Peringatan Stok Rendah</h3>
                <p class="text-sm text-amber-700 mt-1">
                    Terdapat <strong>{{ $lowStockProducts->count() }}</strong> produk dengan stok di bawah batas minimum:
                </p>
                <ul class="mt-2 space-y-1">
                    @foreach($lowStockProducts->take(5) as $produk)
                    <li class="flex items-center text-sm text-amber-700">
                        <i class="fas fa-circle text-[6px] text-amber-400 mr-2"></i>
                        <span class="font-medium">{{ $produk->name }}</span>
                        <span class="mx-2">—</span>
                        <span>Stok: <strong class="text-red-600">{{ $produk->stock }}</strong></span>
                        <span class="text-amber-500 mx-1">|</span>
                        <span>Min: {{ $produk->minimum_stock }}</span>
                    </li>
                    @endforeach
                </ul>
                @if($lowStockProducts->count() > 5)
                <a href="{{ route('products.low-stock') }}"
                   class="inline-flex items-center mt-3 text-sm text-amber-800 font-medium hover:text-amber-900">
                    Lihat semua {{ $lowStockProducts->count() }} produk
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">

        <!-- Penjualan Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-cash-register text-lavender-500 mr-2"></i>
                    Penjualan Terbaru
                </h3>
                <a href="{{ route('sales.index') }}"
                   class="text-xs text-lavender-600 hover:text-lavender-700 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse(($recentSales ?? []) as $sale)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3">
                                <a href="{{ route('sales.show', $sale) }}" class="font-medium text-lavender-600 hover:underline">{{ $sale->sale_number }}</a>
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ \Carbon\Carbon::parse($sale->sold_at)->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3 text-right font-medium text-gray-800">
                                Rp {{ number_format($sale->total ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                @php
                                    $sc = match($sale->status) {
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sc }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400">
                                <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                <span class="text-sm">Belum ada data penjualan</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pembelian Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-shopping-cart text-orange-500 mr-2"></i>
                    Pembelian Terbaru
                </h3>
                <a href="{{ route('purchases.index') }}"
                   class="text-xs text-lavender-600 hover:text-lavender-700 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Supplier</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse(($recentPurchases ?? []) as $purchase)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3">
                                <a href="{{ route('purchases.show', $purchase) }}" class="font-medium text-lavender-600 hover:underline">{{ $purchase->purchase_number }}</a>
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $purchase->supplier->name ?? '-' }}
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ \Carbon\Carbon::parse($purchase->purchased_at)->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                @php
                                    $pc = match($purchase->status) {
                                        'completed' => 'bg-green-100 text-green-700',
                                        'pending'   => 'bg-yellow-100 text-yellow-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default     => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pc }}">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400">
                                <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                <span class="text-sm">Belum ada data pembelian</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
