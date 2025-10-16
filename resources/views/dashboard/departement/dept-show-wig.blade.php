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

                            @foreach ($progressTerbaru as $progress)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-success fw-semibold d-block mb-1">
                                                {{ $progress->lead_measure->judul_lead }}
                                            </small>
                                            <div class="w-100">
                                                <h6 class="mb-0">{{ $progress->nama_tugas }}</h6>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="user-progress d-block align-items-center gap-1">
                                        <h6 class="mb-0 text-success">{{ $progress->jumlah_realisasi }}</h6>
                                        <span class="text-muted">Realisasi</span>
                                    </div>
                                </li>
                            @endforeach



                        </ul>
                    </div>
                </div>
            </div>
        </div>


        @foreach ($wig->lead_measures as $lm)
            <div class="col-12 mb-3">
                <div class="card shadow border border-secondary">
                    <div class="card-body">
                        <h5 class="card-title">{{ $lm->judul_lead }}</h5>
                        <p class="card-text">{{ $lm->deskripsi_lead }}</p>

                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        @foreach ($data_lm[$lm->id] ?? [] as $bulan => $items)
                                            <th colspan="4" class="text-center text-uppercase text-white">
                                                {{ $bulan }}</th>
                                        @endforeach
                                    </tr>
                                    <tr class="bg-dark text-white">
                                        @foreach ($data_lm[$lm->id] ?? [] as $bulan => $items)
                                            <th class="text-white">TARGET (%)</th>
                                            <th class="text-white">RINCIAN TUGAS</th>
                                            <th class="text-white">RESULT (%)</th>
                                            <th class="text-white">EVALUASI</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($data_lm[$lm->id] ?? [] as $bulan => $items)
                                            @php $task = $items->first(); @endphp
                                            <td>100</td>
                                            <td>{{ $task->nama_tugas }}</td>
                                            <td>{{ $task->jumlah_realisasi }}</td>
                                            <td>{{ $task->deskripsi }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach


    </div>
@endsection
@push('scripts')
    <script>
        var options = {
            series: [{
                name: 'Progress',
                data: [76, 78, 82, 80, 85] // nilai per bulan
            }],
            chart: {
                type: 'bar',
                stacked: false,
                height: 500,
                zoom: {
                    enabled: false // zoom tidak diperlukan untuk data bulanan
                },
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: true, // tampilkan nilai di atas batang
                style: {
                    colors: ['#fff']
                }
            },
            title: {
                text: 'Progress WIG',
                align: 'center'
            },
            xaxis: {
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei'],
                labels: {
                    style: {
                        colors: '#333',
                        fontSize: '14px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Persentase (%)'
                },
                labels: {
                    formatter: function(val) {
                        return val + '%'; // tampilkan persen
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    gradientToColors: undefined,
                    inverseColors: true,
                    stops: [0, 90, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + '%';
                    }
                }
            }
        };


                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
    </script>
@endpush
