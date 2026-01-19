@extends('dashboard.layout')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- 3 Cards Latest Prestasi -->
    <div class="row mb-4">
        <!-- Jagakarsa -->
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Sekolah Jagakarsa</h5>
                    <small class="text-muted">5 Prestasi Terbaru</small>
                </div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    @forelse($jagakarsa as $item)
                    <div class="p-3 border-bottom">
                        <small class="text-muted d-block">{{ $item->siswa->nama ?? '-' }}</small>
                        <h6 class="mb-1">{{ $item->nama_lomba }}</h6>
                        <span class="badge bg-{{ $item->status_lomba == 'Terkurasi' ? 'success' : 'warning' }}">
                            {{ $item->status_lomba }}
                        </span>
                        <small class="text-muted d-block mt-1">{{ $item->tingkat_lomba }}</small>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-muted">Tidak ada data</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Cinere -->
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Sekolah Cinere</h5>
                    <small class="text-muted">5 Prestasi Terbaru</small>
                </div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    @forelse($cinere as $item)
                    <div class="p-3 border-bottom">
                        <small class="text-muted d-block">{{ $item->siswa->nama ?? '-' }}</small>
                        <h6 class="mb-1">{{ $item->nama_lomba }}</h6>
                        <span class="badge bg-{{ $item->status_lomba == 'Terkurasi' ? 'success' : 'warning' }}">
                            {{ $item->status_lomba }}
                        </span>
                        <small class="text-muted d-block mt-1">{{ $item->tingkat_lomba }}</small>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-muted">Tidak ada data</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pamulang -->
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Sekolah Pamulang</h5>
                    <small class="text-muted">5 Prestasi Terbaru</small>
                </div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    @forelse($pamulang as $item)
                    <div class="p-3 border-bottom">
                        <small class="text-muted d-block">{{ $item->siswa->nama ?? '-' }}</small>
                        <h6 class="mb-1">{{ $item->nama_lomba }}</h6>
                        <span class="badge bg-{{ $item->status_lomba == 'Terkurasi' ? 'success' : 'warning' }}">
                            {{ $item->status_lomba }}
                        </span>
                        <small class="text-muted d-block mt-1">{{ $item->tingkat_lomba }}</small>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-muted">Tidak ada data</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable All Prestasi -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Semua Data Prestasi</h5>
            <a href="{{ route('data-prestasi.create') }}" class="btn btn-lg btn-primary">  Tambah Data</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="prestasiTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Sekolah</th>
                            <th>Nama Lomba</th>
                            <th>Tingkat</th>
                            <th>Status</th>
                            <th>Tahun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allPrestasi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->siswa->nama ?? '-' }}</td>
                            <td>{{ $item->siswa->sekolah->unit ?? '-' }}</td>
                            <td>{{ $item->nama_lomba }}</td>
                            <td>{{ $item->tingkat_lomba }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status_lomba == 'Terkurasi' ? 'success' : 'warning' }}">
                                    {{ $item->status_lomba }}
                                </span>
                            </td>
                            <td>{{ $item->tahun_pelajaran }}</td>
                            <td>
                                <a href="{{ route('data-prestasi.show', $item->id) }}" class="btn btn-sm btn-info me-1">Lihat</a>
                                <a href="{{ route('data-prestasi.edit', $item->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                <form action="{{ route('data-prestasi.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
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
