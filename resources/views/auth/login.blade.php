<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Inventaris Musik</title>

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
        .bg-pattern {
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(167, 139, 250, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(124, 58, 237, 0.1) 0%, transparent 50%);
        }
        .login-card {
            backdrop-filter: blur(10px);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-lavender-950 via-lavender-900 to-lavender-800 bg-pattern">

    <div class="min-h-screen flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">

            <!-- Login Card -->
            <div class="login-card bg-white bg-opacity-95 rounded-2xl shadow-2xl overflow-hidden">

                <!-- Header -->
                <div class="bg-gradient-to-r from-lavender-600 to-lavender-700 px-8 py-8 text-center">
                    <div class="float-animation inline-block mb-4">
                        <span class="text-6xl">🎵</span>
                    </div>
                    <h1 class="text-2xl font-bold text-white tracking-wide">Inventaris Musik</h1>
                    <p class="mt-2 text-sm text-lavender-200 leading-relaxed">
                        Sistem Manajemen Inventaris & Penjualan Alat Musik
                    </p>
                </div>

                <!-- Form -->
                <div class="px-8 py-8">

                    <!-- Error Messages -->
                    @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle mt-0.5 mr-2 text-red-500"></i>
                            <div class="text-sm">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email"
                                       name="email"
                                       type="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus
                                       autocomplete="email"
                                       placeholder="nama@email.com"
                                       class="block w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg
                                              focus:ring-2 focus:ring-lavender-500 focus:border-lavender-500
                                              placeholder-gray-400 transition-colors
                                              @error('email') border-red-500 @enderror">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password"
                                       name="password"
                                       type="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="••••••••"
                                       class="block w-full pl-10 pr-12 py-2.5 text-sm border border-gray-300 rounded-lg
                                              focus:ring-2 focus:ring-lavender-500 focus:border-lavender-500
                                              placeholder-gray-400 transition-colors
                                              @error('password') border-red-500 @enderror">
                                <button type="button"
                                        onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                                    <i id="passwordIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       name="remember"
                                       {{ old('remember') ? 'checked' : '' }}
                                       class="w-4 h-4 rounded border-gray-300 text-lavender-600
                                              focus:ring-lavender-500 cursor-pointer">
                                <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full py-2.5 px-4 bg-gradient-to-r from-lavender-600 to-lavender-700
                                       text-white text-sm font-semibold rounded-lg
                                       hover:from-lavender-700 hover:to-lavender-800
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lavender-500
                                       transform transition-all duration-200 hover:shadow-lg active:scale-[0.98]">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk
                        </button>
                    </form>
                </div>
            </div>

            <!-- Demo Credentials -->
            <div class="mt-6 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-5 border border-white border-opacity-20">
                <div class="flex items-center mb-3">
                    <i class="fas fa-info-circle text-lavender-300 mr-2"></i>
                    <h3 class="text-sm font-semibold text-white">Demo Credentials</h3>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between bg-white bg-opacity-10 rounded-lg px-4 py-2.5">
                        <div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-lavender-500 text-white mr-2">
                                Admin
                            </span>
                            <span class="text-sm text-lavender-100">admin@admin.com</span>
                        </div>
                        <span class="text-sm text-lavender-300 font-mono">password</span>
                    </div>
                    <div class="flex items-center justify-between bg-white bg-opacity-10 rounded-lg px-4 py-2.5">
                        <div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-500 text-white mr-2">
                                Staff
                            </span>
                            <span class="text-sm text-lavender-100">staff@admin.com</span>
                        </div>
                        <span class="text-sm text-lavender-300 font-mono">password</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <p class="mt-6 text-center text-xs text-lavender-300 opacity-70">
                &copy; {{ date('Y') }} Inventaris Musik. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('passwordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
