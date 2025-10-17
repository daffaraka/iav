@extends('dashboard.layout')
@section('content')
    <div class="container my-3">

        <div class="card mb-3">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title fw-bold text-uppercase mb-0">{{ $title }}</h2>

                    <a class="btn btn-primary" data-bs-toggle="modal" href="#tambahWigModal" role="button">Tambah WIG Baru</a>


                    <div class="modal fade" id="tambahWigModal" aria-hidden="true" aria-labelledby="tambahWigModalLabel"
                        tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalToggleLabel">
                                        Tambah WIG Baru
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <hr class="my-1">
                                <div class="modal-body mt-0 pt-0 pb-3">
                                    <form action="" method="POST">
                                        @csrf
                                        <input type="hidden" name="departement_id" value="{{ $departement->id }}">
                                        <div class="form-group my-3">
                                            <label class="fw-bold"for="">Nama WIG</label>
                                            <input required type="text" name="nama_wig" id=""
                                                value="{{ old('nama_wig') }}"
                                                class="form-control @error('nama_wig') is-invalid @enderror">
                                            @error('nama_wig')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group my-3">
                                            <label class="fw-bold"for="">Deskripsi WIG</label>
                                            <textarea name="deskripsi_wig" class="form-control @error('deskripsi_wig') is-invalid @enderror" rows="3">{{ old('deskripsi_wig') }}</textarea>
                                            @error('deskripsi_wig')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group my-3">

                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="fw-bold"for="">Tanggal Mulai</label>
                                                    <input required type="date" name="tanggal_mulai_wig"
                                                        value="{{ old('tanggal_mulai_wig') }}"
                                                        class="form-control @error('tanggal_mulai_wig') is-invalid @enderror">
                                                    @error('tanggal_mulai_wig')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-6">
                                                    <label class="fw-bold"for="">Tanggal Berakhir</label>
                                                    <input required type="date" name="tanggal_berakhir_wig"
                                                        value="{{ old('tanggal_berakhir_wig') }}"
                                                        class="form-control @error('tanggal_berakhir_wig') is-invalid @enderror">
                                                    @error('tanggal_berakhir_wig')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>



                                        </div>

                                        <div class="form-group my-3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="fw-bold"for="">From X (Angka)</label>
                                                    <input type="number" class="form-control" value="from_x">
                                                </div>

                                                <div class="col-6">
                                                    <label class="fw-bold"for="">To Y (Angka)</label>
                                                    <input type="number" class="form-control" value="from_y">
                                                </div>
                                            </div>


                                        </div>


                                        <div class="form-group my-3">
                                            <label class="fw-bold"for="">Satuan</label>
                                            <select name="satuan" id="" class="form-control">
                                                <option value="%"> Persen (%)</option>
                                                <option value="Angka"> Unit </option>


                                            </select>
                                            @error('unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button class="btn btn-primary mt-3 shadow" type="submit"
                                            id="submitWig">Submit</button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>



                    {{-- <a href="" class="btn btn-info">Tambah WIG</a> --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Total</h5>
                        <p class="card-text h2">{{ $wig_total }}</p>
                        <a href="#" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Aktif</h5>
                        <p class="card-text h2">{{ $wig_aktif }}</p>
                        <a href="#" class="btn btn-light">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Selesai</h5>
                        <p class="card-text h2">{{ $wig_selesai }}</p>
                        <a href="#" class="btn btn-light">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-danger ">
                    <div class="card-body">
                        <h5 class="card-title">Tidak Aktif</h5>
                        <p class="card-text h2">{{ $wig_tidak_aktif }}</p>
                        <a href="#" class="btn btn-light">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row my-3">
            @foreach ($departement->wigs as $wig)
                <div class="col-8 mb-3">
                    <div class="card shadow-md border">
                        <div class="card-body">

                            <ul class="list-group">

                                <li class="d-flex mb-4 pb-1">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-success fw-semibold d-block mb-1">
                                                {{ $wig->judul_wig }}
                                            </small>
                                            <h6 class="mb-0">{{ $wig->deskripsi_wig }}</h6>
                                        </div>
                                        {{-- <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">100%</h6>
                                        <span class="text-muted">Progress</span>
                                    </div> --}}

                                     <div class="d-flex gap-2">
                                        <a href="{{ route('dept.edit.wig', [$departement->id, $wig->id]) }}"
                                            class="btn btn-dark">Edit </a>
                                        <a href="{{ route('dept.show.wig', [$departement->id, $wig->id]) }}"
                                            class="btn btn-sm btn-outline-primary shadow d-flex align-items-center justify-content-center">Lihat

                                        </a>
                                    </div>
                                    </div>

                                   

                                    </a>
                                </li>




                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <small class="text-success fw-semibold d-block mb-1">
                                Deskripsi WIG
                            </small>
                            <h6 class="mb-0">{{ $wig->deskripsi_wig }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
            {{--             
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title fw-bold">Progress Terbaru</h3>
                        <hr>
                        <ul class="list-group">
                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-success fw-semibold d-block mb-1">
                                            WIG Tercapai
                                        </small>
                                        <h6 class="mb-0">Implementasi Sistem Informasi Terintegrasi</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">100%</h6>
                                        <span class="text-muted">Progress</span>
                                    </div>
                                </div>
                            </li>

                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-success fw-semibold d-block mb-1">
                                            WIG Tercapai
                                        </small>
                                        <h6 class="mb-0">Upgrade Infrastruktur Jaringan</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">85%</h6>
                                        <span class="text-muted">Progress</span>
                                    </div>
                                </div>
                            </li>

                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                            WIG Dalam Proses
                                        </small>
                                        <h6 class="mb-0">Digitalisasi Proses Administrasi</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">60%</h6>
                                        <span class="text-muted">Progress</span>
                                    </div>
                                </div>
                            </li>

                            <li class="d-flex">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                            WIG Dalam Proses
                                        </small>
                                        <h6 class="mb-0">Pelatihan Digital Literacy Staff</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">45%</h6>
                                        <span class="text-muted">Progress</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $('#submitWig').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('wig.storeByDept') }}",
                type: "POST",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'departement_id': $('input[name=departement_id]').val(),
                    'nama_wig': $('input[name=nama_wig]').val(),
                    'deskripsi_wig': $('textarea[name=deskripsi_wig]').val(),
                    'tanggal_mulai_wig': $('input[name=tanggal_mulai_wig]').val(),
                    'tanggal_berakhir_wig': $('input[name=tanggal_berakhir_wig]').val(),
                    'from_x': $('input[value=from_x]').val(),
                    'from_y': $('input[value=from_y]').val(),
                    'satuan': $('select[name=satuan]').val()
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'WIG berhasil ditambahkan',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#tambahWigModal').modal('hide');

                        // 🧹 Bersihkan backdrop yang tersisa (jika ada)
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('overflow',
                            'auto'); // pastikan body bisa diklik/scroll
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan, silahkan coba lagi',
                        icon: 'error',
                        confirmButtonText: 'Ok',
                        position: 'absolute'
                    });

                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $(`[name="${key}"]`).addClass('is-invalid');
                        $(`[name="${key}"]`).next('.invalid-feedback').text(value[
                            0]);
                    });
                }
            });
        });


        var options = {
            series: [{
                name: 'XYZ MOTORS',
                data: [{
                    x: new Date('2018-02-12').getTime(),
                    y: 76
                }, {
                    x: new Date('2018-02-13').getTime(),
                    y: 78
                }, {
                    x: new Date('2018-02-14').getTime(),
                    y: 82
                }, {
                    x: new Date('2018-02-15').getTime(),
                    y: 80
                }, {
                    x: new Date('2018-02-16').getTime(),
                    y: 85
                }]
            }],
            chart: {
                type: 'bar',
                stacked: false,
                height: 500,
                zoom: {
                    type: 'x',
                    enabled: true,
                    autoScaleYaxis: true
                },
                toolbar: {
                    autoSelected: 'zoom'
                }
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 0,
            },
            title: {
                text: 'WIG',
                align: 'center'
            },
            fill: {
                gradient: {
                    opacityTo: 0,
                    stops: [0, 90, 100]
                },
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return (val / 1000000).toFixed(0);
                    },
                },
                title: {
                    text: 'Price'
                },
            },
            xaxis: {
                type: 'datetime',
            },
            tooltip: {
                shared: false,
                y: {
                    formatter: function(val) {
                        return (val / 1000000).toFixed(0)
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
