@extends('dashboard.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Data AQR Option</h3>
                        <a href="{{ route('aqr-option.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Option
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Option</th>
                                        <th>Kategori PIC</th>
                                        <th>Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($aqrOptions as $option)
                                        <tr>
                                            <td>{{ $loop->iteration }}
                                            </td>
                                            <td>{{ $option->nama_option }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = match ($option->kategori_pic) {
                                                        'Kepala Sekolah' => 'badge bg-primary',
                                                        'Kepala TU' => 'badge bg-success',
                                                        'Psikolog' => 'badge bg-info',
                                                        default => 'badge bg-secondary',
                                                    }
                                                @endphp
                                                <span class="{{ $badgeClass }}">
                                                    {{ $option->kategori_pic }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($option->is_aktif)
                                                    <span class="badge bg-dark">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('aqr-option.edit', $option) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>Edit
                                                </a>
                                                <form action="{{ route('aqr-option.destroy', $option) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin hapus?')">
                                                        <i class="fas fa-trash"></i>Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
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
          $('#dataTable').DataTable({
            "pageLength": 25
          });
        });
    </script>
@endpush
