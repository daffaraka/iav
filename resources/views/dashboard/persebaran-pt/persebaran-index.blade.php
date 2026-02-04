@extends('dashboard.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Persebaran PTN/PTS</h5>
                <a href="{{ route('persebaran-ptn.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Nama PT</th>
                                <th>Fakultas</th>
                                <th>Jurusan</th>
                                <th>Program Studi</th>
                                <th>Strata</th>
                                <th>Akreditasi</th>
                                <th>Jalur Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($persebarans as $persebaran)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $persebaran->siswa->nama }}</td>
                                    <td>{{ $persebaran->ptn->nama_pt }}</td>
                                    <td>{{ $persebaran->fakultas }}</td>
                                    <td>{{ $persebaran->jurusan }}</td>
                                    <td>{{ $persebaran->program_studi }}</td>
                                    <td>{{ $persebaran->starta }}</td>
                                    <td>{{ $persebaran->akreditasi }}</td>
                                    <td>{{ $persebaran->jalur_masuk }}</td>
                                    <td>
                                        <a href="{{ route('persebaran-ptn.edit', $persebaran->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('persebaran-ptn.destroy', $persebaran->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
