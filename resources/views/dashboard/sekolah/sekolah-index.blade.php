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
                        <div id="tingkatJagakarsa"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Tingkat Lomba - Cinere</h6>
                    </div>
                    <div class="card-body">
                        <div id="tingkatCinere"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Tingkat Lomba - Pamulang</h6>
                    </div>
                    <div class="card-body">
                        <div id="tingkatPamulang"></div>
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
                        <div id="prestasiTahun"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const jagakarsaData = {!! $tingkatJagakarsa !!};
        const cinereData = {!! $tingkatCinere !!};
        const pamulangData = {!! $tingkatPamulang !!};

        const pieOptions = {
            chart: { type: 'donut', height: 280 },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '16px',
                                fontWeight: 600
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return opts.w.config.series[opts.seriesIndex]
                }
            },
            legend: {
                show: true,
                position: 'bottom',
                fontSize: '13px'
            },
            colors: ['#696cff', '#8592a3', '#71dd37', '#ffab00', '#ff3e1d']
        };

        new ApexCharts(document.querySelector('#tingkatJagakarsa'), {
            ...pieOptions,
            series: jagakarsaData.map(d => d.y),
            labels: jagakarsaData.map(d => d.name)
        }).render();

        new ApexCharts(document.querySelector('#tingkatCinere'), {
            ...pieOptions,
            series: cinereData.map(d => d.y),
            labels: cinereData.map(d => d.name)
        }).render();

        new ApexCharts(document.querySelector('#tingkatPamulang'), {
            ...pieOptions,
            series: pamulangData.map(d => d.y),
            labels: pamulangData.map(d => d.name)
        }).render();

        new ApexCharts(document.querySelector('#prestasiTahun'), {
            chart: { type: 'line', height: 400, toolbar: { show: true } },
            series: [
                { name: 'Jagakarsa', data: {!! $tahunJagakarsa !!} },
                { name: 'Cinere', data: {!! $tahunCinere !!} },
                { name: 'Pamulang', data: {!! $tahunPamulang !!} }
            ],
            stroke: { curve: 'smooth', width: 3 },
            markers: { size: 5, hover: { size: 7 } },
            colors: ['#696cff', '#71dd37', '#ffab00'],
            xaxis: {
                categories: {!! $tahunLabels !!},
                title: { text: 'Tahun Pelajaran' }
            },
            yaxis: {
                min: 0,
                title: { text: 'Jumlah Prestasi' }
            },
            grid: { borderColor: '#f1f1f1' }
        }).render();
    </script>
@endpush
