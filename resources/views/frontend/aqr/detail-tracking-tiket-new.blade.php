@extends('frontend.aqr.layout-new')

@section('content')
<div class="max-w-4xl w-full space-y-8 animate-fade-in-up">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-2xl p-8 border-0">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Tiket</h1>
                <p class="text-xl text-gray-600">No: <span class="font-mono font-bold text-blue-600">{{ $tiket->no_tiket }}</span></p>
            </div>
            <div class="mt-4 md:mt-0 flex flex-col items-end space-y-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $tiket->status == 'New' ? 'bg-blue-100 text-blue-800' :
                       ($tiket->status == 'Proses' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                    <i class="fas fa-circle mr-2 text-xs"></i>
                    {{ $tiket->status }}
                </span>
                <span class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    {{ $tiket->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') }}
                </span>
            </div>
        </div>

        <!-- Satisfaction Survey Button -->
        @if ($tiket->status == 'Selesai')
            <div class="mb-6">
                @if ($tiket->kepuasan == null)
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors duration-300"
                            onclick="document.getElementById('satisfyModal').classList.remove('hidden')">
                        <i class="fas fa-star mr-2"></i>
                        Isi Tingkat Kepuasan
                    </button>
                @else
                    <div class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        Survey kepuasan telah diisi: <span class="font-semibold ml-1">{{ $tiket->kepuasan }}</span>
                    </div>
                @endif
            </div>
        @endif

        <!-- Ticket Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Personal Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">
                    <i class="fas fa-user mr-2 text-blue-500"></i>Informasi Pelapor
                </h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $tiket->nama }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $tiket->email }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Handphone</label>
                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $tiket->no_hp }}</div>
                </div>

                @if($tiket->pengirim == 'Warga Sekolah')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                        <div class="px-3 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $tiket->nisn ?? '-' }}</div>
                    </div>

                    @if($tiket->nama_orangtua)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Orang Tua</label>
                        <div class="px-3 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $tiket->nama_orangtua }}</div>
                    </div>
                    @endif
                @endif
            </div>

            <!-- Ticket Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">
                    <i class="fas fa-ticket-alt mr-2 text-green-500"></i>Informasi Tiket
                </h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pengirim</label>
                    <div class="px-3 py-2 bg-gray-50 rounded-lg">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            {{ $tiket->pengirim == 'Warga Sekolah' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            <i class="fas {{ $tiket->pengirim == 'Warga Sekolah' ? 'fa-graduation-cap' : 'fa-users' }} mr-1"></i>
                            {{ $tiket->pengirim }}
                        </span>
                    </div>
                </div>

                @if($tiket->lokasi_kendala)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $tiket->lokasi_kendala }}</div>
                </div>
                @endif

                @if($tiket->problem)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kritik/Saran</label>
                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $tiket->problem }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Ticket Content -->
        <div class="mt-8 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Aduan</label>
                <div class="px-4 py-3 bg-gray-50 rounded-xl text-gray-900 font-medium">{{ $tiket->judul_kendala }}</div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Detail Kendala</label>
                <div class="px-4 py-3 bg-gray-50 rounded-xl text-gray-900 whitespace-pre-wrap">{{ $tiket->detail_kendala }}</div>
            </div>

            @if($tiket->filename)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran</label>
                <div class="flex items-center space-x-3">
                    <a href="{{ asset($tiket->filename) }}" target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                        <i class="fas fa-eye mr-2"></i>
                        Lihat Lampiran
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Progress Cards -->
    @if($tiket->pic_id != null && $tiket->progres->count() > 0)
        <div class="space-y-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                <i class="fas fa-history mr-2 text-blue-500"></i>Riwayat Penanganan
            </h2>

            @foreach($tiket->progres as $progres)
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 animate-slide-in-right"
                 style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $tiket->pic->name }}</h3>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $progres->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Update #{{ $loop->iteration }}
                    </span>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Penanganan</label>
                        <div class="px-4 py-3 bg-gray-50 rounded-xl text-gray-900 whitespace-pre-wrap">{{ $progres->penanganan }}</div>
                    </div>

                    @if($progres->fotopengerjaan)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Penanganan</label>
                        <a href="{{ asset($progres->fotopengerjaan) }}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
                            <i class="fas fa-image mr-2"></i>
                            Lihat Foto Penanganan
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('home.tiket-tracking') }}"
           class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Pencarian
        </a>
    </div>
</div>

<!-- Satisfaction Modal -->
@if($tiket->status == 'Selesai' && $tiket->kepuasan == null)
<div id="satisfyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in-up">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tingkat Kepuasan</h3>
                <button onclick="document.getElementById('satisfyModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('home.kepuasan-store', $tiket->id) }}" method="POST" class="space-y-4">
                @csrf
                <p class="text-gray-600 mb-4">Bagaimana tingkat kepuasan Anda terhadap penanganan tiket ini?</p>

                <div class="space-y-3">
                    <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-green-50 cursor-pointer">
                        <input type="radio" name="kepuasan" value="Puas" required class="mr-3 text-green-600">
                        <div class="flex items-center">
                            <i class="fas fa-smile text-green-500 mr-2"></i>
                            <span class="text-gray-900">Puas</span>
                        </div>
                    </label>

                    <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-red-50 cursor-pointer">
                        <input type="radio" name="kepuasan" value="Tidak Puas" required class="mr-3 text-red-600">
                        <div class="flex items-center">
                            <i class="fas fa-frown text-red-500 mr-2"></i>
                            <span class="text-gray-900">Tidak Puas</span>
                        </div>
                    </label>
                </div>

                <div class="flex space-x-3 mt-6">
                    <button type="button"
                            onclick="document.getElementById('satisfyModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors duration-300">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
