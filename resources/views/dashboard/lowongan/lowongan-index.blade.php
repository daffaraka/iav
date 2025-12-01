@extends('dashboard.layout')

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $title }}</h4>
                        <a href="{{ route('lowongan-pekerjaan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Lowongan
                        </a>
                    </div>
                    <div class="card-body">
                        {{-- @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif --}}

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Lowongan</th>
                                        <th>Perusahaan</th>
                                        <th>Jumlah Pelamar</th>
                                        <th>Lokasi</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Tanggal Tutup</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lowongans as $lowongan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $lowongan->judul_lowongan }}</td>
                                            <td><b>{{ $lowongan->applies->count()}} </b> </td>
                                            <td>{{ $lowongan->perusahaan }}</td>
                                            <td>{{ $lowongan->lokasi }}</td>
                                            <td>{{ $lowongan->jenis_pekerjaan }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $lowongan->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                    {{ $lowongan->status }}
                                                </span>
                                            </td>
                                            <td>{{ $lowongan->tanggal_tutup->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('lowongan-pekerjaan.show', $lowongan) }}"
                                                    class="btn btn-info btn-sm">Detail</a>
                                                <a href="{{ route('lowongan-pekerjaan.edit', $lowongan) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('lowongan-pekerjaan.destroy', $lowongan) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin hapus?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data lowongan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $lowongans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
