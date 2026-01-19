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
                    <select name="master_siswa_id" class="form-control" required>
                        <option value="">Pilih Siswa</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }} - {{ $s->sekolah->unit }} ({{ $s->sekolah->jenjang }})</option>
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
