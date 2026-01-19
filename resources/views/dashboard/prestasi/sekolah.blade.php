@extends('dashboard.layout')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Data Prestasi Sekolah {{ $sekolah }}</h5>

            <div class="d-flex justify-content-end">
                        <a href="{{ route('data-prestasi.create') }}" class="btn btn-lg btn-primary">  Tambah Data</a>

            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="prestasiTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Jenjang</th>
                            <th>Nama Lomba</th>
                            <th>Tingkat</th>
                            <th>Status</th>
                            <th>Tahun</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestasi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->siswa->nama ?? '-' }}</td>
                            <td>{{ $item->siswa->sekolah->jenjang ?? '-' }}</td>
                            <td>{{ $item->nama_lomba }}</td>
                            <td>{{ $item->tingkat_lomba }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status_lomba == 'Terkurasi' ? 'success' : 'warning' }}">
                                    {{ $item->status_lomba }}
                                </span>
                            </td>
                            <td>{{ $item->tahun_pelajaran }}</td>
                            <td>{{ $item->lokasi }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#prestasiTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });
});
</script>
@endpush
