@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard AQR</h1>
            <a href="#" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50 me-1"></i> Generate Report
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">

            @hasanyrole(['super-admin','kepala-tata-usaha','kepala-psikolog', 'humas','kepala-sekolah'])
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-4 border-primary border-bottom-0 border-top-0 shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tiket Baru</div>
                                    <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $tiketNew ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endhasanyrole

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-4 border-success border-bottom-0 border-top-0 shadow h-100 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tiket Dalam proses
                                </div>
                                <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $tiketProses ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-4 border-info border-bottom-0 border-top-0 shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tiket Selesai</div>
                                <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $tiketClosed ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-4 border-warning border-bottom-0 border-top-0 shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Tiket</div>
                                <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $totalTiket ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tiket Lists -->
        <div class="row">

            @hasanyrole(['super-admin','kepala-tata-usaha','kepala-psikolog','humas','kepala-sekolah'])
                <!-- Tiket Baru -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">Tiket Baru</h6>
                        </div>
                        <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                            @forelse ($latestTiket ?? [] as $item)
                                <div class="p-3" style="border-left-width: 3px !important;">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-1 text-dark">{{ $item->nama }}</h6>
                                        <button
                                            class="badge badge-sm {{ $item->pengirim == 'Warga Sekolah' ? 'bg-dark text-white' : 'btn-outline-light text-dark' }}">
                                            <i
                                                class="fas {{ $item->pengirim == 'Warga Sekolah' ? 'fa-graduation-cap' : 'fa-users' }} me-1"></i>
                                            {{ $item->pengirim }}
                                        </button>
                                    </div>

                                    <div class="mb-2">
                                        <small class="d-block"><strong>Kendala:</strong>
                                            {{ Str::limit($item->detail_kendala, 60) }}</small>
                                        @if ($item->lokasi_kendala)
                                            <small class="d-block"><strong>Lokasi:</strong> {{ $item->lokasi_kendala }}</small>
                                        @endif
                                        <small class="d-block"><strong>Waktu:</strong>
                                            {{ $item->created_at->diffForHumans() }}</small>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('dashboard.aqr.tiket.edit', $item->id) }}"
                                            class="btn btn-info btn-sm flex-fill">Lihat Detail</a>
                                        @if ($item->filename)
                                            <a href="{{ asset($item->filename) }}" class="btn btn-outline-primary btn-sm"
                                                target="_blank">
                                                <i class="fas fa-paperclip"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-muted">Tidak ada tiket baru</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endhasanyrole

            <!-- Tiket Dalam Proses -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 bg-success">
                        <h6 class="m-0 font-weight-bold text-white">Tiket Dalam Proses</h6>
                    </div>
                    <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                        @forelse ($latestProses ?? [] as $item)
                            <div class="p-3" style="border-left-width: 3px !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-1 text-dark">{{ $item->nama }}</h6>
                                    <button
                                        class="badge badge-sm {{ $item->pengirim == 'Warga Sekolah' ? 'bg-dark text-white' : 'btn-outline-light text-dark' }}">
                                        <i
                                            class="fas {{ $item->pengirim == 'Warga Sekolah' ? 'fa-graduation-cap' : 'fa-users' }} me-1"></i>
                                        {{ $item->pengirim }}
                                    </button>
                                </div>

                                <div class="mb-2">
                                    <small class="d-block"><strong>PIC:</strong> {{ $item->pic->name ?? '-' }}</small>
                                    <small class="d-block"><strong>Kendala:</strong>
                                        {{ Str::limit($item->detail_kendala, 60) }}</small>
                                    <small class="d-block"><strong>Waktu:</strong>
                                        {{ $item->created_at->diffForHumans() }}</small>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('dashboard.aqr.tiket.edit', $item->id) }}"
                                        class="btn btn-success btn-sm flex-fill">Lihat Detail</a>
                                    @if ($item->filename)
                                        <a href="{{ asset($item->filename) }}" class="btn btn-outline-primary btn-sm"
                                            target="_blank">
                                            <i class="fas fa-paperclip"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-cog fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">Tidak ada tiket dalam proses</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Tiket Selesai -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 bg-info">
                        <h6 class="m-0 font-weight-bold text-white">Tiket Selesai</h6>
                    </div>
                    <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                        @forelse ($latestSelesai ?? [] as $item)
                            <div class="p-3" style="border-left-width: 3px !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-1 text-dark">{{ $item->nama }}</h6>
                                    <div class="d-flex flex-column align-items-end">
                                        <button
                                            class="badge badge-sm {{ $item->pengirim == 'Warga Sekolah' ? 'bg-dark text-white' : 'btn-outline-light text-dark' }} mb-1">
                                            <i
                                                class="fas {{ $item->pengirim == 'Warga Sekolah' ? 'fa-graduation-cap' : 'fa-users' }} me-1"></i>
                                            {{ $item->pengirim }}
                                        </button>
                                        {{-- @if ($item->rating)
                                            <div class="d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $item->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 12px;"></i>
                                                @endfor
                                                <small class="ms-1 text-muted">({{ $item->rating }})</small>
                                            </div>
                                        @endif --}}
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <small class="d-block"><strong>Kendala:</strong>
                                        {{ Str::limit($item->detail_kendala, 60) }}</small>
                                    <small class="d-block"><strong>Selesai:</strong>
                                        {{ $item->waktu_close ? \Carbon\Carbon::parse($item->waktu_close)->diffForHumans() : '-' }}</small>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('dashboard.aqr.tiket.edit', $item->id) }}"
                                        class="btn btn-info btn-sm flex-fill">Lihat Detail</a>
                                    @if ($item->filename)
                                        <a href="{{ asset($item->filename) }}" class="btn btn-outline-primary btn-sm"
                                            target="_blank">
                                            <i class="fas fa-paperclip"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">Tidak ada tiket selesai</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">

            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tiket per Lokasi</h6>
                    </div>
                    <div class="card-body">
                        <div id="lokasiChart" style="height: 500px;"></div>
                    </div>
                </div>
            </div>


            <div class="col-5 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Tiket</h6>
                    </div>
                    <div class="card-body">
                        <div id="pieChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>


            <div class="col-7 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik Pengirim</h6>
                    </div>
                    <div class="card-body">
                        <div id="pengirimPieChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>



            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tiket per Minggu (Lokasi)</h6>
                    </div>
                    <div class="card-body">
                        <div id="barChart" style="height: 600px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        // Pie Chart
        Highcharts.chart('pieChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}'
                    },
                    showInLegend: true
                }
            },
            colors: ['#ffc107', '#17a2b8', '#28a745'],
            series: [{
                name: 'Tiket',
                colorByPoint: true,
                data: {!! $pieChartData !!}
            }]
        });

        // Bar Chart
        Highcharts.chart('barChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: null
            },
            xAxis: {
                categories: {!! $weekLabels !!},
                title: {
                    text: 'Minggu'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Tiket'
                }
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: {!! $barChartData !!}
        });

        // Lokasi Pie Chart
        Highcharts.chart('lokasiChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y} '
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Jumlah Tiket',
                colorByPoint: true,
                data: {!! $lokasiChartData !!}
            }]
        });


        // Status Pengirim Chart
        Highcharts.chart('pengirimPieChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}'
                    },
                    showInLegend: true
                }
            },
            colors: ['#ffa707', '#63a2b8'],
            series: [{
                name: 'Tipe Pengirim',
                colorByPoint: true,
                data: {!! $typePengirimChart !!}
            }]
        });
    </script>
@endpush
