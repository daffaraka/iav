@extends('frontend.aqr.layout-new')

@section('content')
    <div class="max-w-2xl w-full space-y-8 animate-fade-in-up">

        @if ($errors->any())
            <div class="bg-white border border-red-200 rounded-xl p-4 mb-6">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-red-400 mt-0.5"></i>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terjadi Kesalahan</h3>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-white border border-red-200 rounded-xl p-4 mb-6">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-red-400 mt-0.5"></i>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Error</h3>
                        <p class="mt-1 text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="bg-white rounded-2xl shadow-2xl p-8 border-2 border-gray-200">
            <!-- Header -->
            <div class="text-center mb-8">
                <img src="image/logo_baru.png" alt="Logo" class="mx-auto h-16 w-auto mb-4">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Kritik dan Saran</h2>
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    Masyarakat Umum
                </div>
            </div>

            <!-- Form -->
            <form method="POST" enctype="multipart/form-data" action="{{ route('helpdesk.home.tiket-store') }}"
                class="space-y-6">
                @csrf
                <input type="hidden" name="pengirim" value="Masyarakat Umum">

                <!-- Nama -->
                <div class="animate-slide-in-right" style="animation-delay: 0.1s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input type="text" name="nama" required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                        placeholder="Masukkan nama lengkap Anda">
                </div>

                <!-- Email -->
                <div class="animate-slide-in-right" style="animation-delay: 0.2s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                        placeholder="contoh@email.com">
                </div>

                <!-- No HP -->
                <div class="animate-slide-in-right" style="animation-delay: 0.3s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Handphone
                    </label>
                    <input type="tel" name="no_hp" required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                        placeholder="08xxxxxxxxxx">
                </div>

                <!-- Judul -->
                <div class="animate-slide-in-right" style="animation-delay: 0.4s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Kritik dan Saran
                    </label>
                    <input type="text" name="judul_kendala" required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                        placeholder="Ringkasan singkat kritik/saran Anda">
                </div>

                <!-- Detail -->
                <div class="animate-slide-in-right" style="animation-delay: 0.5s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Detail Kritik dan Saran
                    </label>
                    <textarea name="detail_kendala" required rows="4"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-400 resize-none"
                        placeholder="Jelaskan secara detail kritik atau saran Anda..."></textarea>
                </div>

                <!-- File Upload -->
                <div class="animate-slide-in-right" style="animation-delay: 0.6s">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lampiran (Opsional)
                    </label>
                    <div class="relative">
                        <input type="file" name="choosefile" accept="image/*" id="file-upload" class="hidden">
                        <label for="file-upload"
                            class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all duration-300">
                            <div class="text-center">
                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">Klik untuk upload foto/screenshot</p>
                                <p class="text-xs text-gray-400">PNG, JPG hingga 10MB</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="animate-slide-in-right" style="animation-delay: 0.7s">
                    <button type="submit"
                        class="w-full flex justify-center py-4 px-6 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white gradient-bg hover:shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Kirim Kritik dan Saran
                    </button>
                </div>
            </form>

            <!-- Back Button -->
            <div class="mt-6 text-center animate-slide-in-right" style="animation-delay: 0.8s">
                <a href="{{ route('helpdesk.home.cek-pengirim') }}"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke pilihan pengirim
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('file-upload').addEventListener('change', function(e) {
                const label = e.target.nextElementSibling;
                const fileName = e.target.files[0]?.name;
                if (fileName) {
                    label.innerHTML = `
            <div class="text-center">
                <i class="fas fa-check-circle text-2xl text-green-500 mb-2"></i>
                <p class="text-sm text-green-600">${fileName}</p>
                <p class="text-xs text-gray-400">File berhasil dipilih</p>
            </div>
        `;
                    label.classList.add('border-green-400', 'bg-green-50');
                    label.classList.remove('border-gray-300');
                }
            });
        </script>
    @endpush
@endsection
