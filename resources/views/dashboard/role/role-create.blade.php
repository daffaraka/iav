@extends('dashboard.layout')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Tambah Role</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Role</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: admin, guru" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label d-block mb-2">Pilih Permissions (Hak Akses)</label>
                    <div class="row">
                        @forelse($permissions as $permission)
                            <div class="col-md-4 col-sm-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->name }}" id="perm-{{ $permission->id }}">
                                    <label class="form-check-label" for="perm-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-muted">Belum ada permission terdaftar.</div>
                        @endforelse
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                    <a href="{{ route('role.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection