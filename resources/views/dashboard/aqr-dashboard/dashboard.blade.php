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

            @hasanyrole(['super-admin', 'kepala-tata-usaha', 'kepala-psikolog', 'humas', 'kepala-sekolah'])
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

            @hasanyrole(['super-admin', 'kepala-tata-usaha', 'kepala-psikolog', 'humas', 'kepala-sekolah'])
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
                                        <small class="d-block"><strong>Gerbang pertama:</strong>
                                            {{ $item->first_pic->name ?? '-' }}</small>
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
                        <div id="barChartMingguan" style="height: 600px;"></div>

                        <div class="col-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">List PIC Psikolog</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Unit</th>
                                                    <th>Jenjang</th>
                                                    <th>Role</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($listPsikolog as $psikolog)
                                                    <tr>
                                                        <td>{{ $psikolog->name }}</td>
                                                        <td>{{ $psikolog->email }}</td>
                                                        <td>
                                                            @if ($psikolog->unit == 'Jagakarsa')
                                                                <span
                                                                    class="badge bg-primary">{{ $psikolog->unit }}</span>
                                                            @elseif($psikolog->unit == 'Pamulang')
                                                                <span
                                                                    class="badge bg-success">{{ $psikolog->unit }}</span>
                                                            @elseif($psikolog->unit == 'Cinere')
                                                                <span class="badge bg-info">{{ $psikolog->unit }}</span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($psikolog->jenjang)
                                                                @if ($psikolog->jenjang == 'TK')
                                                                    <span
                                                                        class="badge bg-warning">{{ strtoupper($psikolog->jenjang) }}</span>
                                                                @elseif ($psikolog->jenjang == 'SD')
                                                                    <span
                                                                        class="badge bg-success">{{ strtoupper($psikolog->jenjang) }}</span>
                                                                @elseif ($psikolog->jenjang == 'SMP')
                                                                    <span
                                                                        class="badge bg-info">{{ strtoupper($psikolog->jenjang) }}</span>
                                                                @elseif ($psikolog->jenjang == 'SMA')
                                                                    <span
                                                                        class="badge bg-danger">{{ strtoupper($psikolog->jenjang) }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-primary">{{ strtoupper($psikolog->jenjang) }}</span>
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach ($psikolog->roles as $role)
                                                                @if ($role->name == 'kepala-psikolog')
                                                                    <span
                                                                        class="badge bg-danger">{{ $role->name }}</span>
                                                                @elseif($role->name == 'psikolog')
                                                                    <span
                                                                        class="badge bg-success">{{ $role->name }}</span>
                                                                @else
                                                                    <span class="badge bg-info">{{ $role->name }}</span>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Data from backend
        const pieChartData = {!! $pieChartData !!};
        const barChartData = {!! $barChartData !!};
        const weekLabels = {!! $weekLabels !!};
        const lokasiChartData = {!! $lokasiChartData !!};
        const typePengirimChartData = {!! $typePengirimChart !!};

        // Common options for Donut charts
        const donutOptions = {
            chart: {
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    donut: {
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
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: '100%'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        // Status Tiket Chart (Donut)
        if (document.querySelector('#pieChart') && pieChartData) {
            new ApexCharts(document.querySelector('#pieChart'), {
                ...donutOptions,
                series: pieChartData.map(d => d.y),
                labels: pieChartData.map(d => d.name),
                colors: ['#ffc107', '#17a2b8', '#28a745'], // warning, info, success
                chart: {
                    ...donutOptions.chart,
                    height: 300 // as per original style
                }
            }).render();
        }

        // Tiket per Lokasi Chart (Donut)
        if (document.querySelector('#lokasiChart') && lokasiChartData) {
            new ApexCharts(document.querySelector('#lokasiChart'), {
                ...donutOptions,
                series: lokasiChartData.map(d => d.y),
                labels: lokasiChartData.map(d => d.name),
                chart: {
                    ...donutOptions.chart,
                    height: 500 // as per original style
                },
            }).render();
        }

        // Statistik Pengirim Chart (Donut)
        if (document.querySelector('#pengirimPieChart') && typePengirimChartData) {
            new ApexCharts(document.querySelector('#pengirimPieChart'), {
                ...donutOptions,
                series: typePengirimChartData.map(d => d.y),
                labels: typePengirimChartData.map(d => d.name),
                colors: ['#ffa707', '#63a2b8'],
                chart: {
                    ...donutOptions.chart,
                    height: 300 // as per original style
                }
            }).render();
        }

        // Tiket per Minggu (Lokasi) Chart (Bar)
        if (document.querySelector('#barChartMingguan') && barChartData && barChartData.length > 0) {
            console.log('Bar Chart Data:', barChartData);
            console.log('Week Labels:', weekLabels);

            new ApexCharts(document.querySelector('#barChartMingguan'), {
                series: barChartData,
                chart: {
                    type: 'bar',
                    height: 600,
                    toolbar: {
                        show: true
                    },
                    stacked: true
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '70%',
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: weekLabels ? weekLabels.map(week => 'Minggu ke-' + week) : [],
                    title: {
                        text: 'Data mingguan'
                    }
                },
                yaxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Tiket'
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'center'
                },
                colors: ['#696cff', '#71dd37', '#ffab00', '#ff3e1d', '#8592a3', '#ffc107', '#17a2b8', '#28a745'],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " tiket"
                        }
                    }
                }
            }).render();
        }
    </script>
@endpush
