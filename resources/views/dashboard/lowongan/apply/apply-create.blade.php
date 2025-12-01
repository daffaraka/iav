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
                    <form action="{{ route('lowongan-apply.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Lowongan Pekerjaan</label>
                                    <select name="lowongan_pekerjaan_id" class="form-control @error('lowongan_pekerjaan_id') is-invalid @enderror">
                                        <option value="">Pilih Lowongan</option>
                                        @foreach($lowongans as $lowongan)
                                        <option value="{{ $lowongan->id }}" {{ old('lowongan_pekerjaan_id') == $lowongan->id ? 'selected' : '' }}>
                                            {{ $lowongan->judul_lowongan }} - {{ $lowongan->perusahaan }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('lowongan_pekerjaan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Nama Pelamar</label>
                                    <input type="text" name="nama_pelamar" class="form-control @error('nama_pelamar') is-invalid @enderror" value="{{ old('nama_pelamar') }}">
                                    @error('nama_pelamar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Email</label>
                                    <input type="email" name="email_pelamar" class="form-control @error('email_pelamar') is-invalid @enderror" value="{{ old('email_pelamar') }}">
                                    @error('email_pelamar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Phone</label>
                                    <input type="text" name="phone_pelamar" class="form-control @error('phone_pelamar') is-invalid @enderror" value="{{ old('phone_pelamar') }}">
                                    @error('phone_pelamar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group my-2">
                            <label>Alamat</label>
                            <textarea name="alamat_pelamar" class="form-control @error('alamat_pelamar') is-invalid @enderror" rows="3">{{ old('alamat_pelamar') }}</textarea>
                            @error('alamat_pelamar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>CV File</label>
                                    <input type="file" name="cv_file" class="form-control @error('cv_file') is-invalid @enderror" accept=".pdf,.doc,.docx">
                                    @error('cv_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="text-muted">Format: PDF, DOC, DOCX (Max: 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group my-2">
                            <label>Cover Letter</label>
                            <textarea name="cover_letter" class="form-control" rows="4" placeholder="Opsional">{{ old('cover_letter') }}</textarea>
                        </div>

                        <div class="form-group my-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('lowongan-apply.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection