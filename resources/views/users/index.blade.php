@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="space-y-6">
    <nav class="text-sm text-gray-500 flex items-center space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-lavender-600">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 font-medium">Kelola User</span>
    </nav>

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola User</h1>
            <p class="text-sm text-gray-500 mt-1">Manajemen pengguna sistem</p>
        </div>
        <a href="{{ route('users.create') }}"
           class="inline-flex items-center px-4 py-2 bg-lavender-600 hover:bg-lavender-700 text-white font-semibold rounded-lg shadow transition text-sm">
            <i class="fas fa-user-plus mr-2"></i> Tambah User
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-lavender-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-lavender-700 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-lavender-700 uppercase tracking-wider">Dibuat</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-lavender-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $index => $user)
                    <tr class="hover:bg-purple-50/40 transition-colors {{ $user->id === auth()->id() ? 'bg-lavender-50/50' : '' }}">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $users->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-lavender-200 flex items-center justify-center flex-shrink-0">
                                    <span class="text-lavender-700 font-semibold text-xs">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    @if($user->id === auth()->id())
                                        <span class="text-xs text-lavender-500">(Anda)</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-lavender-100 text-lavender-700">
                                    <i class="fas fa-crown mr-1 text-xs"></i> Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    <i class="fas fa-user mr-1 text-xs"></i> Staff
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-1.5">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded-lg transition">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
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
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            <i class="fas fa-users text-4xl mb-3 block text-gray-200"></i>
                            <p>Belum ada user</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
