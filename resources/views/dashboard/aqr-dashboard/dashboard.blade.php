@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Aduan</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->

            @role('Admin')
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Tiket Baru</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tiketNew }}</div>
                                </div>
                                <div class="card-action  red darken-2">
                                    <div id="clients-bar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Ticket Dalam Proses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tiketProses }}</div>
                            </div>
                            <div class="card-action green darken-2">
                                <div id="sales-compositebar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ticket Selesai
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tiketClosed }}</div>
                            </div>
                            <div class="card-action blue darken-2">
                                <div id="profit-tristate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Tiket Masuk
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTiket }}</div>
                            </div>
                            <div class="card-action deep-purple darken-2">
                                <div id="bar-chart-sample"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            {{-- Baru --}}

            @role('Admin')
                <div class="col">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-dark">Tiket Baru</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            @foreach ($latestTiket as $item)
                                <div class="card mb-3 shadow">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">{{ $item->nama }}</strong>
                                        <span
                                            class="badge badge-{{ $item->pengirim == 'Warga Sekolah' ? 'success' : 'primary' }}">{{ $item->pengirim }}</span>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <th width="30%"><strong>Pengirim</strong></th>
                                                <td><span
                                                        class="badge badge-{{ $item->pengirim == 'Warga Sekolah' ? 'success' : 'primary' }}">{{ $item->pengirim }}</span>
                                                </td>
                                            </tr>
                                            @if ($item->nisn)
                                                <tr>
                                                    <th><strong>NISN</strong></th>
                                                    <td><strong>{{ $item->nisn }}</strong></td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th><strong>Departemen</strong></th>
                                                <td>{{ $item->departemen ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th><strong>Detail kendala</strong></th>
                                                <td>{{ $item->detail_kendala }}</td>
                                            </tr>
                                            @if ($item->lokasi_kendala)
                                                <tr>
                                                    <th><strong>Lokasi Kendala</strong></th>
                                                    <td><strong>{{ $item->lokasi_kendala }}</strong></td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th><strong>Waktu</strong></th>
                                                <td><strong>{{ $item->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') }}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="d-grid mt-3">
                                            <a href="{{ route('dashboard.aqr.tiket.edit', $item->id) }}" class="btn btn-info btn-block">Lihat
                                                Aduan</a>
                                            @if ($item->filename == null)
                                                <button class="btn btn-dark btn-block disabled">Tidak ada lampiran</button>
                                            @else
                                                <a href="{{ asset($item->filename) }}"data-toggle="tooltip" title="Edit"
                                                    class="btn btn-primary btn-block {{ $item->filename = !null ? '' : 'disabled' }}">
                                                    <i class="fas fa-image"></i>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                {{-- <hr style="height:3px;border-width:0;color:gray;background-color:gray"> --}}
                            @endforeach
                        </div>
                    </div>
                </div>
            @endrole
            {{-- Proses --}}
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-dark">Tiket Dalam Proses</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        @foreach ($latestProses as $item)
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <strong class="text-dark">{{ $item->nama }}</strong>
                                    <span
                                        class="badge badge-{{ $item->pengirim == 'Warga Sekolah' ? 'success' : 'primary' }}">{{ $item->pengirim }}</span>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="30%"><strong>Pengirim</strong></th>
                                            <td><span
                                                    class="badge badge-{{ $item->pengirim == 'Warga Sekolah' ? 'success' : 'primary' }}">{{ $item->pengirim }}</span>
                                            </td>
                                        </tr>
                                        @if ($item->nisn)
                                            <tr>
                                                <th><strong>NISN</strong></th>
                                                <td><strong>{{ $item->nisn }}</strong></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th><strong>Humas</strong></th>
                                            <td><strong>{{ $item->humas->name ?? '-' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th><strong>PIC</strong></th>
                                            <td><strong>{{ $item->pic->name ?? '-' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th><strong>Departemen</strong></th>
                                            <td>{{ $item->departemen ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th><strong>Detail kendala</strong></th>
                                            <td>{{ $item->detail_kendala }}</td>
                                        </tr>
                                        @if ($item->lokasi_kendala)
                                            <tr>
                                                <th><strong>Lokasi Kendala</strong></th>
                                                <td><strong>{{ $item->lokasi_kendala }}</strong></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th><strong>Waktu</strong></th>
                                            <td><strong>{{ $item->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><strong>Waktu Proses</strong></th>
                                            <td>
                                                @if ($item->waktu_proses != null)
                                                    <strong>{{ Carbon\Carbon::parse($item->waktu_proses)->isoFormat('D MMMM YYYY, HH:mm:ss') }}</strong>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="d-grid mt-3">
                                        <a href="{{ route('dashboard.aqr.tiket.edit', $item->id) }}"
                                            class="btn btn-info btn-block">Lihat
                                            Aduan</a>
                                        @if ($item->filename == null)
                                            <button class="btn btn-dark btn-block disabled">Tidak ada lampiran</button>
                                        @else
                                            <a href="{{ asset($item->filename) }}"data-toggle="tooltip" title="Edit"
                                                class="btn btn-primary btn-block {{ $item->filename = !null ? '' : 'disabled' }}">
                                                <i class="fas fa-image"></i>
                                            </a>
                                        @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{-- <hr style="height:3px;border-width:0;color:gray;background-color:gray"> --}}
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Selesai --}}
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-dark">Tiket Selesai</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">

                        @foreach ($latestSelesai as $item)
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <strong class="text-dark">{{ $item->nama }}</strong>
                                    <span
                                        class="badge badge-{{ $item->pengirim == 'Warga Sekolah' ? 'success' : 'primary' }}">{{ $item->pengirim }}</span>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="30%"><strong>Pengirim</strong></th>
                                            <td><span
                                                    class="badge badge-{{ $item->pengirim == 'Warga Sekolah' ? 'success' : 'primary' }}">{{ $item->pengirim }}</span>
                                            </td>
                                        </tr>
                                        @if ($item->nisn)
                                            <tr>
                                                <th><strong>NISN</strong></th>
                                                <td><strong>{{ $item->nisn }}</strong></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th><strong>Departemen</strong></th>
                                            <td>{{ $item->departemen ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th><strong>Detail kendala</strong></th>
                                            <td>{{ $item->detail_kendala }}</td>
                                        </tr>
                                        @if ($item->lokasi_kendala)
                                            <tr>
                                                <th><strong>Lokasi Kendala</strong></th>
                                                <td><strong>{{ $item->lokasi_kendala }}</strong></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th><strong>Waktu</strong></th>
                                            <td><strong>{{ $item->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><strong>Waktu Proses</strong></th>
                                            <td>
                                                @if ($item->waktu_proses != null)
                                                    <strong>{{ Carbon\Carbon::parse($item->waktu_proses)->isoFormat('D MMMM YYYY, HH:mm:ss') }}</strong>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><strong>Waktu Selesai</strong></th>
                                            <td>
                                                @if ($item->waktu_close != null)
                                                    <strong>{{ Carbon\Carbon::parse($item->waktu_close)->isoFormat('D MMMM YYYY, HH:mm:ss') }}</strong>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($item->kepuasan)
                                            <tr>
                                                <th><strong>Kepuasan</strong></th>
                                                <td><span
                                                        class="badge badge-{{ $item->kepuasan == 'Puas' ? 'success' : 'warning' }}">{{ $item->kepuasan }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>

                                    <div class="d-grid mt-3">
                                        <a href="{{ route('dashboard.aqr.tiket.edit', $item->id) }}"
                                            class="btn btn-info btn-block">Lihat Aduan</a>
                                        @if ($item->filename == null)
                                            <button class="btn btn-dark btn-block disabled">Tidak ada lampiran</button>
                                        @else
                                            <a href="{{ asset($item->filename) }}"data-toggle="tooltip" title="Edit"
                                                class="btn btn-primary btn-block {{ $item->filename = !null ? '' : 'disabled' }}">
                                                <i class="fas fa-image"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
