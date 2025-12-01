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
                    <form action="{{ route('lowongan-pekerjaan.update', $lowonganPekerjaan) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Judul Lowongan</label>
                                    <input type="text" name="judul_lowongan" class="form-control @error('judul_lowongan') is-invalid @enderror" value="{{ old('judul_lowongan', $lowonganPekerjaan->judul_lowongan) }}">
                                    @error('judul_lowongan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Perusahaan</label>
                                    <input type="text" name="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror" value="{{ old('perusahaan', $lowonganPekerjaan->perusahaan) }}">
                                    @error('perusahaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi', $lowonganPekerjaan->lokasi) }}">
                                    @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Jenis Pekerjaan</label>
                                    <select name="jenis_pekerjaan" class="form-control @error('jenis_pekerjaan') is-invalid @enderror">
                                        <option value="">Pilih Jenis</option>
                                        <option value="Full Time" {{ old('jenis_pekerjaan', $lowonganPekerjaan->jenis_pekerjaan) == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="Part Time" {{ old('jenis_pekerjaan', $lowonganPekerjaan->jenis_pekerjaan) == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                        <option value="Kontrak" {{ old('jenis_pekerjaan', $lowonganPekerjaan->jenis_pekerjaan) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                        <option value="Magang" {{ old('jenis_pekerjaan', $lowonganPekerjaan->jenis_pekerjaan) == 'Magang' ? 'selected' : '' }}>Magang</option>
                                    </select>
                                    @error('jenis_pekerjaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Gaji Min</label>
                                    <input type="text" name="gaji_min" class="form-control" value="{{ old('gaji_min', $lowonganPekerjaan->gaji_min) }}" placeholder="Opsional">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Gaji Max</label>
                                    <input type="text" name="gaji_max" class="form-control" value="{{ old('gaji_max', $lowonganPekerjaan->gaji_max) }}" placeholder="Opsional">
                                </div>
                            </div>
                        </div>

                        <div class="form-group my-2">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi', $lowonganPekerjaan->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group my-2">
                            <label>Persyaratan</label>
                            <textarea name="persyaratan" class="form-control @error('persyaratan') is-invalid @enderror" rows="4">{{ old('persyaratan', $lowonganPekerjaan->persyaratan) }}</textarea>
                            @error('persyaratan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Tanggal Tutup</label>
                                    <input type="date" name="tanggal_tutup" class="form-control @error('tanggal_tutup') is-invalid @enderror" value="{{ old('tanggal_tutup', $lowonganPekerjaan->tanggal_tutup->format('Y-m-d')) }}">
                                    @error('tanggal_tutup')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Email Kontak</label>
                                    <input type="email" name="kontak_email" class="form-control @error('kontak_email') is-invalid @enderror" value="{{ old('kontak_email', $lowonganPekerjaan->kontak_email) }}">
                                    @error('kontak_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label>Phone Kontak</label>
                                    <input type="text" name="kontak_phone" class="form-control" value="{{ old('kontak_phone', $lowonganPekerjaan->kontak_phone) }}" placeholder="Opsional">
                                </div>
                            </div>
                        </div>

                        <div class="form-group my-2">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Aktif" {{ old('status', $lowonganPekerjaan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Draft" {{ old('status', $lowonganPekerjaan->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Tutup" {{ old('status', $lowonganPekerjaan->status) == 'Tutup' ? 'selected' : '' }}>Tutup</option>
                            </select>
                        </div>

                        <div class="form-group my-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('lowongan-pekerjaan.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection