@extends('dashboard.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Jagakarsa -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="m-0">Sekolah Jagakarsa</h5>
                        <small class="text-muted">Persebaran PTN & PTS</small>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3">
                            <strong>Total Prestasi:</strong> {{ $prestasiJagakarsa }}
                        </div>
                        <div id="chartJagakarsa" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Cinere -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="m-0">Sekolah Cinere</h5>
                        <small class="text-muted">Persebaran PTN & PTS</small>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3">
                            <strong>Total Prestasi:</strong> {{ $prestasiCinere }}
                        </div>
                        <div id="chartCinere" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Pamulang -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="m-0">Sekolah Pamulang</h5>
                        <small class="text-muted">Persebaran PTN & PTS (Dummy)</small>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3">
                            <strong>Total Prestasi:</strong> {{ $prestasiPamulang }}
                        </div>
                        <div id="chartPamulang" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
Highcharts.chart('chartJagakarsa', {
    chart: { type: 'pie' },
    title: { text: null },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}'
            },
            showInLegend: true
        }
    },
    series: [{ name: 'Siswa', colorByPoint: true, data: {!! $jagakarsa !!} }]
});

Highcharts.chart('chartCinere', {
    chart: { type: 'pie' },
    title: { text: null },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}'
            },
            showInLegend: true
        }
    },
    series: [{ name: 'Siswa', colorByPoint: true, data: {!! $cinere !!} }]
});

Highcharts.chart('chartPamulang', {
    chart: { type: 'pie' },
    title: { text: null },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}'
            },
            showInLegend: true
        }
    },
    series: [{ name: 'Siswa', colorByPoint: true, data: {!! $pamulang !!} }]
});
</script>
@endpush
