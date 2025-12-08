@extends('dashboard.layout')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Aduan</h1>
        <a href="{{ route('dashboard.aqr.aduan.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Aduan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No. Tiket</th>
                            <th>Nama</th>
                            <th>Judul Kendala</th>
                            <th>Status</th>
                            <th>Pengirim</th>
                            <th>Lokasi</th>
                            <th>Rating</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tikets as $tiket)
                            <tr>
                                <td>{{ $tiket->no_tiket }}</td>
                                <td>{{ $tiket->nama }}</td>
                                <td>{{ Str::limit($tiket->judul_kendala, 30) }}</td>
                                <td>
                                    <span class="badge badge-{{ $tiket->status == 'New' ? 'warning' : ($tiket->status == 'Proses' ? 'info' : 'success') }}">
                                        {{ $tiket->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $tiket->pengirim == 'Warga Sekolah' ? 'success' : 'primary' }}">
                                        {{ $tiket->pengirim }}
                                    </span>
                                </td>
                                <td>{{ $tiket->lokasi_sekolah ?? '-' }}</td>
                                <td>
                                    @if($tiket->rating)
                                        <div class="rating-display">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $tiket->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 0.8rem;"></i>
                                            @endfor
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $tiket->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('dashboard.aqr.aduan.show', $tiket->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('edit-aduan')
                                        <a href="{{ route('dashboard.aqr.aduan.edit', $tiket->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data aduan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $tikets->links() }}
        </div>
    </div>
</div>
@endsection