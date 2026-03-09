@extends('dashboard.layout')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Tiket</h6>
                @if(!$tiket->ai_analyzed_at)
                <form method="POST" action="{{ route('dashboard.aqr.analytics.analyze', $tiket->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">🤖 Analisis dengan AI</button>
                </form>
                @else
                <span class="badge badge-success">✅ Sudah Dianalisis AI</span>
                @endif
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="">
                            <div class="h1 text-gray-800">
                                <h3 class="mx-2 my-4"> No Tiket : {{ $tiket->no_tiket }} </h3>
                            </div>
                            <div class="container">
                                <div class="form-input mb-3">
                                    <strong><label class="cd-label left-text">Nama</label></strong>
                                    <input class="form-control" type="text" name="nama" id="nama"
                                        value="{{ $tiket->nama }}" readonly>
                                </div>

                                <div class="form-input mb-3">
                                    <strong><label class="cd-label left-text">Email</label></strong>
                                    <input class="form-control" type="email" name="email" id="email"
                                        value="{{ $tiket->email }}" readonly>
                                </div>

                                <div class="form-input mb-3">
                                    <strong><label class="cd-label text-left">Nomor
                                            Handphone</label></strong>
                                    <input class="form-control" type="text" name="no_hp" id="no_hp"
                                        value="{{ $tiket->no_hp }}" readonly>
                                </div>

                                {{-- <div class="form-input mb-3">
                                <strong><label class="cd-label left-text">Kendala</label></strong>
                                <input class="form-control" type="text" name="kendala" id="kendala"
                                    value="{{ $tiket->problem }}" readonly>
                            </div> --}}

                                <div class="form-input mb-3">
                                    <strong><label class="cd-label left-text">Lokasi
                                            Kendala</label></strong>
                                    <input class="form-control" type="text" name="lokasi_kendala" id="lokasi_kendala"
                                        value="{{ $tiket->lokasi_kendala }}" readonly>
                                </div>

                                <div class="input-input mb-3">
                                    <strong><label class="cd-label text-left">Detail
                                            kendala</label></strong>
                                    <textarea class="form-control" name="detail_kendala" id="detail_kendala" readonly>{{ $tiket->detail_kendala }}</textarea>
                                </div>

                                <div class="input-input mb-3">
                                    <strong><label class="">Foto atau Screenshot
                                            masalah</label></strong> <br>
                                    <a href="{{ asset($tiket->filename) }}" class="btn btn-primary" target="_blank">View</a>
                                </div>

                                @if($tiket->ai_analyzed_at)
                                <hr>
                                <h5 class="text-primary">🤖 Hasil Analisis AI</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-input mb-3">
                                            <strong><label>Kategori</label></strong>
                                            <input class="form-control" value="{{ $tiket->ai_kategori }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input mb-3">
                                            <strong><label>Sub Kategori</label></strong>
                                            <input class="form-control" value="{{ $tiket->ai_sub_kategori }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input mb-3">
                                            <strong><label>Prioritas</label></strong>
                                            <input class="form-control" value="{{ $tiket->ai_prioritas }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input mb-3">
                                            <strong><label>Sentiment</label></strong>
                                            <input class="form-control" value="{{ $tiket->ai_sentiment }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-input mb-3">
                                            <strong><label>Ringkasan AI</label></strong>
                                            <textarea class="form-control" readonly>{{ $tiket->ai_ringkasan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
