@extends('dashboard.layout')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Tiket</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Judul Kendala</th>
                                <th>Lokasi Kendala</th>
                                <th>Humas</th>
                                <th>PIC</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($item->status == 'New')
                                            <button class="btn btn-info">Baru</button>
                                        @elseif ($item->status == 'Selesai')
                                            <button class="btn btn-success">Selesai</button>
                                        @else
                                            <button class="btn btn-warning">Proses</button>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->departemen ?? '-' }}</td>
                                    <td>{{ $item->judul_kendala }}</td>
                                    <td>{{ $item->lokasi_kendala }}</td>


                                    <td>{{ $item->humas->name ?? '-' }}</td>
                                    <td>{{ $item->pic->name ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('dashboard.aqr.tiket.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary mx-1" style="width: 100px;">
                                                <i class="fa fa-edit"></i>Edit
                                            </a>
                                            <form action="{{ route('dashboard.aqr.tiket.destroy', $item->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger mx-1"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                    style="width: 100px;"> <i class="fa fa-trash"></i> Hapus</button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                },
                "pageLength": 10,
            });
        });
    </script>
@endpush
