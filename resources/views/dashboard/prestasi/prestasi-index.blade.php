@extends('dashboard.layout')
@section('content')
    <div class="container my-3">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sekolah Jagakarsa</h5>
                        <ul class="p-0 m-0">
                            <!-- Daftar Prestasi -->
                            <ul class="p-0 m-0">

                                <!-- Prestasi Terkurasi -->
                                <li class="d-flex mb-4 pb-1">

                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-success fw-semibold d-block mb-1">
                                                Prestasi Terkurasi
                                            </small>
                                            <h6 class="mb-0">Juara 1 Lomba Karya Ilmiah Nasional</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-success">+100</h6>
                                            <span class="text-muted">Poin</span>
                                        </div>
                                    </div>
                                </li>

                                <li class="d-flex mb-4 pb-1">

                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-success fw-semibold d-block mb-1">
                                                Prestasi Terkurasi
                                            </small>
                                            <h6 class="mb-0">Finalis Olimpiade Sains Nasional</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-success">+85</h6>
                                            <span class="text-muted">Poin</span>
                                        </div>
                                    </div>
                                </li>

                                <!-- Prestasi Tidak Terkurasi -->
                                <li class="d-flex mb-4 pb-1">

                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                                Prestasi Tidak Terkurasi
                                            </small>
                                            <h6 class="mb-0">Peserta Lomba Desain Poster Sekolah</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-warning">+30</h6>
                                            <span class="text-muted">Poin</span>
                                        </div>
                                    </div>
                                </li>

                                <li class="d-flex mb-4 pb-1">

                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                                Prestasi Tidak Terkurasi
                                            </small>
                                            <h6 class="mb-0">Peserta Seminar Literasi Digital</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-warning">+10</h6>
                                            <span class="text-muted">Poin</span>
                                        </div>
                                    </div>
                                </li>

                                <li class="d-flex">

                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                                Prestasi Tidak Terkurasi
                                            </small>
                                            <h6 class="mb-0">Kontributor Ide Kreatif Sekolah</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-warning">+15</h6>
                                            <span class="text-muted">Poin</span>
                                        </div>
                                    </div>
                                </li>

                            </ul>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sekolah Cinere</h5>
                        <ul class="p-0 m-0">

                            <!-- Prestasi Terkurasi -->
                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-success fw-semibold d-block mb-1">
                                            Prestasi Terkurasi
                                        </small>
                                        <h6 class="mb-0">Juara 1 Lomba Karya Ilmiah Nasional</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">+100</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-success fw-semibold d-block mb-1">
                                            Prestasi Terkurasi
                                        </small>
                                        <h6 class="mb-0">Finalis Olimpiade Sains Nasional</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">+85</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                            <!-- Prestasi Tidak Terkurasi -->
                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                            Prestasi Tidak Terkurasi
                                        </small>
                                        <h6 class="mb-0">Peserta Lomba Desain Poster Sekolah</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">+30</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                            Prestasi Tidak Terkurasi
                                        </small>
                                        <h6 class="mb-0">Peserta Seminar Literasi Digital</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">+10</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                            <li class="d-flex">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                            Prestasi Tidak Terkurasi
                                        </small>
                                        <h6 class="mb-0">Kontributor Ide Kreatif Sekolah</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">+15</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sekolah Pamulang</h5>
                        <ul class="p-0 m-0">

                            <!-- Prestasi Terkurasi -->
                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-success fw-semibold d-block mb-1">
                                            Prestasi Terkurasi
                                        </small>
                                        <h6 class="mb-0">Juara 1 Lomba Karya Ilmiah Nasional</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">+100</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-success fw-semibold d-block mb-1">
                                            Prestasi Terkurasi
                                        </small>
                                        <h6 class="mb-0">Finalis Olimpiade Sains Nasional</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">+85</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                            <!-- Prestasi Tidak Terkurasi -->
                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                            Prestasi Tidak Terkurasi
                                        </small>
                                        <h6 class="mb-0">Peserta Lomba Desain Poster Sekolah</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">+30</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                            Prestasi Tidak Terkurasi
                                        </small>
                                        <h6 class="mb-0">Peserta Seminar Literasi Digital</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">+10</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                            <li class="d-flex">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                            Prestasi Tidak Terkurasi
                                        </small>
                                        <h6 class="mb-0">Kontributor Ide Kreatif Sekolah</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">+15</h6>
                                        <span class="text-muted">Poin</span>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
