@extends('dashboard.layout')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Tiket #{{ $tiket->no_tiket }}</h1>
        <a href="{{ route('dashboard.aqr.aduan.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Tiket</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $tiket->nama }}</p>
                            <p><strong>No. HP:</strong> {{ $tiket->no_hp ?? '-' }}</p>
                            <p><strong>Email:</strong> {{ $tiket->email ?? '-' }}</p>
                            <p><strong>Pengirim:</strong> 
                                <span class="badge badge-{{ $tiket->pengirim == 'Warga Sekolah' ? 'success' : 'primary' }}">
                                    {{ $tiket->pengirim }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="badge badge-{{ $tiket->status == 'New' ? 'warning' : ($tiket->status == 'Proses' ? 'info' : 'success') }}">
                                    {{ $tiket->status }}
                                </span>
                            </p>
                            <p><strong>Lokasi Sekolah:</strong> {{ $tiket->lokasi_sekolah ?? '-' }}</p>
                            <p><strong>Lokasi Kendala:</strong> {{ $tiket->lokasi_kendala ?? '-' }}</p>
                            <p><strong>PIC:</strong> {{ $tiket->pic->name ?? 'Belum ditentukan' }}</p>
                        </div>
                    </div>
                    
                    <hr>
                    <h6><strong>Judul Kendala:</strong></h6>
                    <p>{{ $tiket->judul_kendala }}</p>
                    
                    <h6><strong>Detail Kendala:</strong></h6>
                    <p>{{ $tiket->detail_kendala }}</p>
                    
                    @if($tiket->filename)
                        <h6><strong>Lampiran:</strong></h6>
                        <a href="{{ asset('storage/' . $tiket->filename) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fas fa-paperclip"></i> Lihat Lampiran
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if($tiket->status == 'Selesai')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Penilaian</h6>
                    </div>
                    <div class="card-body">
                        @if($tiket->rating)
                            <div class="mb-3">
                                <strong>Rating:</strong>
                                <div class="rating-display">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $tiket->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="ml-2">({{ $tiket->rating }}/5)</span>
                                </div>
                            </div>
                            
                            @if($tiket->deskripsi_penilaian)
                                <div class="mb-3">
                                    <strong>Deskripsi:</strong>
                                    <p class="mt-2">{{ $tiket->deskripsi_penilaian }}</p>
                                </div>
                            @endif
                        @else
                            <form action="{{ route('dashboard.aqr.tiket.rating', $tiket->id) }}" method="POST">
                                @csrf
                                <div class="form-group my-2">
                                    <label><strong>Rating Bintang:</strong></label>
                                    <div class="rating-input">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                            <label for="star{{ $i }}" class="star-label">
                                                <i class="fas fa-star"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="form-group my-2">
                                    <label><strong>Deskripsi Penilaian:</strong></label>
                                    <textarea name="deskripsi_penilaian" class="form-control" rows="3" placeholder="Berikan penilaian Anda..."></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-star"></i> Berikan Rating
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating-input input[type="radio"] {
    display: none;
}

.rating-input .star-label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    margin-right: 5px;
}

.rating-input input[type="radio"]:checked ~ .star-label,
.rating-input .star-label:hover,
.rating-input .star-label:hover ~ .star-label {
    color: #ffc107;
}

.rating-display .fas.fa-star {
    font-size: 1.2rem;
    margin-right: 2px;
}
</style>
@endsection