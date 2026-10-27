@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
<div class="space-y-6">
    <nav class="text-sm text-gray-500 flex items-center space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-lavender-600">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 font-medium">Supplier</span>
    </nav>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Supplier</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data pemasok alat musik</p>
        </div>
        <a href="{{ route('suppliers.create') }}"
           class="inline-flex items-center px-4 py-2 bg-lavender-600 hover:bg-lavender-700 text-white font-semibold rounded-lg shadow transition text-sm">
            <i class="fas fa-plus mr-2"></i> Tambah Supplier
        </a>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('suppliers.index') }}" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama supplier..."
                   class="flex-1 max-w-sm rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border">
            <button type="submit" class="px-4 py-2 bg-lavender-600 hover:bg-lavender-700 text-white rounded-lg font-medium transition text-sm">
                <i class="fas fa-search mr-1"></i> Cari
            </button>
            @if(request('search'))
            <a href="{{ route('suppliers.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition text-sm">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-lavender-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">Nama Supplier</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">Telepon</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">Alamat</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-lavender-700 uppercase tracking-wider">Jml Pembelian</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-lavender-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($suppliers as $index => $supplier)
                    <tr class="hover:bg-purple-50/40 transition-colors">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $suppliers->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-lavender-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-truck text-lavender-600 text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $supplier->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $supplier->phone ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $supplier->email ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">
                            {{ $supplier->address ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-lavender-100 text-lavender-700">
                                {{ $supplier->purchases_count ?? $supplier->purchases->count() }} transaksi
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-1.5">
                                <a href="{{ route('suppliers.edit', $supplier) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded-lg transition">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                @if(auth()->user() && auth()->user()->role === 'admin')
                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <i class="fas fa-truck text-5xl text-gray-200 mb-4 block"></i>
                            <p class="text-gray-500 font-medium">Belum ada supplier</p>
                            <a href="{{ route('suppliers.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-lavender-600 text-white rounded-lg text-sm hover:bg-lavender-700 transition">
                                <i class="fas fa-plus mr-2"></i> Tambah Supplier
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($suppliers->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $suppliers->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
