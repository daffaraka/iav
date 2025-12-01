@extends('frontend.aqr.layout-new')

@section('content')
<div class="max-w-md w-full space-y-8 animate-fade-in-up">
    <div class="bg-white rounded-2xl shadow-2xl p-8 border-0">
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="image/avicenna-helpdesk.png" alt="AQR Logo" class="mx-auto h-20 w-auto mb-4">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Avicenna Quick Response</h2>
            <p class="text-gray-600">Pilih Jenis Pengirim</p>
        </div>

        <!-- Pilihan Pengirim -->
        <div class="space-y-4">
            <!-- Masyarakat Umum -->
            <a href="{{ route('helpdesk.home.open-tiket', ['pengirim' => 'Masyarakat Umum']) }}"
               class="group relative w-full flex justify-center py-4 px-6 border border-transparent text-sm font-medium rounded-xl text-white gradient-bg hover:shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out">
                <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                    <i class="fas fa-users text-white group-hover:text-yellow-200 transition-colors duration-300"></i>
                </span>
                <span class="ml-3">Masyarakat Umum</span>
                <span class="absolute right-0 inset-y-0 flex items-center pr-4">
                    <i class="fas fa-arrow-right text-white group-hover:translate-x-1 transition-transform duration-300"></i>
                </span>
            </a>

            <!-- Warga Sekolah -->
            <a href="{{ route('helpdesk.home.open-tiket', ['pengirim' => 'Warga Sekolah']) }}"
               class="group relative w-full flex justify-center py-4 px-6 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 hover:shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out">
                <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                    <i class="fas fa-graduation-cap text-white group-hover:text-yellow-200 transition-colors duration-300"></i>
                </span>
                <span class="ml-3">Warga Sekolah</span>
                <span class="absolute right-0 inset-y-0 flex items-center pr-4">
                    <i class="fas fa-arrow-right text-white group-hover:translate-x-1 transition-transform duration-300"></i>
                </span>
            </a>
        </div>

        <!-- Divider -->
        <div class="my-8">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">atau</span>
                </div>
            </div>
        </div>

        <!-- Cek Proses -->
        <a href="{{ route('helpdesk.home.tiket-tracking') }}"
           class="group relative w-full flex justify-center py-4 px-6 border-2 border-gray-300 text-sm font-medium rounded-xl hover:text-white bg-gray-900 text-white hover:bg-gray-700 hover:border-gray-400 hover:shadow-md transform hover:scale-105 transition-all duration-300 ease-in-out">
            <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                <i class="fas fa-search text-gray-500 group-hover:text-white transition-colors duration-300"></i>
            </span>
            <span class="ml-3 hover:text-white">Cek Proses Tiket</span>
            <span class="absolute right-0 inset-y-0 flex items-center pr-4">
                <i class="fas fa-arrow-right text-gray-500 group-hover:translate-x-1 hover:text-white transition-all duration-300"></i>
            </span>
        </a>
    </div>

    <!-- Footer -->
    <div class="text-center text-sm text-gray-500 animate-slide-in-right">
        <p>© 2024 Avicenna School. Semua hak dilindungi.</p>
    </div>
</div>
@endsection
