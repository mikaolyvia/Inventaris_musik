@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <!-- Breadcrumb -->
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-lavender-600 transition">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('categories.index') }}" class="hover:text-lavender-600 transition">Kategori</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">Edit</span>
    </nav>

    <!-- Header -->
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kategori</h1>

    <!-- Form Card -->
    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Kategori -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-lavender-500 focus:border-lavender-500 px-4 py-2 border @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama kategori" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-3">
                    <button type="submit"
                            class="px-6 py-2.5 bg-lavender-600 hover:bg-lavender-700 text-white font-semibold rounded-lg shadow transition">
                        Simpan
                    </button>
                    <a href="{{ route('categories.index') }}"
                       class="px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
