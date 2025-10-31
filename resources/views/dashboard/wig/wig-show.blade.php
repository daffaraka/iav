@extends('dashboard.layout')
@section('content')
    <div class="container-xxl flex-grow-1 ">
        <div class="row">


            <div class="card-body p-3">

                <div class="table-responsive ">
                    <table class="table table-light table-striped dataTable w-100 table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Progress WIG</th>
                                <th>Bulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wig->wig_progresses as $progress)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $progress->progress_wig }}</td>
                                    <td>{{ match ($progress->bulan) {
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember',
                                        default => '',
                                    } }}
                                    </td>
                            @endforeach

                        </tbody>

                    </table>
                </div>




            </div>


        </div>

    </div>
@endsection
@push('scripts')

@endpush
