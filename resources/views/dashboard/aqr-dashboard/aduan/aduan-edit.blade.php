@extends('dashboard.layout')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Tiket</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('tiket.update', $tiket->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="container-fluid">

                    <div class="">
                        <div class="card shadow border-1">
                            <div class="card-body">
                                <div class="h1 text-gray-800">
                                    <h3 class="mx-2 my-4"> ID Tiket {{ $tiket->id }} </h3>
                                </div>
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

                                <div class="input-input mb-3">
                                    <strong><label class="cd-label text-left">Judul Aduan</label></strong>
                                    <textarea class="form-control" name="judul_kendala" id="judul_kendala" readonly>{{ $tiket->judul_kendala }}</textarea>
                                </div>
                                <div class="form-input mb-3">
                                    <strong><label class="cd-label left-text">Lokasi
                                            Kendala</label></strong>
                                    <input class="form-control" type="text" name="lokasi_kendala" id="lokasi_kendala"
                                        value="{{ $tiket->lokasi_kendala }}" readonly>
                                </div>

                                <div class="input-input mb-3">
                                    <strong><label class="cd-label text-left">Detail
                                            Aduan</label></strong>
                                    <textarea class="form-control" name="detail_kendala" id="detail_kendala" readonly>{{ $tiket->detail_kendala }}</textarea>
                                </div>

                                <div class="input-input mb-3">
                                    <strong><label class="">Foto atau Screenshot
                                            masalah</label></strong>
                                    <a href="{{ asset($tiket->filename) }}" class="btn btn-dark" target="_blank">View</a>
                                </div>


                            </div>
                        </div>





                        <hr style="height:3px;border-width:0;color:gray;background-color:gray">

                        <div class="card shadow">
                            <div class="card-body">
                                <h3 class="mt-3 mb-4 font-weight-bold text-dark">Pilih PIC Yang Menanggapi</h3>
                                @if ($tiket->pic_id == null)
                                    <input type="hidden" name="menanggapi" value="menanggapi">
                                    <div class="humas mb-5">
                                        <div class="form-group mb-3">
                                            <label for="Status">Pilih PIC Yang Menanganani</label>
                                            <select class="form-control mb-3" name="pic_menanggapi" id="pic_menanggapi"
                                                required>
                                                @foreach ($picSelect as $select)
                                                    <option value="{{ $select->id }}"> <span
                                                            class="text-danger">{{ $select->departemen ?? '-' }} </span>
                                                        - {{ $select->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif


                                @if ($tiket->pic_id != null)
                                    <div class="mb-3">
                                        <label for="">Pic Menanggapi</label>
                                        <input type="text" name="" id="" value="{{ $tiket->pic->name }}"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Deskripsi">Deskripsi Penanganan</label>
                                        <textarea class="form-control mb-3" id="penanganan" name="penanganan" class="materialize-textarea validate"
                                            length="120"> {{ $tiket->penanganan }}</textarea>
                                    </div>

                                    <div>
                                        <label for="fotoperbaikan">Tambah Foto Perbaikan</label>

                                    </div>
                                    <input id="new_fotoperbaikan" class="form-control" type="file" name="choosefile" />
                                    <input id="input_fotoperbaikan" type="hidden" name="choosefile_check">
                                @elseif ($tiket->status == 'Selesai')
                                @endif
                            </div>
                        </div>


                    </div>
                </div>


                <button class="btn btn-primary m-4">Update Tiket</button>
            </form>


        </div>
    </div>
@endsection
