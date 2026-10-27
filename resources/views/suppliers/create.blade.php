@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
<div class="space-y-6">
    <nav class="text-sm text-gray-500 flex items-center space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-lavender-600">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('suppliers.index') }}" class="hover:text-lavender-600">Supplier</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 font-medium">Tambah</span>
    </nav>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-lavender-50">
                <h2 class="text-lg font-semibold text-lavender-800">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Supplier Baru
                </h2>
            </div>
            <form action="{{ route('suppliers.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Supplier <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border @error('name') border-red-400 @enderror"
                           placeholder="PT Yamaha Music Indonesia">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border"
                               placeholder="021-1234567">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border @error('email') border-red-400 @enderror"
                               placeholder="supplier@example.com">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 text-sm px-3 py-2 border"
                              placeholder="Alamat lengkap supplier">{{ old('address') }}</textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-lavender-600 hover:bg-lavender-700 text-white font-semibold rounded-lg shadow transition">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('suppliers.index') }}"
                       class="inline-flex items-center px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow transition">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
