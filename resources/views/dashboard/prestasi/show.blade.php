@extends('dashboard.layout')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Detail Data Prestasi</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nama Siswa</th>
                    <td>{{ $prestasi->siswa->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Sekolah</th>
                    <td>{{ $prestasi->siswa->sekolah->unit ?? '-' }} - {{ $prestasi->siswa->sekolah->jenjang ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nama Lomba</th>
                    <td>{{ $prestasi->nama_lomba }}</td>
                </tr>
                <tr>
                    <th>Tingkat Lomba</th>
                    <td>{{ $prestasi->tingkat_lomba }}</td>
                </tr>
                <tr>
                    <th>Status Lomba</th>
                    <td>
                        <span class="badge bg-{{ $prestasi->status_lomba == 'Terkurasi' ? 'success' : 'warning' }}">
                            {{ $prestasi->status_lomba }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tahun Pelajaran</th>
                    <td>{{ $prestasi->tahun_pelajaran ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>{{ $prestasi->lokasi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pelaksanaan</th>
                    <td>{{ $prestasi->tanggal_pelaksanaan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $prestasi->keterangan ?? '-' }}</td>
                </tr>
            </table>
            <a href="{{ route('data-prestasi.index') }}" class="btn btn-secondary mt-4">Kembali</a>
        </div>
    </div>
</div>
@endsection
