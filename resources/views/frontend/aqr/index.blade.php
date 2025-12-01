@extends('helpdesk.home.layout')
@section('content')
    <div class="row d-flex justify-content-center align-items-center h-100">

        <div class="col-10 col-md-10 col-lg-4 col-xl-4">

            <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="mb-2 mt-3">
                    <div class="container text-center">
                        <h5>Avicenna Quick Response</h5>
                        <h6>Kritik dan Saran</h6>

                    </div>
                </div>
                <p align="center">
                    <img src="image/avicenna-helpdesk.png" style="max-width: 90%">
                </p>
                <div class="card-body text-center">

                    <div class="d-grid">
                        <a href="{{route('helpdesk.home.open-tiket')}}" class="btn btn-primary d-block mb-3">Isi Kritik dan Saran</a>
                        <a href="{{route('helpdesk.home.tiket-tracking')}}" class="btn btn-dark d-block mb-3">
                            Cek Proses
                        </a>
                    </div>

                </div>


            </div>

        </div>

    </div>
@endsection

@push('script')

@endpush
