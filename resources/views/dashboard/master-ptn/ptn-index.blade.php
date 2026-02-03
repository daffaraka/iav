@extends('dashboard.layout')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Master PTN/PTS</h5>
            <a href="{{ route('master-ptn.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama PT</th>
                            <th>Status</th>
                            <th>Lokasi</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ptns as $ptn)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $ptn->nama_pt }}</td>
                            <td>{{ $ptn->status_pt }}</td>
                            <td>{{ $ptn->lokasi }}</td>
                            <td>{{ $ptn->provinsi }}</td>
                            <td>{{ $ptn->kota }}</td>
                            <td>
                                <a href="{{ route('master-ptn.edit', $ptn->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('master-ptn.destroy', $ptn->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $ptns->links() }}
        </div>
    </div>
</div>
@endsection
