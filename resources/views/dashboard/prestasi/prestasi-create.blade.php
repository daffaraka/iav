@extends('dashboard.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Data Prestasi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('data-prestasi.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="master_siswa_id" id="select_siswa" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }} - {{ $s->sekolah->unit }}
                                    ({{ $s->sekolah->jenjang }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lomba</label>
                        <input type="text" name="nama_lomba" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tingkat Lomba</label>
                        <select name="tingkat_lomba" class="form-control" required>
                            <option value="Sekolah">Sekolah</option>
                            <option value="Kecamatan">Kecamatan</option>
                            <option value="Kota">Kota</option>
                            <option value="Provinsi">Provinsi</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Lomba</label>
                        <select name="status_lomba" class="form-control" required>
                            <option value="Terkurasi">Terkurasi</option>
                            <option value="Tidak Terkurasi">Tidak Terkurasi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Pelajaran</label>
                        <input type="text" name="tahun_pelajaran" class="form-control" placeholder="2023/2024">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelaksanaan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('data-prestasi.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $('#select_siswa').select2({
            allowClear: true,
            width: '100%',
        });


        $('.select2-container--default .select2-selection--single').css({
            'height': '48px',
            'border': '1px solid #d1d5db',
            'border-radius': '12px',
            'padding': '12px 16px',
            'font-size': '14px'
        });

        $('.select2-container--default .select2-selection--single .select2-selection__rendered').css({
            'line-height': '24px',
            'padding-left': '0'
        });

        $('.select2-container--default .select2-selection--single .select2-selection__arrow').css({
            'height': '46px'
        });

        // Focus styling
        $('#kendala-select').on('select2:open', function() {
            $('.select2-container--default .select2-selection--single').css({
                'border-color': '#10b981',
                'box-shadow': '0 0 0 2px rgba(16, 185, 129, 0.2)'
            });
        });

        $('#kendala-select').on('select2:close', function() {
            $('.select2-container--default .select2-selection--single').css({
                'border-color': '#d1d5db',
                'box-shadow': 'none'
            });
        });

        // Custom CSS for larger dropdown
        $('<style>').prop('type', 'text/css').html(`
                    .select2-results {
                        max-height: 500px !important;
                    }
                    .select2-results__option {
                        padding: 12px 16px !important;
                        font-size: 14px !important;
                        line-height: 1.4 !important;
                    }
                `).appendTo('head');
    </script>
@endpush
