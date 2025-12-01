@extends('dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>{{ $lowonganPekerjaan->judul_lowongan }}</h3>
                            <h5 class="text-muted">{{ $lowonganPekerjaan->perusahaan }}</h5>
                            
                            <div class="mt-3">
                                <span class="badge badge-info">{{ $lowonganPekerjaan->jenis_pekerjaan }}</span>
                                <span class="badge badge-{{ $lowonganPekerjaan->status == 'Aktif' ? 'success' : 'secondary' }}">{{ $lowonganPekerjaan->status }}</span>
                            </div>

                            <div class="mt-4">
                                <h6><strong>Deskripsi Pekerjaan:</strong></h6>
                                <p>{{ $lowonganPekerjaan->deskripsi }}</p>
                            </div>

                            <div class="mt-3">
                                <h6><strong>Persyaratan:</strong></h6>
                                <p>{{ $lowonganPekerjaan->persyaratan }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6><strong>Informasi Lowongan</strong></h6>
                                    <hr>
                                    <p><strong>Lokasi:</strong><br>{{ $lowonganPekerjaan->lokasi }}</p>
                                    
                                    @if($lowonganPekerjaan->gaji_min || $lowonganPekerjaan->gaji_max)
                                    <p><strong>Gaji:</strong><br>
                                        @if($lowonganPekerjaan->gaji_min && $lowonganPekerjaan->gaji_max)
                                            {{ $lowonganPekerjaan->gaji_min }} - {{ $lowonganPekerjaan->gaji_max }}
                                        @elseif($lowonganPekerjaan->gaji_min)
                                            Mulai dari {{ $lowonganPekerjaan->gaji_min }}
                                        @else
                                            Hingga {{ $lowonganPekerjaan->gaji_max }}
                                        @endif
                                    </p>
                                    @endif
                                    
                                    <p><strong>Batas Lamaran:</strong><br>{{ $lowonganPekerjaan->tanggal_tutup->format('d F Y') }}</p>
                                    
                                    <hr>
                                    <h6><strong>Kontak</strong></h6>
                                    <p><strong>Email:</strong><br>{{ $lowonganPekerjaan->kontak_email }}</p>
                                    @if($lowonganPekerjaan->kontak_phone)
                                    <p><strong>Phone:</strong><br>{{ $lowonganPekerjaan->kontak_phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('lowongan-pekerjaan.edit', $lowonganPekerjaan) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('lowongan-pekerjaan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>

                    <!-- Tabel Pelamar -->
                    <div class="mt-5">
                        <h5>Daftar Pelamar</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelamar</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Tanggal Apply</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lowonganPekerjaan->applies as $apply)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $apply->nama_pelamar }}</td>
                                        <td>{{ $apply->email_pelamar }}</td>
                                        <td>{{ $apply->phone_pelamar }}</td>
                                        <td>
                                            <span class="badge badge-{{ $apply->status == 'Diterima' ? 'success' : ($apply->status == 'Ditolak' ? 'danger' : 'warning') }}">
                                                {{ $apply->status }}
                                            </span>
                                        </td>
                                        <td>{{ $apply->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('lowongan-apply.show', $apply) }}" class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada pelamar</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection