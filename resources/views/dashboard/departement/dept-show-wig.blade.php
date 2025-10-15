@extends('dashboard.layout')
@section('content')
    <div class="container my-3">

        <div class="card mb-3">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title fw-bold text-uppercase mb-0">{{ $title }}</h2>
                    {{-- <a href="" class="btn btn-info">Tambah WIG</a> --}}
                </div>

            </div>
        </div>

        {{-- <div class="row">
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
        </div> --}}


        <div class="row my-3">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div id="chart"></div>

                    </div>
                </div>

            </div>

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
            </div>
        </div>


        <div class="row p-3 " id="leadMeasure">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex justify-content-between bg-dark p-3">
                        <h5 class="text-white fw-bold">Lead Measure</h5>
                        <a href="" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                            <i class="bx bx-plus"></i> Tambah Lead Measure
                        </a>
                    </div>


                    <div class="row mt-3">


                        @if (count($wig->lead_measures) > 0)
                            @foreach ($wig->lead_measures as $lm)
                                <div class="col-12 mb-3">
                                    <div class="card shadow border border-secondary">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$lm->judul_lead}}</h5>
                                            <p class="card-text">{{$lm->deskripsi_lead}}</p>


                                            @foreach ($lm->tasks as $task)
                                                {{$task}}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title text-dark text-center">Belum Ada Lead Measure</h3>

                                </div>
                            </div>
                        @endif


                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
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
