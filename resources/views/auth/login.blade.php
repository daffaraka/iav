<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen grid grid-cols-2">

        {{-- Kolom Kiri: Branding --}}
        <div class="flex flex-col items-center justify-center p-12 bg-gray-500 text-white">
            <a href="/">
                <x-application-logo class="w-32 h-32 fill-current text-white mb-8" />
            </a>
            <h1 class="text-4xl font-bold mb-4">Avicenna School Manajemen System</h1>
            <p class="text-indigo-200 text-center text-lg max-w-sm">
                Selamat datang kembali. Masuk untuk melanjutkan aktivitas Anda.
            </p>
        </div>

        {{-- Kolom Kanan: Form --}}
        <div class="flex flex-col items-center justify-center px-8 py-12 bg-gray-50 dark:bg-gray-900">

            <div class="w-full max-w-md">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Masuk ke Akun</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">Masukkan email dan password Anda</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Remember Me --}}
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button class="ms-auto">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>

</html>
