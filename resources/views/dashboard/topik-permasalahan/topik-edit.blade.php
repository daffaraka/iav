@extends('dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Topik Permasalahan</h3>
                </div>
                <form action="{{ route('topik-permasalahan.update', $topikPermasalahan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="nama_topik">Nama Topik</label>
                            <input type="text" name="nama_topik"
                                class="form-control @error('nama_topik') is-invalid @enderror"
                                value="{{ old('nama_topik', $topikPermasalahan->nama_topik) }}" required>
                            @error('nama_topik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="aqr_option_id">AQR Option</label>
                            <select name="aqr_option_id"
                                class="form-control @error('aqr_option_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Option --</option>
                                @foreach ($options as $opt)
                                    <option value="{{ $opt->id }}"
                                        {{ old('aqr_option_id', $topikPermasalahan->aqr_option_id) == $opt->id ? 'selected' : '' }}>
                                        {{ $opt->nama_option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('aqr_option_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tiket_id">Tiket</label>
                            <select name="tiket_id"
                                class="form-control @error('tiket_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Tiket --</option>
                                @foreach ($tikets as $tiket)
                                    <option value="{{ $tiket->id }}"
                                        {{ old('tiket_id', $topikPermasalahan->tiket_id) == $tiket->id ? 'selected' : '' }}>
                                        {{ $tiket->no_tiket }} - {{ $tiket->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tiket_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('topik-permasalahan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
