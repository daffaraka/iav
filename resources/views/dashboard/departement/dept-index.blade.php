@extends('dashboard.layout')
@section('content')
    <div class="container my-3">

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Departemen Tersedia</h5>
                        <div class="d-flex flex-wrap gap-3">

                            <div class="row">
                                @foreach ($departement as $dept)
                                    <div class="col-4 mb-3">
                                        <a href="{{route('departement.show', $dept->id)}}" class="text-white text-decoration-none">
                                            <div class="badge bg-dark p-3 w-100">

                                                <i class="bx bx-group me-1"></i>
                                                 {{ $dept->nama_dept }} <button class="btn btn-warning btn-sm p-1 ms-1">{{$dept->wigs->count()}}</button>

                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Departemen IT</h5>
                        <ul class="p-0 m-0">
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
            </div>



            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Departemen SDM</h5>
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-success fw-semibold d-block mb-1">
                                            WIG Tercapai
                                        </small>
                                        <h6 class="mb-0">Program Pelatihan Guru Berkelanjutan</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">95%</h6>
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
                                        <h6 class="mb-0">Sistem Evaluasi Kinerja Digital</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">80%</h6>
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
                                        <h6 class="mb-0">Employee Engagement Program</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">65%</h6>
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
                                        <h6 class="mb-0">Talent Management System</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-warning">40%</h6>
                                        <span class="text-muted">Progress</span>
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
                        <h5 class="card-title">Departemen RND</h5>
                        <div class="row">
                            <div class="col-12">
                                <ul class="p-0 m-0">
                                    <li class="d-flex mb-4 pb-1">
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-success fw-semibold d-block mb-1">
                                                    WIG Tercapai
                                                </small>
                                                <h6 class="mb-0">Kurikulum Merdeka Implementation</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 text-success">100%</h6>
                                                <span class="text-muted">Progress</span>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="d-flex mb-4 pb-1">
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-success fw-semibold d-block mb-1">
                                                    WIG Tercapai
                                                </small>
                                                <h6 class="mb-0">Modul Pembelajaran Digital</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 text-success">85%</h6>
                                                <span class="text-muted">Progress</span>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="d-flex mb-4 pb-1">
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                                    WIG Dalam Proses
                                                </small>
                                                <h6 class="mb-0">Assessment System Upgrade</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 text-warning">75%</h6>
                                                <span class="text-muted">Progress</span>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="d-flex mb-4 pb-1">
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                                    WIG Dalam Proses
                                                </small>
                                                <h6 class="mb-0">Learning Analytics Platform</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 text-warning">50%</h6>
                                                <span class="text-muted">Progress</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Departemen RND</h5>
                        <div class="row">
                            <div class="col-6">
                                <ul class="p-0 m-0">
                                    <li class="d-flex mb-4 pb-1">
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-success fw-semibold d-block mb-1">
                                                    WIG Tercapai
                                                </small>
                                                <h6 class="mb-0">Kurikulum Merdeka Implementation</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 text-success">100%</h6>
                                                <span class="text-muted">Progress</span>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="d-flex mb-4 pb-1">
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-success fw-semibold d-block mb-1">
                                                    WIG Tercapai
                                                </small>
                                                <h6 class="mb-0">Modul Pembelajaran Digital</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 text-success">85%</h6>
                                                <span class="text-muted">Progress</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="p-0 m-0">
                                    <li class="d-flex mb-4 pb-1">
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                                    WIG Dalam Proses
                                                </small>
                                                <h6 class="mb-0">Assessment System Upgrade</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 text-warning">75%</h6>
                                                <span class="text-muted">Progress</span>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="d-flex mb-4 pb-1">
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-secondary fw-semibold fst-italic d-block mb-1">
                                                    WIG Dalam Proses
                                                </small>
                                                <h6 class="mb-0">Learning Analytics Platform</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 text-warning">50%</h6>
                                                <span class="text-muted">Progress</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
@endsection
