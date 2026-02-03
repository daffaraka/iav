@extends('dashboard.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Charts Prestasi -->
        <div class="row">
            <!-- Tingkat Lomba Charts -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Tingkat Lomba - Jagakarsa</h6>
                    </div>
                    <div class="card-body">
                        <div id="tingkatJagakarsa" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Tingkat Lomba - Cinere</h6>
                    </div>
                    <div class="card-body">
                        <div id="tingkatCinere" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Tingkat Lomba - Pamulang</h6>
                    </div>
                    <div class="card-body">
                        <div id="tingkatPamulang" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi per Tahun Chart -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Prestasi per Tahun</h6>
                    </div>
                    <div class="card-body">
                        <div id="prestasiTahun" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>


        // PTN Charts


        // Tingkat Lomba Charts
        Highcharts.chart('tingkatJagakarsa', {
            chart: {
                type: 'pie'
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}'
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Prestasi',
                colorByPoint: true,
                data: {!! $tingkatJagakarsa !!}
            }]
        });

        Highcharts.chart('tingkatCinere', {
            chart: {
                type: 'pie'
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}'
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Prestasi',
                colorByPoint: true,
                data: {!! $tingkatCinere !!}
            }]
        });

        Highcharts.chart('tingkatPamulang', {
            chart: {
                type: 'pie'
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}'
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Prestasi',
                colorByPoint: true,
                data: {!! $tingkatPamulang !!}
            }]
        });

        // Prestasi per Tahun Line Chart
        Highcharts.chart('prestasiTahun', {
            chart: {
                type: 'line'
            },
            title: {
                text: null
            },
            xAxis: {
                categories: {!! $tahunLabels !!},
                title: {
                    text: 'Tahun Pelajaran'
                }
            },
            yAxis: {
                title: {
                    text: 'Jumlah Prestasi'
                }
            },
            series: [{
                    name: 'Jagakarsa',
                    data: {!! $tahunJagakarsa !!}
                },
                {
                    name: 'Cinere',
                    data: {!! $tahunCinere !!}
                },
                {
                    name: 'Pamulang',
                    data: {!! $tahunPamulang !!}
                }
            ]
        });
    </script>
@endpush
