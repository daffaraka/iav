@extends('dashboard.layout')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Tiket</h6>
                <div>

                    @role('super-admin')
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteAllModal">
                            <i class="fa fa-trash"></i> Hapus Semua
                        </button>
                    @endrole

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Pengirim</th>
                                <th>Kategori Masalah</th>
                                <th>Judul Kendala</th>
                                <th>Lokasi Kendala</th>

                                <th>First Gate</th>
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
                                    <td>{{ $item->masalah_dept ?? '-' }}</td>
                                    <td>{{ $item->judul_kendala }}</td>
                                    <td>{{ $item->lokasi_kendala }}</td>


                                    <td>{{ $item->option->kategori_pic ?? '-' }} -
                                        <b>{{ $item->first_pic->name ?? '-' }}</b> </td>
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

    <!-- Delete All Modal -->
    <div class="modal fade" id="deleteAllModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Semua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger"><strong>PERINGATAN!</strong></p>
                    <p>Anda akan menghapus <strong>SEMUA TIKET</strong> yang ada. Tindakan ini tidak dapat dibatalkan.</p>
                    <p>Ketik <strong>"HAPUS SEMUA"</strong> untuk konfirmasi:</p>
                    <input type="text" id="confirmText" class="form-control" placeholder="Ketik: HAPUS SEMUA">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteAllForm" action="{{ route('dashboard.aqr.tiket.deleteAll') }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirmDeleteBtn" class="btn btn-danger" disabled>
                            <i class="fa fa-trash"></i> Hapus Semua Tiket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            // Delete all confirmation
            $('#confirmText').on('input', function() {
                const confirmBtn = $('#confirmDeleteBtn');
                if ($(this).val() === 'HAPUS SEMUA') {
                    confirmBtn.prop('disabled', false);
                } else {
                    confirmBtn.prop('disabled', true);
                }
            });

            // Reset modal when closed
            $('#deleteAllModal').on('hidden.bs.modal', function() {
                $('#confirmText').val('');
                $('#confirmDeleteBtn').prop('disabled', true);
            });
        });
    </script>
@endpush
