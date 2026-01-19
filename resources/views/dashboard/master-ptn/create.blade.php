@extends('dashboard.layout')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Master PTN/PTS</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('master-ptn.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama PT</label>
                    <input type="text" name="nama_pt" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status PT</label>
                    <select name="status_pt" class="form-control" required>
                        <option value="Negeri">Negeri</option>
                        <option value="Swasta">Swasta</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Kota</label>
                    <input type="text" name="kota" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('master-ptn.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
