@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('sales.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 transition-colors print-hide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Penjualan</h1>
                <p class="text-sm text-gray-500 mt-1">Informasi lengkap transaksi penjualan</p>
            </div>
        </div>
        <div class="flex items-center gap-2 print-hide">
            <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print
            </button>
            @if($sale->status !== 'cancelled')
                <form action="{{ route('sales.cancel', $sale) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan penjualan ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2.5 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-lg transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batalkan
                    </button>
                </form>
            @endif
            <a href="{{ route('sales.index') }}"
               class="inline-flex items-center px-4 py-2.5 bg-purple-100 hover:bg-purple-200 text-purple-700 text-sm font-medium rounded-lg transition-colors duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- Sale Info Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-500">No. Penjualan</p>
                <h2 class="text-xl font-bold text-purple-700">{{ $sale->sale_number }}</h2>
            </div>
            <div>
                @if($sale->status === 'completed')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        Completed
                    </span>
                @elseif($sale->status === 'cancelled')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                        Cancelled
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">Nama Customer</p>
                <p class="text-sm font-semibold text-gray-800">{{ $sale->customer_name ?: 'Umum' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Tanggal</p>
                <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Kasir</p>
                <p class="text-sm font-semibold text-gray-800">{{ $sale->user->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Catatan</p>
                <p class="text-sm text-gray-800">{{ $sale->notes ?: '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-purple-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-purple-100">
            <h3 class="text-lg font-semibold text-gray-800">Detail Item</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-purple-100">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase w-12">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Produk</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-purple-700 uppercase">Kuantitas</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-purple-700 uppercase">Harga Satuan</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-purple-700 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-50">
                    @foreach($sale->items as $index => $item)
                        <tr class="even:bg-purple-50/30">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $item->product->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->product->sku ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 text-center">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-purple-50 border-t-2 border-purple-200">
                        <td colspan="4" class="px-6 py-4 text-right text-sm font-bold text-purple-700 uppercase">Total</td>
                        <td class="px-6 py-4 text-right text-lg font-bold text-purple-700">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .print-hide { display: none !important; }
        body { background: white !important; }
        .bg-white { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
    }
</style>
@endpush
@endsection
