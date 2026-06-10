@extends('dashboard.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ $title ?? 'Featured Question' }}</h3>
                        <a href="{{ route('featured-question.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Baru
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="fqTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Pinned</th>
                                        <th>Klik Unik</th>
                                        <th>Sundul</th>
                                        <th>Sumber</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($featuredQuestions as $fq)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Str::limit($fq->judul, 50) }}</td>
                                            <td>
                                                @php
                                                    $kategoriClass = match ($fq->kategori) {
                                                        'Akademik' => 'bg-primary',
                                                        'Keuangan' => 'bg-success',
                                                        'Fasilitas Sarpras' => 'bg-warning',
                                                        'PPDB' => 'bg-info',
                                                        'SDM' => 'bg-danger',
                                                        'IT' => 'bg-dark',
                                                        default => 'bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $kategoriClass }}">{{ $fq->kategori }}</span>
                                            </td>
                                            <td>
                                                @if ($fq->is_published)
                                                    <span class="badge bg-success">Published</span>
                                                @else
                                                    <span class="badge bg-secondary">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($fq->is_pinned)
                                                    <span class="badge bg-warning text-dark">Ya</span>
                                                @else
                                                    <span class="text-muted">Tidak</span>
                                                @endif
                                            </td>
                                            <td>{{ $fq->view_count }}</td>
                                            <td>{{ $fq->vote_count }}</td>
                                            <td>
                                                @if ($fq->tiket_id)
                                                    <span class="badge bg-info">Tiket #{{ $fq->tiket_id }}</span>
                                                @else
                                                    <span class="badge bg-label-secondary">Manual</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('featured-question.edit', $fq->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bx bx-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('featured-question.destroy', $fq->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus featured question ini?')">
                                                        <i class="bx bx-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#fqTable').DataTable({
                "pageLength": 25,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "zeroRecords": "Tidak ada data yang cocok",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>
@endpush
