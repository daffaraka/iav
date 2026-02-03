@extends('dashboard.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Data Prestasi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('data-prestasi.update', $prestasi->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="master_siswa_id" class="form-control" id="select_siswa" required>
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswa as $s)
                                <option value="{{ $s->id }}"
                                    {{ $prestasi->master_siswa_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama }} - {{ $s->sekolah->unit }} ({{ $s->sekolah->jenjang }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lomba</label>
                        <input type="text" name="nama_lomba" class="form-control" value="{{ $prestasi->nama_lomba }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tingkat Lomba</label>
                        <select name="tingkat_lomba" class="form-control" required>
                            <option value="Sekolah" {{ $prestasi->tingkat_lomba == 'Sekolah' ? 'selected' : '' }}>Sekolah
                            </option>
                            <option value="Kecamatan" {{ $prestasi->tingkat_lomba == 'Kecamatan' ? 'selected' : '' }}>
                                Kecamatan</option>
                            <option value="Kota" {{ $prestasi->tingkat_lomba == 'Kota' ? 'selected' : '' }}>Kota</option>
                            <option value="Provinsi" {{ $prestasi->tingkat_lomba == 'Provinsi' ? 'selected' : '' }}>
                                Provinsi</option>
                            <option value="Nasional" {{ $prestasi->tingkat_lomba == 'Nasional' ? 'selected' : '' }}>
                                Nasional</option>
                            <option value="Internasional"
                                {{ $prestasi->tingkat_lomba == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Lomba</label>
                        <select name="status_lomba" class="form-control" required>
                            <option value="Terkurasi" {{ $prestasi->status_lomba == 'Terkurasi' ? 'selected' : '' }}>
                                Terkurasi</option>
                            <option value="Tidak Terkurasi"
                                {{ $prestasi->status_lomba == 'Tidak Terkurasi' ? 'selected' : '' }}>Tidak Terkurasi
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Pelajaran</label>
                        <input type="text" name="tahun_pelajaran" class="form-control"
                            value="{{ $prestasi->tahun_pelajaran }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ $prestasi->lokasi }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelaksanaan" class="form-control"
                            value="{{ $prestasi->tanggal_pelaksanaan }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ $prestasi->keterangan }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
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
