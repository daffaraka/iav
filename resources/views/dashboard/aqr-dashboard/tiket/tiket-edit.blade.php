@extends('dashboard.layout')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Data Tiket</h3>
                @if (!$tiket->ai_analyzed_at)
                    <form method="POST" action="{{ route('dashboard.aqr.analytics.analyze', $tiket->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">🤖 Analisis dengan AI</button>
                    </form>
                @else
                    <span class="badge badge-success">✅ Sudah Dianalisis AI</span>
                @endif
            </div>

            <div class="container-fluid">
                <div class="py-4">

                    <div class="h1 text-end">
                        <h3 class="mx-2 mb-4"> No Tiket : {{ $tiket->no_tiket }} </h3>
                    </div>
                    <div class="form-input mb-3">
                        <strong><label class="cd-label left-text">Type Pengirim</label></strong>
                        <div class="">
                            <button
                                class="btn btn-{{ $tiket->pengirim == 'Masyarakat Umum' ? 'primary' : 'warning' }}">{{ $tiket->pengirim }}</button>

                        </div>
                    </div>

                    @if ($tiket->pengirim == 'Warga Sekolah')
                        <div class="form-input mb-3">
                            <strong><label class="cd-label left-text">Kategori Permasalahan</label></strong>
                            <div class="">
                                <button
                                    class="btn btn-{{ $tiket->kategori_pic == 'Kepala Sekolah' ? 'warning' : 'danger' }}">{{ $tiket->option->kategori_pic }}</button>
                                <button
                                    class="btn btn-{{ $tiket->kategori_pic == 'Kepala Sekolah' ? 'info' : 'secondary' }}">{{ $tiket->option->nama_option }}</button>
                            </div>
                        </div>
                    @endif

                    <div class="form-input mb-3">
                        <strong><label class="cd-label left-text">Nama</label></strong>
                        <input class="form-control" type="text" name="nama" id="nama" value="{{ $tiket->nama }}"
                            readonly>
                    </div>

                    <div class="form-input mb-3">
                        <strong><label class="cd-label left-text">Email</label></strong>
                        <input class="form-control" type="email" name="email" id="email" value="{{ $tiket->email }}"
                            readonly>
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

                    @if ($tiket->pengirim == 'Warga Sekolah')
                        <div class="form-input mb-3">
                            <strong><label class="cd-label left-text">Lokasi Sekolah</label></strong>
                            <input class="form-control" type="text" name="lokasi_kendala" id="lokasi_kendala"
                                value="{{ $tiket->lokasi_kendala }}" readonly>
                        </div>
                    @endif

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




                    <hr style="height:3px;border-width:0;color:gray;background-color:gray">

                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="fw-bold text-dark">Riwayat Tanggapan</h5>
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
                                                        <button class="btn btn-dark disabled">Tidak ada
                                                            lampiran</button>
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
                            <form action="{{ route('dashboard.aqr.tiket.update', $tiket->id) }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card shadow">
                                    <div class="card-body">



                                        <h5 class="fw-bold text-dark">Beri Tanggapan</h5>
                                        @if ($tiket->pengirim == 'Warga Sekolah')
                                            <div class="bg-dark p-3 text-light rounded shadow"><i class="bx bx-info-circle"
                                                    aria-hidden="true"></i> Jika pengirim adalah warga sekolah, maka akan
                                                otomatis memilih Kepala Sekolah / Kepala Tata Usaha berdasarkan Unit dan
                                                Jenjang sekolah sebagai gerbang pertama.
                                            </div>
                                        @else
                                            <div class="bg-dark p-3 text-light rounded shadow"><i class="bx bx-info-circle"
                                                    aria-hidden="true"></i> Pengirim adalah adalah masyarakat umum dan akan
                                                ditangani oleh <b class="text-white">Humas</b>
                                            </div>
                                        @endif
                                        <hr>


                                        @if ($tiket->status != 'Selesai')
                                            @if ($tiket->pengirim == 'Warga Sekolah')
                                                @include('dashboard.aqr-dashboard.tiket.tiket-warga-sekolah')
                                            @else
                                                @include('dashboard.aqr-dashboard.tiket.tiket-masyarakat-umum')

                                                {{-- Forward to Kepala Sekolah/TU for Masyarakat Umum --}}
                                                @hasanyrole(['super-admin', 'humas'])
                                                    @if($tiket->status == 'Proses' && !$tiket->pic_id)
                                                        <hr>
                                                        <h6 class="fw-bold text-primary">Teruskan ke:</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-warning btn-sm w-100"
                                                                        data-bs-toggle="modal" data-bs-target="#forwardKepsekModal">
                                                                    <i class="fas fa-user-tie"></i> Kepala Sekolah
                                                                </button>
                                                            </div>
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-info btn-sm w-100"
                                                                        data-bs-toggle="modal" data-bs-target="#forwardTUModal">
                                                                    <i class="fas fa-user-cog"></i> Kepala TU
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endhasanyrole
                                            @endif
                                        @endif






                                    </div>



                                    @hasanyrole(['super-admin', 'humas'])
                                        @if ($tiket->pengirim == 'Masyarakat Umum')
                                            @if ($tiket->status == 'Proses')
                                                <button class="btn btn-primary m-4" type="submit">Update Ticket</button>
                                            @endif

                                        @endif
                                    @endhasanyrole

                                    @hasanyrole(['super-admin', 'tata-usaha', 'humas', 'admin', 'kepala-sekolah',
                                        'kepala-tata-usaha','tata-usaha'])
                                        @if ($tiket->status == 'New')
                                            <button class="btn btn-primary m-4" type="submit">Update Ticket</button>
                                        @elseif ($tiket->status == 'Proses')
                                            {{-- <button class="btn btn-primary m-4" type="submit" disabled>Update Ticket</button> --}}
                                        @else
                                            <button class="btn btn-primary m-4" disabled> Selesai </button>
                                        @endif
                                    @else
                                        @if ($tiket->status == 'Proses')
                                            <button class="btn btn-primary m-4" type="submit">Update Ticket</button>
                                        @else
                                            <button class="btn btn-primary m-4" disabled> Selesai </button>
                                        @endif
                                    @endhasanyrole

                            </form>


                            @if ($tiket->status == 'Proses')
                                <div class="card shadow mt-3">

                                    <div class="card-body">
                                        <a href="{{ route('dashboard.aqr.tiket.finish', $tiket->id) }}"
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


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="badge bg-danger badge-danger close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3 class="mt-3 mb-4 font-weight-bold text-dark">Pilih PIC Yang Menanggapi</h3>

                        <form action="{{ route('dashboard.aqr.tiket.update', $tiket->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="pic_menanggapi" value="pic_menanggapi">
                            <div class="departement">
                                <div class="form-group mb-3">
                                    <label for="Status">Pilih Departemen Terkait</label>
                                    <select class="form-control mb-3" name="departemen" id="departemen" required>
                                        <option value="Wakil Kurikulum">Wakil Kurikulum</option>
                                        <option value="Wakil Kesiswaan">Wakil Kesiswaan</option>
                                        <option value="Guru Kelas">Wali Kelas</option>
                                        <option value="Psikolog">Psikolog</option>
                                        <option value="Guru BK">BK</option>
                                        <option value="Keuangan">Keuangan</option>
                                        <option value="Staf Sarpra">Sarana dan Prasarana</option>
                                        <option value="Tata Usaha">Tata Usaha</option>
                                        <option value="Teknisi">Teknisi</option>
                                        <option value="Humas">Humas</option>
                                        <option value="Koperasi">Koperasi</option>

                                        {{-- <option value="Kepala Sekolah">Kepala Sekolah</option> --}}



                                    </select>
                                </div>
                            </div>
                            <div class="pic mb-3">
                                <div class="form-group mb-3">
                                    <label for="Status">Pilih PIC Yang Menanganani</label>
                                    <select class="form-control mb-3" name="pic_menanggapi" id="pic_menanggapi" required>
                                        <option>Pilih PC</option>
                                        {{-- @foreach ($picSelect as $select)
                                            <option value="{{ $select->id }}"> <span
                                        class="text-danger">{{ $select->departemen ?? '-' }} </span>
                                    - {{ $select->name }}
                                    </option>
                                    @endforeach --}}
                                    </select>
                                </div>
                            </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Forward to Kepala Sekolah Modal -->
    <div class="modal fade" id="forwardKepsekModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Teruskan ke Kepala Sekolah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('dashboard.aqr.tiket.forward') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">
                    <input type="hidden" name="forward_type" value="kepala-sekolah">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Pilih Kepala Sekolah:</label>
                            <select name="pic_id" class="form-control" required>
                                <option value="">-- Pilih Kepala Sekolah --</option>
                                @php
                                    $kepalaSekolah = $picSelect->filter(function($user) {
                                        return stripos($user->jabatan, 'kepala sekolah') !== false ||
                                               stripos($user->jabatan, 'kepsek') !== false;
                                    });
                                @endphp
                                @foreach($kepalaSekolah as $kepsek)
                                    <option value="{{ $kepsek->id }}">{{ $kepsek->name }} - {{ $kepsek->unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Catatan (opsional):</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan untuk kepala sekolah..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Teruskan ke Kepala Sekolah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Forward to Kepala TU Modal -->
    <div class="modal fade" id="forwardTUModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Teruskan ke Kepala TU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('dashboard.aqr.tiket.forward') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">
                    <input type="hidden" name="forward_type" value="kepala-tu">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Pilih Kepala TU:</label>
                            <select name="pic_id" class="form-control" required>
                                <option value="">-- Pilih Kepala TU --</option>
                                @php
                                    $kepalaTU = $picSelect->filter(function($user) {
                                        return stripos($user->jabatan, 'tata usaha') !== false ||
                                               stripos($user->jabatan, 'tu') !== false;
                                    });
                                @endphp
                                @foreach($kepalaTU as $tu)
                                    <option value="{{ $tu->id }}">{{ $tu->name }} - {{ $tu->unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Catatan (opsional):</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan untuk kepala TU..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Teruskan ke Kepala TU</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Departemen change handler
            $('#departemen').change(function(e) {
                var departemen = $(this).val();

                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "{{ route('helpdesk.home.get-pic-by-dept') }}",
                    data: { _token: "{{ csrf_token() }}", departemen: departemen },
                    dataType: "json",
                    success: function(response) {
                        $('#pic_menanggapi').empty().append('<option value="">Pilih PIC</option>');
                        $.each(response, function(index, pic) {
                            $('#pic_menanggapi').append(`<option value="${pic.id}">${pic.unit} - ${pic.jabatan} - ${pic.name}</option>`);
                        });
                    }
                });
            });

            // Dynamic PIC selection for forward
            $('#forwardType').on('change', function() {
                const forwardType = $(this).val();
                const $picSelect = $('#picSelect');
                const picData = {!! json_encode($picSelect) !!};


                console.log(picData);

                if (!forwardType) {
                    $picSelect.prop('disabled', true).html('<option value="">-- Pilih jabatan terlebih dahulu --</option>');
                    return;
                }

                let filteredUsers = [];
                if (forwardType === 'kepala-sekolah') {
                    filteredUsers = picData.filter(u => u.jabatan && (
                        u.jabatan.toLowerCase().includes('kepala sekolah') ||
                        u.jabatan.toLowerCase().includes('kepsek')
                    ));
                } else if (forwardType === 'kepala-tu') {
                    filteredUsers = picData.filter(u => u.jabatan && (
                        u.jabatan.toLowerCase().includes('tata usaha') ||
                        u.jabatan.toLowerCase().includes('tu')
                    ));
                }

                let options = '<option value="">-- Pilih Nama --</option>';
                filteredUsers.forEach(u => {
                    options += `<option value="${u.id}">${u.name} - ${u.unit || 'N/A'}</option>`;
                });

                $picSelect.prop('disabled', false).html(options);
            });
        });
    </script>
@endpush
