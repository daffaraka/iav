@extends('dashboard.layout')
@section('content')
    <div class="container my-3">

        <div class="card mb-3">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title fw-bold text-uppercase mb-0">{{ $title }}</h2>

                    <a class="btn btn-primary" data-bs-toggle="modal" href="#tambahWigModal" role="button">Tambah WIG
                        Baru</a>


                    <div class="modal fade" id="tambahWigModal" aria-hidden="true" aria-labelledby="tambahWigModalLabel"
                        tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalToggleLabel">
                                        Tambah WIG Baru
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <hr class="my-1">
                                <div class="modal-body mt-0 pt-0 pb-3">
                                    <form method="POST" id="formWig">
                                        @csrf
                                        <input type="hidden" name="departement_id" value="{{ $departement->id }}">
                                        <div class="form-group my-3">
                                            <label class="fw-bold"for="">Nama WIG</label>
                                            <input required type="text" name="nama_wig" id=""
                                                value="{{ old('nama_wig') }}"
                                                class="form-control @error('nama_wig') is-invalid @enderror">
                                            @error('nama_wig')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group my-3">
                                            <label class="fw-bold"for="">Deskripsi WIG</label>
                                            <textarea name="deskripsi_wig" class="form-control @error('deskripsi_wig') is-invalid @enderror" rows="3">{{ old('deskripsi_wig') }}</textarea>
                                            @error('deskripsi_wig')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group my-3">

                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="fw-bold"for="">Tanggal Mulai</label>
                                                    <input required type="date" name="tanggal_mulai_wig"
                                                        value="{{ old('tanggal_mulai_wig') }}"
                                                        class="form-control @error('tanggal_mulai_wig') is-invalid @enderror">
                                                    @error('tanggal_mulai_wig')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-6">
                                                    <label class="fw-bold"for="">Tanggal Berakhir</label>
                                                    <input required type="date" name="tanggal_berakhir_wig"
                                                        value="{{ old('tanggal_berakhir_wig') }}"
                                                        class="form-control @error('tanggal_berakhir_wig') is-invalid @enderror">
                                                    @error('tanggal_berakhir_wig')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>



                                        </div>

                                        <div class="form-group my-3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="fw-bold"for="">From X (Angka)</label>
                                                    <input type="number" class="form-control" name="from_x"
                                                        value="{{ old('from_x') }}">
                                                    @error('nama_wig')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-6">
                                                    <label class="fw-bold"for="">To Y (Angka)</label>
                                                    <input type="number" class="form-control" name="to_y"
                                                        value="{{ old('to_y') }}">
                                                    @error('to_y')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                        </div>


                                        <div class="form-group my-3">
                                            <label class="fw-bold"for="">Satuan</label>
                                            <select name="satuan" id="" class="form-control">
                                                <option value="%"> Persen (%)</option>
                                                <option value="Angka"> Unit </option>


                                            </select>
                                            @error('unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="button" id="submitWig" class="btn btn-primary">Simpan</button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>



                    {{-- <a href="" class="btn btn-info">Tambah WIG</a> --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Total</h5>
                        <p class="card-text h2">{{ $wig_total }}</p>
                        {{-- <a href="#" class="btn btn-primary">Lihat Detail</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Aktif</h5>
                        <p class="card-text h2">{{ $wig_aktif }}</p>
                        {{-- <a href="#" class="btn btn-light">Lihat Detail</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Selesai</h5>
                        <p class="card-text h2">{{ $wig_selesai }}</p>
                        {{-- <a href="#" class="btn btn-light">Lihat Detail</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-danger ">
                    <div class="card-body">
                        <h5 class="card-title">Tidak Aktif</h5>
                        <p class="card-text h2">{{ $wig_tidak_aktif }}</p>
                        {{-- <a href="#" class="btn btn-light">Lihat Detail</a> --}}
                    </div>
                </div>
            </div>
        </div>


        <div class="row my-3">
            @foreach ($departement->wigs as $wig)
                <div class="col-8 mb-3">
                    <div class="card shadow-md border">
                        <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <small class="text-success fw-semibold d-block mb-1">
                                        {{ $wig->judul_wig }}
                                        <h6 class="mb-0">{{ $wig->deskripsi_wig }}</h6>

                                    </small>
                                </div>
                                <div class="">

                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">

                                            <div class="demo-inline-spacing">
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item fw-bold"
                                                                href="{{ route('dept.edit.wig', [$departement->id, $wig->id]) }}">
                                                                <i class="bi bi-pencil-square"></i> Edit WIG
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item fw-bold"
                                                                href="{{ route('dept.show.wig', [$departement->id, $wig->id]) }}">
                                                                <i class="bi bi-eye"></i> Lihat Lead Measures
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('wig.destroy', $wig->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="dropdown-item text-danger fw-bold"
                                                                    id="deleteWig" data-id="{{ $wig->id }}">
                                                                    <i class="bi bi-trash"></i> Hapus WIG
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                    </div>


                                </div>
                            </div>






                            <div id="chart_{{ $wig->id }}" class="mt-3"></div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <small class="text-success fw-semibold d-block mb-1">
                                Deskripsi WIG
                            </small>
                            <h6 class="mb-0">{{ $wig->deskripsi_wig }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        {{--
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
            </div> --}}
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#submitWig').on('click', function(e) {
                e.preventDefault();

                let formData = $('#formWig').serialize();

                // Hapus error sebelumnya
                $('#formWig').find('.is-invalid').removeClass('is-invalid');
                $('#formWig').find('.invalid-feedback').text('');

                $.ajax({
                    url: "{{ route('wig.storeByDept') }}",
                    type: "post",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'WIG berhasil ditambahkan',
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            didOpen: () => {
                                $('.swal2-container').css('z-index', 20000);
                            }
                        }).then((result) => {
                            $('#wigProgressModal').modal('hide');

                            // 🧹 Bersihkan backdrop putih & restore klik body
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                            $('body').css('overflow', 'auto');

                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan validasi';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            title: 'Error Validasi!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Ok',
                            didOpen: () => {
                                $('.swal2-container').css('z-index', 20000);
                            }

                        });

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
        });


        $(document).ready(function() {
            // Handle delete WIG button click
            $(document).on('click', '#deleteWig', function(e) {
                e.preventDefault();

                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data WIG akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
        $(document).ready(function() {
            // Data dari controller
            const chartsData = @json($chartPerWig);
            const wigIds = @json($departement->wigs->pluck('id'));

            // Loop tiap WIG berdasarkan index dan data
            $.each(chartsData, function(index, data) {
                const wigId = wigIds[index];
                const chartEl = $(`#chart_${wigId}`)[0]; // ambil elemen DOM (bukan jQuery object)

                if (!chartEl) return; // skip jika elemen tidak ada

                const progressData = $.map(data, function(item) {
                    return item.progress;
                });
                const bulanData = $.map(data, function(item) {
                    return item.bulan;
                });

                const options = {
                    series: [{
                        name: 'Progress',
                        data: progressData
                    }],
                    chart: {
                        type: 'bar',
                        height: 400,
                        toolbar: {
                            show: true
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

                const chart = new ApexCharts(chartEl, options);
                chart.render();
            });
        });
    </script>
@endpush
