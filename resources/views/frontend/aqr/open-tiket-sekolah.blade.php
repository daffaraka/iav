@extends('home.layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col">
                            <div class="p-5">
                                <!-- Step 1: Validasi NISN -->
                                <div id="step-nisn" style="display: block;">
                                    <div class="container">
                                        <img src="image/logo_baru.png" class="img-fluid" width="300" alt="Sample image">
                                        <hr>
                                        <div class="text-gray-800 my-4">
                                            <h3 class="text-center">Validasi Warga Sekolah</h3>
                                            <p class="text-center text-muted">Masukkan NISN untuk verifikasi</p>
                                        </div>

                                        <div class="form-input mb-3">
                                            <strong><label class="cd-label left-text">NISN</label></strong>
                                            <input class="form-control" type="text" id="nisn-check"
                                                placeholder="Masukkan NISN" autocomplete="off" required>
                                            <small class="text-muted">Contoh: 1234567890, 1234567891, 1234567892</small>
                                        </div>

                                        <div class="mt-3 text-center">
                                            <button class="btn btn-primary w-100" type="button"
                                                id="btn-check-nisn">Validasi NISN</button>
                                        </div>

                                        <div id="nisn-error" class="alert alert-danger mt-3" style="display: none;"></div>
                                    </div>
                                </div>

                                <!-- Step 2: Form Kritik dan Saran -->
                                <div id="step-form" style="display: none;">
                                    <form method="POST" enctype="multipart/form-data"
                                        action="{{ route('home.tiket-store') }}">
                                        @csrf
                                        <input type="hidden" name="pengirim" value="Warga Sekolah">
                                        <input type="hidden" name="nisn" id="nisn-hidden">

                                        <div class="container">
                                            <div class="row">
                                                <div class="">
                                                    <img src="image/logo_baru.png" class="img-fluid" width="300"
                                                        alt="Sample image">
                                                    <hr>
                                                    <div class="container">
                                                        <div class="text-gray-800 my-4">
                                                            <h3 class="text-center">Isi Detail Kritik dan Saran</h3>
                                                            <p class="text-center text-muted">Warga Sekolah</p>
                                                        </div>

                                                        <div class="form-input mb-3">
                                                            <strong><label class="cd-label left-text">NISN</label></strong>
                                                            <input class="form-control" type="text" id="nisn-display"
                                                                readonly>
                                                        </div>

                                                        <div class="form-input mb-3">
                                                            <strong><label class="cd-label left-text">Nama
                                                                    Siswa</label></strong>
                                                            <input class="form-control" type="text" name="nama"
                                                                id="nama-siswa" readonly>
                                                        </div>

                                                        <div class="form-input mb-3">
                                                            <strong><label class="cd-label left-text">Nama Orang
                                                                    Tua</label></strong>
                                                            <input class="form-control" type="text" name="nama_orangtua"
                                                                id="nama-orangtua">
                                                        </div>

                                                        <div class="form-input mb-3">
                                                            <strong><label class="cd-label left-text">Email</label></strong>
                                                            <input class="form-control" type="email" name="email"
                                                                id="email" autocomplete="off" required>
                                                        </div>

                                                        <div class="form-input mb-3">
                                                            <strong><label class="cd-label text-left">Nomor
                                                                    Handphone</label></strong>
                                                            <input class="form-control" type="number" name="no_hp"
                                                                id="no_hp" autocomplete="off" required>
                                                        </div>

                                                        <div class="form-input mb-3">
                                                            <strong><label class="cd-label text-left">Judul Kritik dan
                                                                    Saran</label></strong>
                                                            <input class="form-control" type="text" name="judul_kendala"
                                                                id="judul_kendala" autocomplete="off" required>
                                                        </div>

                                                        <div class="input-input mb-3">
                                                            <strong><label class="cd-label text-left">Detail Kritik dan
                                                                    Saran</label></strong>
                                                            <textarea class="form-control" name="detail_kendala" id="detail_kendala" required></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <strong><label>Jenis Kritik dan Saran</label></strong>
                                                            <select class="form-control" name="kendala" required>
                                                                <option value="">Pilih</option>
                                                                <option
                                                                    value="BK - Layanan BK (Konseling Karir, Pemilihan Jurusan)">
                                                                    BK - Layanan BK (Konseling Karir, Pemilihan Jurusan)
                                                                </option>
                                                                <option value="Humas - PPDB">Humas - PPDB</option>
                                                                <option value="Humas - Promosi dan Marketing">Humas -
                                                                    Promosi dan Marketing</option>
                                                                <option
                                                                    value="Kepala Sekolah - Kedisiplinan Karakter Sikap, Karakter dan Perilaku Guru">
                                                                    Kepala Sekolah - Kedisiplinan Karakter Sikap, Karakter
                                                                    dan Perilaku Guru</option>
                                                                <option
                                                                    value="Kesiswaan - Kedisiplinan, Karakter, Sikap dan Perilaku">
                                                                    Kesiswaan - Kedisiplinan, Karakter, Sikap dan Perilaku
                                                                </option>
                                                                <option
                                                                    value="Kesiswaan - Kegiatan Ekstrakurikuler dan Club">
                                                                    Kesiswaan - Kegiatan Ekstrakurikuler dan Club</option>
                                                                <option value="Kesiswaan - Kegiatan Organisasi">Kesiswaan -
                                                                    Kegiatan Organisasi</option>
                                                                <option value="Kesiswaan - Layanan Kesehatan (UKS)">
                                                                    Kesiswaan - Layanan Kesehatan (UKS)</option>
                                                                <option value="Kesiswaan - Layanan Perpustakaan">Kesiswaan
                                                                    - Layanan Perpustakaan</option>
                                                                <option value="Koperasi - Antar Jemput">Koperasi - Antar
                                                                    Jemput</option>
                                                                <option value="Koperasi - Pembelian Seragam dan Buku">
                                                                    Koperasi - Pembelian Seragam dan Buku</option>
                                                                <option value="Kurikulum - Akademik">Kurikulum - Akademik
                                                                </option>
                                                                <option value="Kurikulum - Jadwal Belajar">Kurikulum -
                                                                    Jadwal Belajar</option>
                                                                <option
                                                                    value="Kurikulum - Kegiatan Belajar Mengajar (Mutu Pembelajaran)">
                                                                    Kurikulum - Kegiatan Belajar Mengajar (Mutu
                                                                    Pembelajaran)</option>
                                                                <option value="Kurikulum - Kurikulum">Kurikulum - Kurikulum
                                                                </option>
                                                                <option value="Kurikulum - Laboratorium">Kurikulum -
                                                                    Laboratorium</option>
                                                                <option
                                                                    value="Psikolog & BK - Motivasi, Kepercayaan Diri & Komunikasi">
                                                                    Psikolog & BK - Motivasi, Kepercayaan Diri & Komunikasi
                                                                </option>
                                                                <option
                                                                    value="Psikolog & BK - Perundungan, kekerasan dan pelecehan seksual">
                                                                    Psikolog & BK - Perundungan, kekerasan dan pelecehan
                                                                    seksual</option>
                                                                <option
                                                                    value="Psikolog - Layanan Psikologi (Tumbuh Kembang Anak & Parenting, Masalah Kepribadian, Permasalah psikologis, kesulitan belajar spesifik dan permasalahan psikologis lainnya)">
                                                                    Psikolog - Layanan Psikologi (Tumbuh Kembang Anak &
                                                                    Parenting, Masalah Kepribadian, Permasalah psikologis,
                                                                    kesulitan belajar spesifik dan permasalahan psikologis
                                                                    lainnya)</option>
                                                                <option value="Tata Usaha - Keuangan">Tata Usaha - Keuangan
                                                                </option>
                                                                <option
                                                                    value="Tata Usaha - Administrasi (Rapot, Ijazah dan sejenisnya)">
                                                                    Tata Usaha - Administrasi (Rapot, Ijazah dan sejenisnya)
                                                                </option>
                                                                <option value="Tata Usaha - Kebersihan">Tata Usaha -
                                                                    Kebersihan</option>
                                                                <option value="Tata Usaha - Keamanan">Tata Usaha - Keamanan
                                                                </option>
                                                                <option
                                                                    value="Tata Usaha - Pemeliharaan Gedung (Maintenance, Internet, Mekanikal, Elektrikal, dan Plumbing (Saluran Air))">
                                                                    Tata Usaha - Pemeliharaan Gedung (Maintenance, Internet,
                                                                    Mekanikal, Elektrikal, dan Plumbing (Saluran Air))
                                                                </option>
                                                                <option
                                                                    value="Tata Usaha - Sarana dan Prasarana (Fasilitas Umum & Fasilitas Ruangan)">
                                                                    Tata Usaha - Sarana dan Prasarana (Fasilitas Umum &
                                                                    Fasilitas Ruangan)</option>
                                                                <option
                                                                    value="Wali Kelas - Motivasi Belajar, Sikap Guru, Layanan Pembelajaran, Pengawasan Perkembangan Siswa, Kegiatan Kelas dan Pengelolaan Kelas">
                                                                    Wali Kelas - Motivasi Belajar, Sikap Guru, Layanan
                                                                    Pembelajaran, Pengawasan Perkembangan Siswa, Kegiatan
                                                                    Kelas dan Pengelolaan Kelas</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <strong><label>Lokasi</label></strong>
                                                            <select class="form-control" name="lokasi_kendala" required>
                                                                <option value="">Pilih</option>
                                                                <option value="KB Avicenna Pamulang">KB Avicenna Pamulang
                                                                </option>
                                                                <option value="TK Avicenna Jagakarsa">TK Avicenna Jagakarsa
                                                                </option>
                                                                <option value="SD Avicenna Jagakarsa">SD Avicenna Jagakarsa
                                                                </option>
                                                                <option value="SMP Avicenna Jagakarsa">SMP Avicenna
                                                                    Jagakarsa</option>
                                                                <option value="SMA Avicenna Jagakarsa">SMA Avicenna
                                                                    Jagakarsa</option>
                                                                <option value="SD Avicenna Cinere">SD Avicenna Cinere
                                                                </option>
                                                                <option value="SMP Avicenna Cinere">SMP Avicenna Cinere
                                                                </option>
                                                                <option value="SMA Avicenna Cinere">SMA Avicenna Cinere
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="input-input mb-3">
                                                            <strong><label class="">Lampiran Foto atau Screenshot
                                                                    (Jika ada)</label></strong>
                                                            <input name="choosefile" type="file" class="form-control"
                                                                accept="image/*" id="customFile" />
                                                        </div>

                                                        <div class="mt-3 text-center">
                                                            <button class="btn btn-success w-100" type="submit"
                                                                name="input" id="input">Kirim Kritik dan
                                                                Saran</button>
                                                            <button class="btn btn-secondary w-100 mt-2" type="button"
                                                                id="btn-back">Kembali ke Validasi</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Validasi NISN
            $('#btn-check-nisn').click(function() {
                var nisn = $('#nisn-check').val();

                if (!nisn) {
                    $('#nisn-error').text('NISN harus diisi').show();
                    return;
                }

                $.ajax({
                    url: '{{ route('home.get-siswa') }}',
                    method: 'POST',
                    data: {
                        nisn: nisn,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Tampilkan form
                            $('#step-nisn').hide();
                            $('#step-form').show();

                            // Isi data siswa
                            $('#nisn-hidden').val(nisn);
                            $('#nisn-display').val(nisn);
                            $('#nama-siswa').val(response.data.nama);
                            $('#nama-orangtua').val(response.data.nama_orangtua || '');

                            $('#nisn-error').hide();
                        } else {
                            $('#nisn-error').text(response.message).show();
                        }
                    },
                    error: function() {
                        $('#nisn-error').text('Terjadi kesalahan sistem').show();
                    }
                });
            });

            // Tombol kembali
            $('#btn-back').click(function() {
                $('#step-form').hide();
                $('#step-nisn').show();
                $('#nisn-check').val('');
                $('#nisn-error').hide();
            });

            // Enter key untuk validasi NISN
            $('#nisn-check').keypress(function(e) {
                if (e.which == 13) {
                    $('#btn-check-nisn').click();
                }
            });
        });
    </script>
@endpush
