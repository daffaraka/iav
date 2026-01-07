@extends('dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah AQR Option</h3>
                </div>
                <form action="{{ route('aqr-option.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_option">Nama Option</label>
                            <input type="text" class="form-control @error('nama_option') is-invalid @enderror"
                                   id="nama_option" name="nama_option" value="{{ old('nama_option') }}" required>
                            @error('nama_option')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategori_pic">Kategori PIC</label>
                            <select class="form-control @error('kategori_pic') is-invalid @enderror"
                                    id="kategori_pic" name="kategori_pic" required>
                                <option value="">Pilih Kategori PIC</option>
                                <option value="Kepala Sekolah" {{ old('kategori_pic') == 'Kepala Sekolah' ? 'selected' : '' }}>
                                    Kepala Sekolah
                                </option>
                                <option value="Kepala TU" {{ old('kategori_pic') == 'Kepala TU' ? 'selected' : '' }}>
                                    Kepala TU
                                </option>
                            </select>
                            @error('kategori_pic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('aqr-option.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
