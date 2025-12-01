@extends('frontend.aqr.layout-new')

@section('content')
    <div class="max-w-2xl w-full space-y-8 animate-fade-in-up">
        <div class="bg-white rounded-2xl shadow-2xl p-8 border-0">
            <!-- Step 1: Validasi NISN -->
            <div id="step-nisn">
                <div class="text-center mb-8">
                    <img src="image/logo_baru.png" alt="Logo" class="mx-auto h-16 w-auto mb-4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Validasi Warga Sekolah</h2>
                    <div
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Warga Sekolah
                    </div>
                    <p class="text-gray-600 mt-4">Masukkan NISN untuk verifikasi identitas</p>
                </div>

                <!-- NISN Input -->
                <div class="space-y-6">
                    <div class="animate-slide-in-right">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-id-card mr-2 text-green-500"></i>NISN (Nomor Induk Siswa Nasional)
                        </label>
                        <input type="text" id="nisn-check"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                            placeholder="Masukkan NISN Anda">
                        <div class="mt-2 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <i class="fas fa-info-circle mr-1"></i>
                                Contoh NISN: <span class="font-mono">1234567890</span>, <span
                                    class="font-mono">1234567891</span>, <span class="font-mono">1234567892</span>
                            </p>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loading-nisn" class="hidden">
                        <div class="flex items-center justify-center py-4">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-500"></div>
                            <span class="ml-3 text-gray-600">Memvalidasi NISN...</span>
                        </div>
                    </div>

                    <!-- Error Alert -->
                    <div id="nisn-error" class="hidden">
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                            <div class="flex">
                                <i class="fas fa-exclamation-triangle text-red-400 mt-0.5"></i>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">NISN Tidak Valid</h3>
                                    <p class="mt-1 text-sm text-red-700" id="error-message"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Validate Button -->
                    <button type="button" id="btn-check-nisn"
                        class="w-full flex justify-center py-4 px-6 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 hover:shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-check-circle mr-2"></i>
                        Validasi NISN
                    </button>
                </div>
            </div>

            <!-- Step 2: Form Kritik dan Saran -->
            <div id="step-form" class="hidden">
                <form method="POST" enctype="multipart/form-data" action="{{ route('home.tiket-store') }}"
                    class="space-y-6">
                    @csrf
                    <input type="hidden" name="pengirim" value="Warga Sekolah">
                    <input type="hidden" name="nisn" id="nisn-hidden">

                    <!-- Header Form -->
                    <div class="text-center mb-8">
                        <img src="image/logo_baru.png" alt="Logo" class="mx-auto h-16 w-auto mb-4">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Kritik dan Saran</h2>
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Warga Sekolah
                        </div>
                    </div>

                    <!-- Data Siswa (Read-only) -->
                    <div class="bg-gray-50 rounded-xl p-4 space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-user-graduate mr-2 text-green-500"></i>Data Siswa
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                                <input type="text" id="nisn-display" readonly
                                    class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa</label>
                                <input type="text" name="nama" id="nama-siswa" readonly
                                    class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                            </div>
                        </div>
                    </div>

                    <!-- Nama Orang Tua -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.1s">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-users mr-2 text-green-500"></i>Nama Orang Tua (Opsional)
                        </label>
                        <input type="text" name="nama_orangtua" id="nama-orangtua"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                            placeholder="Nama orang tua/wali">
                    </div>

                    <!-- Email -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.2s">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-green-500"></i>Email
                        </label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                            placeholder="contoh@email.com">
                    </div>

                    <!-- No HP -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.3s">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-2 text-green-500"></i>Nomor Handphone
                        </label>
                        <input type="tel" name="no_hp" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                            placeholder="08xxxxxxxxxx">
                    </div>

                    <!-- Judul -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.4s">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-heading mr-2 text-green-500"></i>Judul Kritik dan Saran
                        </label>
                        <input type="text" name="judul_kendala" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:border-gray-400"
                            placeholder="Ringkasan singkat kritik/saran Anda">
                    </div>

                    <!-- Jenis Kritik -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.45s">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tags mr-2 text-green-500"></i>Jenis Kritik dan Saran
                        </label>
                        <select name="kendala" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:border-gray-400">
                            <option value="">Pilih</option>
                            <option value="BK - Layanan BK (Konseling Karir, Pemilihan Jurusan)">BK - Layanan BK (Konseling
                                Karir, Pemilihan Jurusan)</option>
                            {{-- Mba Ocha & Head RND --}}
                            <option value="Humas - PPDB">Humas - PPDB</option>
                            {{-- IT & Marketing --}}
                            <option value="Humas - Promosi dan Marketing">Humas - Promosi dan Marketing</option>
                            {{-- IT & Marketing --}}

                            <option value="Kepala Sekolah - Kedisiplinan Karakter Sikap, Karakter dan Perilaku Guru">Kepala
                                Sekolah - Kedisiplinan Karakter Sikap, Karakter dan Perilaku Guru</option>
                            {{-- Head RND & Head SDM --}}
                            <option value="Kesiswaan - Kedisiplinan, Karakter, Sikap dan Perilaku">Kesiswaan -
                                Kedisiplinan, Karakter, Sikap dan Perilaku</option>
                            {{-- Head RND & Head SDM --}}
                            <option value="Kesiswaan - Kegiatan Ekstrakurikuler dan Club">Kesiswaan - Kegiatan
                                Ekstrakurikuler dan Club</option>
                            {{-- Head RND & Head SDM --}}
                            <option value="Kesiswaan - Kegiatan Organisasi">Kesiswaan - Kegiatan Organisasi</option>
                            {{-- Head RND --}}
                            <option value="Kesiswaan - Layanan Kesehatan (UKS)">Kesiswaan - Layanan Kesehatan (UKS)

                            </option>
                            {{-- Head RND & GA --}}
                            <option value="Kesiswaan - Layanan Perpustakaan">Kesiswaan - Layanan Perpustakaan</option>
                            {{-- Head RND & GA --}}
                            <option value="Koperasi - Antar Jemput">Koperasi - Antar Jemput</option>
                            {{-- GA & Koperasi --}}
                            <option value="Koperasi - Pembelian Seragam dan Buku">Koperasi - Pembelian Seragam dan Buku
                            </option>
                            {{-- GA & Koperasi --}}
                            <option value="Kurikulum - Akademik">Kurikulum - Akademik</option>
                            {{-- RND --}}
                            <option value="Kurikulum - Jadwal Belajar">Kurikulum - Jadwal Belajar</option>
                            {{-- RND --}}
                            <option value="Kurikulum - Kegiatan Belajar Mengajar (Mutu Pembelajaran)">Kurikulum - Kegiatan
                                Belajar Mengajar (Mutu Pembelajaran)</option>
                            {{-- RND --}}
                            <option value="Kurikulum - Kurikulum">Kurikulum - Kurikulum</option>
                            {{-- RND --}}
                            <option value="Kurikulum - Laboratorium">Kurikulum - Laboratorium</option>
                            {{-- RND --}}
                            <option value="Psikolog & BK - Motivasi, Kepercayaan Diri & Komunikasi">Psikolog & BK -
                                Motivasi, Kepercayaan Diri & Komunikasi</option>
                            {{-- Mba Ocha & Head RND --}}
                            <option value="Psikolog & BK - Perundungan, kekerasan dan pelecehan seksual">Psikolog & BK -
                                Perundungan, kekerasan dan pelecehan seksual</option>
                            {{-- Mba Ocha & Head RND --}}
                            <option
                                value="Psikolog - Layanan Psikologi (Tumbuh Kembang Anak & Parenting, Masalah Kepribadian, Permasalah psikologis, kesulitan belajar spesifik dan permasalahan psikologis lainnya)">
                                Psikolog - Layanan Psikologi (Tumbuh Kembang Anak & Parenting, Masalah Kepribadian,
                                Permasalah psikologis, kesulitan belajar spesifik dan permasalahan psikologis lainnya)
                            </option>
                            {{-- Mba Ocha & Head RND --}}

                            <option value="Tata Usaha - Keuangan">Tata Usaha - Keuangan</option>
                            {{-- Keuangan --}}
                            <option value="Tata Usaha - Administrasi (Rapot, Ijazah dan sejenisnya)">Tata Usaha -
                                Administrasi (Rapot, Ijazah dan sejenisnya)</option>
                            {{-- Mba Yuli --}}

                            <option value="Tata Usaha - Kebersihan">Tata Usaha - Kebersihan</option>
                            {{-- GA & Koperasi --}}
                            <option value="Tata Usaha - Keamanan">Tata Usaha - Keamanan</option>
                            {{-- GA & Koperasi --}}
                            <option
                                value="Tata Usaha - Pemeliharaan Gedung (Maintenance, Internet, Mekanikal, Elektrikal, dan Plumbing (Saluran Air))">
                                Tata Usaha - Pemeliharaan Gedung (Maintenance, Internet, Mekanikal, Elektrikal, dan Plumbing
                                (Saluran Air))</option>
                            {{-- GA ,IT & PPG --}}
                            <option value="Tata Usaha - Sarana dan Prasarana (Fasilitas Umum & Fasilitas Ruangan)">Tata
                                Usaha - Sarana dan Prasarana (Fasilitas Umum & Fasilitas Ruangan)</option>
                            {{-- GA & PPG --}}

                            <option
                                value="Wali Kelas - Motivasi Belajar, Sikap Guru, Layanan Pembelajaran, Pengawasan Perkembangan Siswa, Kegiatan Kelas dan Pengelolaan Kelas">
                                Wali Kelas - Motivasi Belajar, Sikap Guru, Layanan Pembelajaran, Pengawasan Perkembangan
                                Siswa, Kegiatan Kelas dan Pengelolaan Kelas</option>
                            {{-- RND & SDM --}}
                        </select>
                    </div>

                    <!-- Lokasi -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.47s">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>Lokasi
                        </label>
                        <select name="lokasi_kendala" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:border-gray-400">
                            <option value="">Pilih</option>
                            <option value="KB Avicenna Pamulang">KB Avicenna Pamulang</option>
                            <option value="TK Avicenna Jagakarsa">TK Avicenna Jagakarsa</option>
                            <option value="SD Avicenna Jagakarsa">SD Avicenna Jagakarsa</option>
                            <option value="SMP Avicenna Jagakarsa">SMP Avicenna Jagakarsa</option>
                            <option value="SMA Avicenna Jagakarsa">SMA Avicenna Jagakarsa</option>
                            <option value="SD Avicenna Cinere">SD Avicenna Cinere</option>
                            <option value="SMP Avicenna Cinere">SMP Avicenna Cinere</option>
                            <option value="SMA Avicenna Cinere">SMA Avicenna Cinere</option>
                        </select>
                    </div>

                    <!-- Detail -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.5s">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment-alt mr-2 text-green-500"></i>Detail Kritik dan Saran
                        </label>
                        <textarea name="detail_kendala" required rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:border-gray-400 resize-none"
                            placeholder="Deskripsikan area detail kritik atau saran Anda. Misal : Ruang Kelas 2A, Area Parkir, Area Kantin dsb..."></textarea>
                    </div>

                    <!-- File Upload -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.6s">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-paperclip mr-2 text-green-500"></i>Lampiran (Opsional)
                        </label>
                        <div class="relative">
                            <input type="file" name="choosefile" accept="image/*" id="file-upload" class="hidden">
                            <label for="file-upload"
                                class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-green-400 hover:bg-green-50 transition-all duration-300">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600">Klik untuk upload foto/screenshot</p>
                                    <p class="text-xs text-gray-400">PNG, JPG hingga 10MB</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4 animate-slide-in-right" style="animation-delay: 0.7s">
                        <button type="button" id="btn-back"
                            class="flex-1 flex justify-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </button>
                        <button type="submit"
                            class="flex-1 flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 hover:shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Kritik dan Saran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Validasi NISN
                $('#btn-check-nisn').click(function() {
                    const nisn = $('#nisn-check').val().trim();

                    if (!nisn) {
                        showError('NISN harus diisi');
                        return;
                    }

                    // Show loading
                    $('#loading-nisn').removeClass('hidden');
                    $('#nisn-error').addClass('hidden');
                    $(this).prop('disabled', true);

                    $.ajax({
                        url: '{{ route('home.get-siswa') }}',
                        method: 'POST',
                        data: {
                            nisn: nisn,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#loading-nisn').addClass('hidden');

                            if (response.success) {
                                // Animate transition to form
                                $('#step-nisn').fadeOut(300, function() {
                                    $('#step-form').fadeIn(300);
                                });

                                // Fill form data
                                $('#nisn-hidden').val(nisn);
                                $('#nisn-display').val(nisn);
                                $('#nama-siswa').val(response.data.nama);
                                $('#nama-orangtua').val(response.data.nama_orangtua || '');
                            } else {
                                showError(response.message);
                            }
                        },
                        error: function() {
                            $('#loading-nisn').addClass('hidden');
                            showError('Terjadi kesalahan sistem. Silakan coba lagi.');
                        },
                        complete: function() {
                            $('#btn-check-nisn').prop('disabled', false);
                        }
                    });
                });

                // Back button
                $('#btn-back').click(function() {
                    $('#step-form').fadeOut(300, function() {
                        $('#step-nisn').fadeIn(300);
                        $('#nisn-check').val('').focus();
                        $('#nisn-error').addClass('hidden');
                    });
                });

                // Enter key validation
                $('#nisn-check').keypress(function(e) {
                    if (e.which == 13) {
                        $('#btn-check-nisn').click();
                    }
                });

                // File upload handler
                $('#file-upload').change(function(e) {
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

                function showError(message) {
                    $('#error-message').text(message);
                    $('#nisn-error').removeClass('hidden');
                    $('#nisn-check').focus();
                }
            });
        </script>
    @endpush
@endsection
