@extends('dashboard.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title ?? 'Edit Featured Question' }}</h3>
                    </div>
                    <form action="{{ route('featured-question.update', $fq->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            @if ($fq->tiket_id)
                                <div class="alert alert-info d-flex align-items-center mb-4">
                                    <i class="bx bx-info-circle me-2 fs-5"></i>
                                    <span>Dipromosikan dari <strong>Tiket #{{ $fq->tiket_id }}</strong></span>
                                </div>
                            @endif

                            <div class="form-group mb-3">
                                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul', $fq->judul) }}" required
                                    placeholder="Masukkan judul pertanyaan">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="jawaban" class="form-label">Jawaban <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('jawaban') is-invalid @enderror" id="jawaban" name="jawaban" rows="6"
                                    required placeholder="Masukkan jawaban">{{ old('jawaban', $fq->jawaban) }}</textarea>
                                @error('jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                    name="kategori">
                                    <option value="">Pilih Kategori</option>
                                    @foreach (['Akademik', 'Keuangan', 'Fasilitas Sarpras', 'PPDB', 'SDM', 'IT', 'Lainnya'] as $kat)
                                        <option value="{{ $kat }}"
                                            {{ old('kategori', $fq->kategori) == $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_pinned" name="is_pinned"
                                            value="1" {{ old('is_pinned', $fq->is_pinned) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_pinned">Pinned (Disematkan)</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published"
                                            value="1" {{ old('is_published', $fq->is_published) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_published">Published (Dipublikasikan)</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="order" class="form-label">Urutan</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                        id="order" name="order" value="{{ old('order', $fq->order) }}" min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Update
                            </button>
                            <a href="{{ route('featured-question.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
