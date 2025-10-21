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
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" id="btnModalWig" type="button" data-bs-toggle="modal"
                                data-bs-target="#wigProgressModal">Tambah Progress WIG</button>

                        </div>
                        <div id="chart" class="mt-3"></div>

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
                        <div class="d-flex justify-content-between mb-4">
                            <div class="">
                                <h5 class="card-title">{{ $lm->judul_lead }}</h5>
                                <p class="card-text">{{ $lm->deskripsi_lead }}</p>
                            </div>
                            <div class="">
                                <h3>{{ count($data_lm) }}</h3>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <th class="text-center text-uppercase text-white">Lead Measure</th>
                                        @foreach ($data_lm[$lm->id] ?? [] as $bulan => $items)
                                            <th colspan="1" class="text-center text-uppercase text-white">
                                                {{ $bulan }}</th>
                                        @endforeach
                                    </tr>
                                    <tr class="bg-dark text-white">
                                        {{-- <tr>Lead Measure</tr> --}}
                                        {{-- @foreach ($data_lm[$lm->id] ?? [] as $bulan => $items)
                                            <th class="text-white">Task (%)</th>
                                            <th class="text-white">RINCIAN TUGAS</th>

                                        @endforeach --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center fw-bold"> Done/Total</td>
                                        @foreach ($data_lm[$lm->id] ?? [] as $bulan => $items)
                                            <td>
                                                <h6 class="text-dark text-center">

                                                    @php
                                                        $done = $items->where('status_tugas', 1)->count();
                                                        $total = $items->count();
                                                        echo $done . '/' . $total;
                                                    @endphp


                                                </h6>
                                                <div class="d-flex gap-2">
                                                    <!-- Button triggers -->
                                                    <button data-lm="{{ $lm->id }}" data-bulan="{{ $bulan }}"
                                                        id="btnViewTask{{ $lm->id }}}}" data-bs-target="#taskModal"
                                                        data-bs-toggle="modal"
                                                        class="btn btn-warning">Task</button>
                                                    {{-- <button data-lm="{{ $lm->id }}" data-bulan="{{ $bulan }}"
                                                        id="btnViewTask" class="btn btn-primary">View</button> --}}










                                                </div>
                                            </td>
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



    <!-- Modal trigger button -->


    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="wigProgressModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Tambah Progress WIG
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form
                        action="{{ route('departement.wig.progress-wig.store', ['departement' => $wig->departement_id, 'wig' => $wig->id]) }}"
                        method="POST">
                        @csrf

                        <input type="hidden" name="wig_id" value="{{ $wig->id }}" id="wig_id">
                        <div class="form-group mb-3">
                            <label for="">Progres WIG</label>
                            <input type="number" name="progress_wig" id="progress_wig" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Bulan</label>
                            <select name="bulan_wig" id="bulan_wig" class="form-control">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="button" class="btn btn-primary" id="btnSimpanWig">Simpan</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalTitle">Task Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">

                    <div class="accordion" id="taskAccordion">
                        <!-- Form Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="formHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#formCollapse" aria-expanded="false" aria-controls="formCollapse">
                                    Add New Task
                                </button>
                            </h2>
                            <div id="formCollapse" class="accordion-collapse collapse" aria-labelledby="formHeading"
                                data-bs-parent="#taskAccordion">
                                <div class="accordion-body">
                                    <form id="taskForm">
                                        <div class="mb-3">
                                            <label for="taskName" class="form-label">Task
                                                Name</label>
                                            <input type="text" class="form-control" id="taskName" name="taskName"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="taskDescription" class="form-label">Description</label>
                                            <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="taskDeadline" class="form-label">Deadline</label>
                                            <input type="date" class="form-control" id="taskDeadline"
                                                name="taskDeadline" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="taskPriority" class="form-label">Priority</label>
                                            <select class="form-select" id="taskPriority" name="taskPriority">
                                                <option value="low">Low
                                                </option>
                                                <option value="medium">
                                                    Medium</option>
                                                <option value="high">High
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="taskStatus" class="form-label">Status</label>
                                            <select class="form-select" id="taskStatus" name="taskStatus">
                                                <option value="0">Not
                                                    Started</option>
                                                <option value="1">In
                                                    Progress</option>
                                                <option value="2">
                                                    Completed</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add
                                            Task</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Table Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="tableHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#tableCollapse" aria-expanded="true" aria-controls="tableCollapse">
                                    Task List
                                </button>
                            </h2>
                            <div id="tableCollapse" class="accordion-collapse collapse show"
                                aria-labelledby="tableHeading" data-bs-parent="#taskAccordion">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Checklist</th>
                                                    <th>Task Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="taskTableBody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->

    <!-- Optional: Place to the bottom of scripts -->
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script src="{{ asset('dashboard-admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Task button click handler

            // View button click handler
            $(document).on('click', '#btnViewTask', function() {
                const id = $(this).data('lm');
                const bulan = $(this).data('bulan');
                // $('#viewModal').modal('show');
                $.ajax({
                    type: "post",
                    url: "{{ route('getLmTasks', ['id' => ':id', 'bulan' => ':bulan']) }}".replace(':id', id).replace(':bulan', bulan),
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {

                    }
                });
                // Add AJAX call here to load view data
            });
        });

        $('#btnSimpanWig').click(function(e) {
            e.preventDefault();

            url =
                "{{ route('departement.wig.progress-wig.store', ['departement' => $wig->departement_id, 'wig' => $wig->id]) }}";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    wig_id: $('#wig_id').val(),
                    progress_wig: $('#progress_wig').val(),
                    bulan_wig: $('#bulan_wig').val(),
                },
                dataType: "json",
                success: function(response) {
                    $('#wigProgressModal').modal('hide');

                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto'); // pastikan body bisa diklik/scroll
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Progress WIG berhasil ditambahkan',
                        timer: 1500
                    });
                    loadChartData();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menambahkan progress WIG'
                    });
                }
            });

        });

        let chart;

        function initChart(data) {
            const progressData = Object.values(data).map(item => item.progress);
            const bulanData = Object.values(data).map(item => item.bulan);

            const options = {
                series: [{
                    name: 'Progress',
                    data: progressData
                }],
                chart: {
                    type: 'bar',
                    height: 500,
                    toolbar: {
                        show: true
                    },
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
                    enabled: true,
                    style: {
                        colors: ['#fff']
                    }
                },
                title: {
                    text: 'Progress WIG',
                    align: 'center'
                },
                xaxis: {
                    categories: bulanData,
                    labels: {
                        style: {
                            colors: '#333',
                            fontSize: '14px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah'
                    },
                    labels: {
                        formatter: function(val) {
                            return val;
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
                            return val;
                        }
                    }
                }
            };

            chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        }

        function updateChart(data) {
            const progressData = Object.values(data).map(item => item.progress);
            const bulanData = Object.values(data).map(item => item.bulan);

            chart.updateOptions({
                series: [{
                    name: 'Progress',
                    data: progressData
                }],
                xaxis: {
                    categories: bulanData
                }
            });
        }

        function loadChartData() {
            $.ajax({
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                dataType: "json",
                url: "{{ route('wig.chart', $wig->id) }}",
                success: function(response) {
                    if (chart) {
                        updateChart(response.chartWig);
                    } else {
                        initChart(response.chartWig);
                    }
                }
            });
        }

        // Initialize chart on page load
        $(document).ready(function() {
            const initialData = @json($chartWig);
            initChart(initialData);
        });
    </script>
@endpush