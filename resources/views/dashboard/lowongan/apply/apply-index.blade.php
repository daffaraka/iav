@extends('dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ $title }}</h4>
                    <a href="{{ route('lowongan-apply.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Tambah Pelamar
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
                                    <th>Nama Pelamar</th>
                                    <th>Email</th>
                                    <th>Lowongan</th>
                                    <th>Status</th>
                                    <th>Tanggal Apply</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applies as $apply)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $apply->nama_pelamar }}</td>
                                    <td>{{ $apply->email_pelamar }}</td>
                                    <td>{{ $apply->lowonganPekerjaan->judul_lowongan }}</td>
                                    <td>
                                        <span class="badge badge-{{ $apply->status == 'Diterima' ? 'success' : ($apply->status == 'Ditolak' ? 'danger' : 'warning') }}">
                                            {{ $apply->status }}
                                        </span>
                                    </td>
                                    <td>{{ $apply->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('lowongan-apply.show', $apply) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('lowongan-apply.edit', $apply) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('lowongan-apply.destroy', $apply) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pelamar</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $applies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection