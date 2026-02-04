@extends('dashboard.layout')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Master PTN/PTS</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('master-ptn.update', $MasterPt->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama PT</label>
                    <input type="text" name="nama_pt" class="form-control" value="{{ $MasterPt->nama_pt }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status PT</label>
                    <select name="status_pt" class="form-control" required>
                        <option value="Negeri" {{ $MasterPt->status_pt == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                        <option value="Swasta" {{ $MasterPt->status_pt == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ $MasterPt->lokasi }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" value="{{ $MasterPt->provinsi }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Kota</label>
                    <input type="text" name="kota" class="form-control" value="{{ $MasterPt->kota }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('master-ptn.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
