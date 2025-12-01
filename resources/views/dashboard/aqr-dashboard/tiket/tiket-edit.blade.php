@extends('dashboard.layout')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Tiket</h6>
        </div>
        <div class="card-body">

            <div class="container-fluid">

                <div class="">
                    <div class="card shadow border-1">
                        <div class="card-body">
                            <div class="h1 text-gray-800">
                                <h3 class="mx-2 my-4"> No Tiket : {{ $tiket->no_tiket }} </h3>
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
                                        Aduan</label></strong>
                                <textarea class="form-control" name="detail_kendala" id="detail_kendala" readonly>{{ $tiket->detail_kendala }}</textarea>
                            </div>

                            <div class="input-input mb-3">
                                <strong><label class="">Foto atau Screenshot
                                        masalah</label></strong>
                                <div class="">
                                    <a href="{{ asset($tiket->filename) }}" class="btn btn-dark" target="_blank">View</a>

                                </div>
                            </div>


                        </div>
                    </div>



                    <hr style="height:3px;border-width:0;color:gray;background-color:gray">

                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-bold">Riwayat Tanggapan</h5>
                                    <hr>

                                    {{-- <h6>Status Tiket : {{ $tiket->status }}</h6> --}}


                                    @if ($tiket->progres->count() == 0)
                                        <h6 class="font-weight-bold">PIC Belum menanggapi</h6>
                                    @else
                                        @foreach ($tiket->progres as $index => $progres)
                                            <div class="card mb-2">
                                                <div class="card-body">


                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="card-title font-weight-bold text-dark">
                                                            {{ $progres->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') }}
                                                        </h6>
                                                        @if ($index == 0)
                                                            <button class="btn btn-dark btn-sm ml-4">Proses
                                                                Terakhir</button>
                                                        @endif
                                                    </div>


                                                    <p class="card-text">{{ $progres->penanganan }}</p>

                                                    @if ($progres->fotopengerjaan == null)
                                                        <button class="btn btn-dark disabled">Tidak ada lampiran</button>
                                                    @else
                                                        <a href="{{ asset($progres->fotopengerjaan) }}"
                                                            class="btn btn-sm btn-primary">Gambar Penanganan </a>
                                                    @endif

                                                </div>
                                            </div>
                                        @endforeach
                                    @endif




                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <form action="{{ route('tiket.update', $tiket->id) }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card shadow">
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">Beri Tanggapan</h5>
                                        <hr>
                                        @switch($tiket->status)
                                            @case('New')
                                                <h6 class="mt-3 mb-4 text-dark">Pilih PIC Yang Menanggapi</h6>

                                                <input type="hidden" name="menanggapi" value="menanggapi">
                                                <div class="departement">
                                                    <div class="form-group mb-3">
                                                        <label for="Status">Pilih Departemen Terkait</label>
                                                        <select class="form-control mb-3" name="departemen" id="departemen"
                                                            required>
                                                            <option value="BK">BK</option>
                                                            <option value="Humas">Humas</option>
                                                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                                                            <option value="Kesiswaan">Kesiswaan</option>
                                                            <option value="Koperasi">Koperasi</option>
                                                            <option value="Kurikulum">Kurikulum</option>
                                                            <option value="Psikolog & BK">Psikolog & BK</option>
                                                            <option value="Psikolog">Psikolog</option>
                                                            <option value="TU">TU</option>
                                                            <option value="Wali kelas">Wali Kelas</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="humas mb-3">
                                                    <div class="form-group mb-3">
                                                        <label for="Status">Pilih PIC Yang Menanganani</label>
                                                        <select class="form-control mb-3" name="pic_menanggapi"
                                                            id="pic_menanggapi" required>
                                                            @foreach ($picSelect as $select)
                                                                <option value="{{ $select->id }}"> <span
                                                                        class="text-danger">{{ $select->departemen ?? '-' }}
                                                                    </span>
                                                                    - {{ $select->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @break

                                            @case('Proses')
                                                @if (Auth::user()->hasRole('Admin'))
                                                    <h6 class="mt-3 mb-4 text-dark">PIC sudah ditentukan</h6>

                                                    <input type="hidden" name="menanggapi" value="selesai">
                                                    <div class="mb-3">
                                                        <strong><label for="">Departemen</label></strong>
                                                        <input type="text" name="departemen" id=""
                                                            value="{{ $tiket->departemen }}" class="form-control" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong><label for="">Pic Menanggapi</label></strong>
                                                        <input type="text" name="" id=""
                                                            value="{{ $tiket->pic->name }}" class="form-control" disabled>
                                                    </div>

                                                    <div class="mb-3">
                                                        <strong><label for="Deskripsi">Deskripsi Penanganan</label></strong>
                                                        <textarea class="form-control mb-3" id="penanganan" name="penanganan" class="materialize-textarea validate"
                                                            length="120" disabled> {{ $tiket->penanganan ?? 'Belum ditangani' }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <strong><label for="">Status</label></strong>
                                                        <input type="text" class="form-control" value="{{ $tiket->status }}"
                                                            disabled>
                                                    </div>


                                                    <div>
                                                        <strong><label for="fotoperbaikan">Foto Penanganan</label></strong> <br>
                                                        @if ($tiket->fotopengerjaan == null)
                                                            <input type="text" name="fotopengerjaan" class="form-control"
                                                                value="PIC belum menangani" disabled>
                                                        @else
                                                            <img class="img-fluid" src="{{ asset($tiket->fotopengerjaan) }}"
                                                                alt="">
                                                        @endif
                                                    </div>


                                                    <button type="button" class="btn btn-info mt-3" data-toggle="modal"
                                                        data-target="#exampleModal">Edit Ulang</button>
                                                @else
                                                    {{-- Ketika proses dan akan mengisi --}}
                                                    <input type="hidden" name="menanggapi" value="selesai">
                                                    <div class="mb-3">
                                                        <strong><label for="">Departemen</label></strong>
                                                        <input type="text" name="departemen" id=""
                                                            value="{{ $tiket->departemen }}" class="form-control" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong><label for="">Pic Menanggapi</label></strong>
                                                        <input type="text" name="" id=""
                                                            value="{{ $tiket->pic->name }} (Anda)" class="form-control" disabled>
                                                    </div>

                                                    <div class="mb-3">
                                                        <strong><label for="Deskripsi">Deskripsi Penanganan</label></strong>
                                                        <textarea class="form-control mb-3" id="penanganan" name="penanganan" class="materialize-textarea validate"
                                                            length="120"> {{ $tiket->penanganan }}</textarea>
                                                    </div>


                                                    <div>
                                                        <strong><label for="fotoperbaikan">Foto Penanganan</label></strong> <br>
                                                        <input type="file" name="fotopengerjaan" class="form-control"
                                                            accept="image/*" id="">
                                                    </div>
                                                @endif
                                            @break

                                            @default
                                                <h3 class="font-weight-bold">Selesai</h3>
                                                {{-- <div class="mb-3">
                                                    <label for="">Departemen</label>
                                                    <input type="text" name="departemen" id=""
                                                        value="{{ $tiket->departemen }}" class="form-control" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="">Pic Menanggapi</label>
                                                    <input type="text" name="" id=""
                                                        value="{{ $tiket->pic->name }}" class="form-control" disabled>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="Problem">Deskripsi Penanganan</label>
                                                    <textarea class="form-control mb-3" id="penanganan" name="penanganan" class="materialize-textarea validate"
                                                        length="120" disabled> {{ $tiket->penanganan }}</textarea>
                                                </div>


                                                <div>
                                                    <label for="fotoperbaikan">Foto Penanganan</label> <br>
                                                    @if ($tiket->fotopengerjaan == null)
                                                        <input type="text" name="fotopengerjaan" class="form-control"
                                                            value="PIC tidak melampirkan foto" disabled>
                                                    @else
                                                        <img class="img-fluid" src="{{ asset($tiket->fotopengerjaan) }}"
                                                            alt="">
                                                    @endif
                                                </div> --}}
                                        @endswitch





                                    </div>

                                    @if (Auth::user()->hasRole('Admin'))
                                        @if ($tiket->status == 'New')
                                            <button class="btn btn-primary m-4" type="submit">Update Ticket</button>
                                        @elseif ($tiket->status == 'Proses')
                                            <button class="btn btn-primary m-4" disabled>Anda (Admin) Sudah Melakukan Update
                                                Tiket</button>
                                        @else
                                            <button class="btn btn-primary m-4" disabled> Selesai </button>
                                        @endif
                                    @else
                                        @if ($tiket->status == 'Proses')
                                            <button class="btn btn-primary m-4">Update Ticket</button>
                                        @else
                                            <button class="btn btn-primary m-4" disabled> Selesai </button>
                                        @endif
                                    @endif
                                </div>


                            </form>


                            @if ($tiket->status == 'Proses')
                                <div class="card shadow mt-3">

                                    <div class="card-body">
                                        <a href="{{ route('tiket.finish', $tiket->id) }}"
                                            class="btn btn-black btn-danger w-100"
                                            onclick="return confirm('Apakah anda yakin ingin menyelesaikan tiket ini?')">
                                            Selesaikan Tiket</a>

                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>




                </div>
            </div>



        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="mt-3 mb-4 font-weight-bold text-dark">Pilih PIC Yang Menanggapi</h3>

                    <form action="{{ route('tiket.update', $tiket->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="menanggapi" value="menanggapi">
                        <div class="departement">
                            <div class="form-group mb-3">
                                <label for="Status">Pilih Departemen Terkait</label>
                                <select class="form-control mb-3" name="departemen" id="departemen" required>
                                    <option value="BK">BK</option>
                                    <option value="Humas">Humas</option>
                                    <option value="Kepala Sekolah">Kepala Sekolah</option>
                                    <option value="Kesiswaan">Kesiswaan</option>
                                    <option value="Koperasi">Koperasi</option>
                                    <option value="Kurikulum">Kurikulum</option>
                                    <option value="Psikolog & BK">Psikolog & BK</option>
                                    <option value="Psikolog">Psikolog</option>
                                    <option value="TU">TU</option>
                                    <option value="Wali kelas">Wali Kelas</option>

                                </select>
                            </div>
                        </div>
                        <div class="humas mb-3">
                            <div class="form-group mb-3">
                                <label for="Status">Pilih PIC Yang Menanganani</label>
                                <select class="form-control mb-3" name="pic_menanggapi" id="pic_menanggapi" required>
                                    @foreach ($picSelect as $select)
                                        <option value="{{ $select->id }}"> <span
                                                class="text-danger">{{ $select->departemen ?? '-' }} </span>
                                            - {{ $select->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
