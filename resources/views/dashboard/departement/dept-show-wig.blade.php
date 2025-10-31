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
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('wig.show', $wig->id) }}" class="btn btn-outline-dark"><i
                                    class="bx  bx-list-ul"></i> Riwayat Progress
                                WIG</a>
                            <button class="btn btn-primary" id="btnModalWig" type="button" data-bs-toggle="modal"
                                data-bs-target="#wigProgressModal"><i class="bx bx-plus-circle"></i> Tambah Progress
                                WIG</button>
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


        <div class="col-12 my-3">
            <a href="{{ route('wig.lead-measure.create', $wig->id) }}" class="btn btn-dark">Tambah Lead Measure Baru</a>
        </div>

        @foreach ($wig->lead_measures as $lm)
            <div class="col-12 mb-3">
                <div class="card shadow border border-secondary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="">
                                <h4 class="card-title fw-bold">{{ $lm->judul_lead }}</h4>
                                <p class="card-text">{{ $lm->deskripsi_lead }}</p>
                            </div>
                            <div class="">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addNewTaskModal"
                                    data-id="{{ $lm->id }}"
                                    class="addNewTaskButton btn btn-info  border-1 border-dark shadow">Tambah
                                    Task Baru</button>
                                {{-- <h3>{{ count($data_lm) }}</h3> --}}
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
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Button triggers -->
                                                    <button data-lm="{{ $lm->id }}" data-bulan="{{ $bulan }}"
                                                        data-bs-target="#taskModal" data-bs-toggle="modal"
                                                        class="btnViewTask btn btn-warning">Task</button>


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


    <!-- Progress WIG Modal -->

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
                    <button type="button" class="btn btn-primary" id="btnSimpanProgressWig">Simpan</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Task Detail Modal -->
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
                        <div class="accordion-item border my-2">
                            <h2 class="accordion-header " id="formHeading">
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
                        <div class="accordion-item  border my-2">
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
                                                    <th class="w-20">#</th>
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

    {{-- New Task Modal --}}
    <div class="modal fade" id="addNewTaskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewTaskModalTitle">Tambah Task Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                    <form method="POST" id="newTaskForm" enctype="multipart/form-data">
                        @csrf

                        <input type="text" name="lm_id" id="lm_id" value="" hidden>
                        <div class="mb-3">
                            <label for="nama_tugas" class="form-label">Nama Tugas/Task</label>
                            <input type="text" class="form-control @error('nama_tugas') is-invalid @enderror"
                                id="nama_tugas" name="nama_tugas" value="{{ old('nama_tugas') }}" required>
                            @error('nama_tugas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_realisasi" class="form-label">Jumlah Realisasi</label>
                            <input type="number" class="form-control @error('jumlah_realisasi') is-invalid @enderror"
                                id="jumlah_realisasi" name="jumlah_realisasi" value="{{ old('jumlah_realisasi') }}">
                            @error('jumlah_realisasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label for="dokumen" class="form-label">Dokumen</label>
                            <input type="file" class="form-control @error('dokumen') is-invalid @enderror"
                                id="dokumen" name="dokumen">
                            @error('dokumen')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}

                        <div class="mb-3">
                            <label for="tanggal_realisasi" class="form-label">Tanggal Realisasi</label>
                            <input type="date" class="form-control @error('tanggal_realisasi') is-invalid @enderror"
                                id="tanggal_realisasi" name="tanggal_realisasi" value="{{ old('tanggal_realisasi') }}"
                                required>
                            @error('tanggal_realisasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_tugas" class="form-label">Status Tugas</label>
                            <select class="form-select @error('status_tugas') is-invalid @enderror" id="status_tugas"
                                name="status_tugas">
                                <option value="">Pilih Status</option>
                                <option value="0" {{ old('status_tugas') == '0' ? 'selected' : '' }}>Belum Selesai
                                </option>
                                <option value="1" {{ old('status_tugas') == '1' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status_tugas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        <div class="modal-footer d-flex justify-content-between p-0 mx-0 mb-3">
                            <button type="submit" class="btnSubmitNewTask btn btn-primary">Submit</button>

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
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






            // Inisialisasi chart WIG
            const initialData = @json($chartWig);
            initChart(initialData);




            // Button lihat Task
            $(document).on('click', '.btnViewTask', function() {
                const id = $(this).data('lm');
                const bulan = $(this).data('bulan');
                // $('#viewModal').modal('show');
                $.ajax({
                    type: "post",
                    url: "{{ route('getLmTasks', ':id') }}".replace(':id', id),
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        id: id,
                    },
                    success: function(response) {
                        // console.log(response);
                        $('#taskTableBody').html('');
                        $.each(response, function(index, task) {
                            $('#taskTableBody').append(`
                                <tr class="${task.status_tugas == 1 ? 'bg-success' : 'bg-secondary text-dark'}" >
                                    <td>
                                        <input type="checkbox" class="task-checkbox" name="tasks" data-id="${task.id}" ${task.status_tugas == 1 ? 'checked' : ''}>
                                    </td>
                                    <td>${task.nama_tugas}</td>
                                    <td>${task.status_tugas == 1 ? 'Selesai' : 'Belum Selesai'}</td>
                                    <td>${task.tanggal_realisasi}</td>

                                    </tr>
                                </tr>
                            `);
                        });
                    }
                });

            });


            // Button Tambah Task Baru yang WARNA BIRU
            $('.addNewTaskButton').click(function(e) {
                id = $(this).data('id');
                e.preventDefault();


                $.ajax({
                    type: "post",
                    url: "{{ route('getLm', ':id') }}".replace(':id'),
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#addNewTaskModalTitle').text('Tambah Task Baru Untuk ' +
                            response.judul_lead);
                        $('#lm_id').val(response.id);

                        console.log(response);
                    }
                });
            });

            // Button Submit Task Baru via addNewTaskButton yang WARNA BIRU
            $('.btnSubmitNewTask').click(function(e) {
                e.preventDefault();


                // dokumen: $('#dokumen')[0].files[0],

                $.ajax({
                    type: "POST",
                    url: "{{ route('addNewTask', ':id') }}".replace(':id', id),
                    data: {
                        _token: "{{ csrf_token() }}",
                        lm_id: $('#lm_id').val(),
                        nama_tugas: $('#nama_tugas').val(),
                        deskripsi: $('#deskripsi').val(),
                        jumlah_realisasi: $('#jumlah_realisasi').val(),
                        tanggal_realisasi: $('#tanggal_realisasi').val(),
                        status_tugas: $('#status_tugas').val()
                    },
                    processData: true,
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Tugas berhasil ditambahkan',
                            timer: 1500,
                            showConfirmButton: false,
                            didOpen: () => {
                                $('.swal2-container').css('z-index', 20000);
                            }
                        });
                        $('#addNewTaskModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('overflow', 'auto');
                        // Reload lead measure cards
                        setTimeout(() => {
                            loadLeadMeasureCards();
                        }, 1500);
                    },
                    error: function(xhr) {

                        let errorMessage = 'Terjadi kesalahan validasi';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMessage,
                            customClass: {
                                container: 'swal2-top-modal'
                            },
                            didOpen: () => {
                                $('.swal2-container').css('z-index', 20000);
                            }
                        });

                        // Tampilkan error validasi (jika ada)
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $(`[name="${key}"]`).addClass('is-invalid');
                                $(`[name="${key}"]`).next('.invalid-feedback').text(
                                    value[0]);
                            });
                        }
                    }
                });
            });


            // Save Task dari toggle checklist
            $(document).on('change', '.task-checkbox', function() {
                const taskId = $(this).data('id');
                const status = $(this).is(':checked') ? 1 : 0; // 1 = selesai, 0 = belum

                $.ajax({
                    url: "{{ route('tasks.toggleStatus') }}", // ubah sesuai route kamu
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: taskId,
                        status_tugas: status
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message ??
                                'Status tugas berhasil diperbarui',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memperbarui status',
                            didOpen: () => {
                                $('.swal2-container').css('z-index', 20000);
                            }
                        });
                        // Balikkan checkbox ke posisi semula
                        $(this).prop('checked', !status);
                    }.bind(this)
                });
            });
        });


        // Simpan Progress WIG
        $('#btnSimpanProgressWig').click(function(e) {
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
                        text: 'Terjadi kesalahan saat menambahkan progress WIG',
                        didOpen: () => {
                            $('.swal2-container').css('z-index', 20000);
                        }
                    });
                }
            });

        });


        // Inisiasi format chart
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

        // Update Chart
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

        // Load Chart
        function loadChartData() {
            $.ajax({
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                dataType: "json",
                url: "{{ route('dept.show.wig', ['departement' => $wig->departement_id, 'wig' => $wig->id])}}",
                success: function(response) {
                    if (chart) {
                        updateChart(response.chartWig);
                    } else {
                        initChart(response.chartWig);
                    }
                }
            });
        }



        function loadLeadMeasureCards() {
            $.ajax({
                type: "GET",
                url: "{{ route('dept.show.wig', ['departement' => $wig->departement_id, 'wig' => $wig->id]) }}",
                success: function(response) {
                    // Extract lead measure cards from response
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');
                    const newCards = doc.querySelectorAll('.col-12.mb-3');

                    // Remove existing lead measure cards
                    $('.col-12.mb-3').each(function() {
                        if ($(this).find('.card.shadow.border.border-secondary').length > 0) {
                            $(this).remove();
                        }
                    });

                    // Add new cards
                    newCards.forEach(card => {
                        if (card.querySelector('.card.shadow.border.border-secondary')) {
                            $('.container.my-3').append(card.outerHTML);
                        }
                    });
                }
            });
        }

    </script>
@endpush
