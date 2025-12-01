@extends('dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ $title }}</h4>
                    <a href="{{ route('lowongan-progress.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Tambah Progress
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pelamar</th>
                                    <th>Lowongan</th>
                                    <th>Status</th>
                                    <th>Tanggal Progress</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($progress as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->lowonganApply->nama_pelamar }}</td>
                                    <td>{{ $item->lowonganApply->lowonganPekerjaan->judul_lowongan }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->status == 'Diterima' ? 'success' : ($item->status == 'Ditolak' ? 'danger' : 'warning') }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td>{{ $item->tanggal_progress->format('d/m/Y') }}</td>
                                    <td>{{ Str::limit($item->keterangan, 50) }}</td>
                                    <td>
                                        <a href="{{ route('lowongan-progress.show', $item) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('lowongan-progress.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('lowongan-progress.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data progress</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $progress->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection