<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Inventaris Musik</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        lavender: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                            950: '#2e1065',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Sidebar transition */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        /* Overlay transition */
        .overlay-transition {
            transition: opacity 0.3s ease-in-out;
        }
        /* Scrollbar styling for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 2px;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden overlay-transition opacity-0 lg:hidden"
         onclick="toggleSidebar()">
    </div>

    <!-- Sidebar -->
    <aside id="sidebar"
           class="fixed top-0 left-0 z-50 h-full w-64 bg-lavender-950 text-white sidebar-transition transform -translate-x-full lg:translate-x-0 flex flex-col">

        <!-- Logo Area -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-lavender-800">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <span class="text-3xl">🎵</span>
                <span class="text-xl font-bold tracking-wide">Inventaris Musik</span>
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden text-lavender-300 hover:text-white">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('dashboard') ? 'bg-lavender-700 text-white border-l-4 border-lavender-300' : 'text-lavender-200 hover:bg-lavender-800 hover:text-white' }}">
                <i class="fas fa-home w-5 text-center mr-3"></i>
                <span>Dashboard</span>
            </a>

            <!-- Master Data Section -->
            <div class="mt-6 mb-2 px-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-lavender-400">Master Data</p>
            </div>

            <a href="{{ route('categories.index') }}"
               class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('categories.*') ? 'bg-lavender-700 text-white border-l-4 border-lavender-300' : 'text-lavender-200 hover:bg-lavender-800 hover:text-white' }}">
                <i class="fas fa-folder w-5 text-center mr-3"></i>
                <span>Kategori</span>
            </a>

            <a href="{{ route('products.index') }}"
               class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('products.*') ? 'bg-lavender-700 text-white border-l-4 border-lavender-300' : 'text-lavender-200 hover:bg-lavender-800 hover:text-white' }}">
                <i class="fas fa-box w-5 text-center mr-3"></i>
                <span>Produk</span>
            </a>

            <a href="{{ route('suppliers.index') }}"
               class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('suppliers.*') ? 'bg-lavender-700 text-white border-l-4 border-lavender-300' : 'text-lavender-200 hover:bg-lavender-800 hover:text-white' }}">
                <i class="fas fa-truck w-5 text-center mr-3"></i>
                <span>Supplier</span>
            </a>

            <!-- Transaksi Section -->
            <div class="mt-6 mb-2 px-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-lavender-400">Transaksi</p>
            </div>

            <a href="{{ route('purchases.index') }}"
               class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('purchases.*') ? 'bg-lavender-700 text-white border-l-4 border-lavender-300' : 'text-lavender-200 hover:bg-lavender-800 hover:text-white' }}">
                <i class="fas fa-shopping-cart w-5 text-center mr-3"></i>
                <span>Pembelian</span>
            </a>

            <a href="{{ route('sales.index') }}"
               class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('sales.*') ? 'bg-lavender-700 text-white border-l-4 border-lavender-300' : 'text-lavender-200 hover:bg-lavender-800 hover:text-white' }}">
                <i class="fas fa-cash-register w-5 text-center mr-3"></i>
                <span>Penjualan</span>
            </a>

            <!-- Laporan Section -->
            <div class="mt-6 mb-2 px-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-lavender-400">Laporan</p>
            </div>

            <a href="{{ route('products.low-stock') }}"
               class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('products.low-stock') ? 'bg-lavender-700 text-white border-l-4 border-lavender-300' : 'text-lavender-200 hover:bg-lavender-800 hover:text-white' }}">
                <i class="fas fa-exclamation-triangle w-5 text-center mr-3"></i>
                <span>Stok Rendah</span>
            </a>

            <!-- Admin Section (Admin Only) -->
            @if(auth()->user() && auth()->user()->role === 'admin')
            <div class="mt-6 mb-2 px-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-lavender-400">Admin</p>
            </div>

            <a href="{{ route('users.index') }}"
               class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('users.*') ? 'bg-lavender-700 text-white border-l-4 border-lavender-300' : 'text-lavender-200 hover:bg-lavender-800 hover:text-white' }}">
                <i class="fas fa-users w-5 text-center mr-3"></i>
                <span>Kelola User</span>
            </a>
            @endif
        </nav>

        <!-- Sidebar Footer -->
        <div class="px-4 py-4 border-t border-lavender-800">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-lavender-700 flex items-center justify-center">
                    <i class="fas fa-user text-sm text-lavender-200"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-lavender-400 truncate capitalize">{{ auth()->user()->role ?? 'staff' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="lg:ml-64 min-h-screen flex flex-col">

        <!-- Top Navbar -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-4 sm:px-6 py-4">

                <!-- Left: Hamburger + Page Title -->
                <div class="flex items-center space-x-4">
                    <button onclick="toggleSidebar()"
                            class="lg:hidden text-gray-600 hover:text-lavender-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg sm:text-xl font-semibold text-gray-800">
                        @yield('title', 'Dashboard')
                    </h1>
                </div>

                <!-- Right: User Dropdown -->
                <div class="relative" id="userDropdownContainer">
                    <button onclick="toggleUserDropdown()"
                            class="flex items-center space-x-3 text-gray-700 hover:text-lavender-600 focus:outline-none transition-colors">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-medium">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role ?? 'staff' }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-lavender-100 flex items-center justify-center">
                            <i class="fas fa-user text-lavender-600"></i>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userDropdown"
                         class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                        <div class="px-4 py-3 border-b border-gray-100 sm:hidden">
                            <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role ?? 'staff' }}</p>
                        </div>
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-lavender-50 hover:text-lavender-600 transition-colors">
                            <i class="fas fa-tachometer-alt w-5 mr-2 text-gray-400"></i>
                            Dashboard
                        </a>
                        <hr class="my-1 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt w-5 mr-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
        <div id="flashSuccess"
             class="mx-4 sm:mx-6 mt-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between shadow-sm"
             role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600 ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div id="flashError"
             class="mx-4 sm:mx-6 mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between shadow-sm"
             role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 px-4 sm:px-6 py-3">
            <p class="text-xs text-gray-400 text-center">
                &copy; {{ date('Y') }} Inventaris Musik. All rights reserved.
            </p>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                // Open sidebar
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                // Close sidebar
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                document.body.style.overflow = '';
            }
        }

        // User Dropdown Toggle
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const container = document.getElementById('userDropdownContainer');
            const dropdown = document.getElementById('userDropdown');
            if (container && !container.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Auto-dismiss flash messages after 5 seconds
        setTimeout(() => {
            const flash = document.getElementById('flashSuccess');
            if (flash) {
                flash.style.transition = 'opacity 0.5s';
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 500);
            }
        }, 5000);

        setTimeout(() => {
            const flash = document.getElementById('flashError');
            if (flash) {
                flash.style.transition = 'opacity 0.5s';
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 500);
            }
        }, 7000);
    </script>

    @stack('scripts')
</body>
</html>
