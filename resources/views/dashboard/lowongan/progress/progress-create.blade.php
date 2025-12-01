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
                    <form action="{{ route('lowongan-progress.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Pelamar</label>
                                    <select name="lowongan_apply_id" class="form-control @error('lowongan_apply_id') is-invalid @enderror">
                                        <option value="">Pilih Pelamar</option>
                                        @foreach($applies as $apply)
                                        <option value="{{ $apply->id }}" {{ old('lowongan_apply_id') == $apply->id ? 'selected' : '' }}>
                                            {{ $apply->nama_pelamar }} - {{ $apply->lowonganPekerjaan->judul_lowongan }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('lowongan_apply_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="">Pilih Status</option>
                                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Review" {{ old('status') == 'Review' ? 'selected' : '' }}>Review</option>
                                        <option value="Interview" {{ old('status') == 'Interview' ? 'selected' : '' }}>Interview</option>
                                        <option value="Diterima" {{ old('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group my-2">
                            <label>Tanggal Progress</label>
                            <input type="date" name="tanggal_progress" class="form-control @error('tanggal_progress') is-invalid @enderror" value="{{ old('tanggal_progress', date('Y-m-d')) }}">
                            @error('tanggal_progress')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group my-2">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="4" placeholder="Opsional">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="form-group my-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('lowongan-progress.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection