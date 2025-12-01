@extends('frontend.aqr.layout-new')

@section('content')
<div class="max-w-md w-full space-y-8 animate-fade-in-up">
    <div class="bg-white rounded-2xl shadow-2xl p-8 border-0">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="{{asset('image/avicenna-helpdesk.png')}}" alt="Logo" class="mx-auto h-24 w-auto mb-4">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Cek Status Tiket</h2>
            <p class="text-gray-600">Masukkan nomor tiket dan email untuk melihat status</p>
        </div>

        <!-- Alert Messages -->
        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex">
                <i class="fas fa-exclamation-triangle text-red-400 mt-0.5"></i>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('home.pencarianTiket') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nomor Tiket -->
            <div class="animate-slide-in-right" style="animation-delay: 0.1s">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-ticket-alt mr-2 text-blue-500"></i>Nomor Tiket
                </label>
                <input type="text" name="no_tiket" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                       placeholder="Masukkan nomor tiket (6 digit)">
            </div>

            <!-- Email -->
            <div class="animate-slide-in-right" style="animation-delay: 0.2s">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-blue-500"></i>Email
                </label>
                <input type="email" name="email" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                       placeholder="Email yang digunakan saat membuat tiket">
            </div>

            <!-- Submit Button -->
            <div class="animate-slide-in-right" style="animation-delay: 0.3s">
                <button type="submit"
                        class="w-full flex justify-center py-4 px-6 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white gradient-bg hover:shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-search mr-2"></i>
                    Cari Tiket
                </button>
            </div>
        </form>

        <!-- Back Button -->
        <div class="mt-6 text-center animate-slide-in-right" style="animation-delay: 0.4s">
            <a href="{{ route('home.cek-pengirim') }}"
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke beranda
            </a>
        </div>
    </div>
</div>
@endsection
