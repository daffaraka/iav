@extends('dashboard.layout')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Edit Role: <span class="text-primary">{{ $role->name }}</span></h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('role.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label">Nama Role</label>
                    <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label mb-0 fw-bold fs-5">Permissions (Hak Akses)</label>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="checkAll">Centang Semua</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="uncheckAll">Hapus Semua</button>
                        </div>
                    </div>

                    @php
                        // Definisikan grup modul beserta label & warna
                        $moduleGroups = [
                            'Dashboard' => [
                                'color' => '#696cff',
                                'modules' => ['dashboard'],
                            ],
                            'Sekolah & Prestasi' => [
                                'color' => '#28c76f',
                                'modules' => ['sekolah', 'data-prestasi'],
                            ],
                            'Lowongan' => [
                                'color' => '#ff6f61',
                                'modules' => ['lowongan-pekerjaan', 'lowongan-apply', 'lowongan-progress'],
                            ],
                            'Departemen & SDM' => [
                                'color' => '#ff9f43',
                                'modules' => ['departement', 'wig', 'lead-measure', 'task-process', 'wig-progress'],
                            ],
                            'AQR (Aduan & Tiket)' => [
                                'color' => '#00cfe8',
                                'modules' => ['aqr-dashboard', 'tiket', 'aduan', 'progres-tiket', 'rating-tiket'],
                            ],
                            'User Management' => [
                                'color' => '#7367f0',
                                'modules' => ['user'],
                            ],
                        ];

                        $actions = ['view', 'create', 'edit', 'delete'];

                        // Kumpulkan permission yang termasuk modul (action-module)
                        $moduleBased = [];
                        foreach ($moduleGroups as $groupLabel => $group) {
                            foreach ($group['modules'] as $mod) {
                                foreach ($actions as $act) {
                                    $moduleBased[] = $act . '-' . $mod;
                                }
                            }
                        }

                        // Sisanya = specific permissions (yang bukan pola action-module)
                        $specificPermissions = $permissions->filter(function ($p) use ($moduleBased) {
                            return !in_array($p->name, $moduleBased);
                        });
                    @endphp

                    {{-- Loop setiap grup modul --}}
                    @foreach ($moduleGroups as $groupLabel => $group)
                        <div class="card mb-3 border" style="border-left: 4px solid {{ $group['color'] }} !important;">
                            <div class="card-header py-2 d-flex justify-content-between align-items-center" style="background-color: {{ $group['color'] }}10;">
                                <h6 class="mb-0 fw-bold" style="color: {{ $group['color'] }};">
                                    {{ $groupLabel }}
                                </h6>
                                <button type="button" class="btn btn-sm btn-outline-primary toggle-group" data-group="{{ Str::slug($groupLabel) }}">Toggle</button>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-0 align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:30%;">Modul</th>
                                                @foreach ($actions as $action)
                                                    <th class="text-center" style="width:17.5%;">{{ ucfirst($action) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($group['modules'] as $module)
                                                <tr>
                                                    <td class="fw-semibold">{{ ucwords(str_replace('-', ' ', $module)) }}</td>
                                                    @foreach ($actions as $action)
                                                        @php
                                                            $permName = $action . '-' . $module;
                                                            $perm = $permissions->firstWhere('name', $permName);
                                                        @endphp
                                                        <td class="text-center">
                                                            @if ($perm)
                                                                <div class="form-check d-flex justify-content-center mb-0">
                                                                    <input class="form-check-input perm-checkbox group-{{ Str::slug($groupLabel) }}"
                                                                        type="checkbox"
                                                                        name="permission[]"
                                                                        value="{{ $perm->name }}"
                                                                        id="perm-{{ $perm->id }}"
                                                                        {{ in_array($perm->id, $rolePermissions) ? 'checked' : '' }}>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">—</span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Permission khusus / spesifik --}}
                    @if ($specificPermissions->count() > 0)
                        <div class="card mb-3 border" style="border-left: 4px solid #ea5455 !important;">
                            <div class="card-header py-2" style="background-color: #ea545510;">
                                <h6 class="mb-0 fw-bold" style="color: #ea5455;">
                                    Permission Khusus
                                </h6>
                            </div>
                            <div class="card-body py-3">
                                <div class="row">
                                    @foreach ($specificPermissions as $perm)
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input perm-checkbox"
                                                    type="checkbox"
                                                    name="permission[]"
                                                    value="{{ $perm->name }}"
                                                    id="perm-{{ $perm->id }}"
                                                    {{ in_array($perm->id, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm-{{ $perm->id }}">
                                                    {{ $perm->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
                    <a href="{{ route('role.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Centang / Hapus semua
    document.getElementById('checkAll').addEventListener('click', function() {
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true);
    });
    document.getElementById('uncheckAll').addEventListener('click', function() {
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
    });

    // Toggle per grup
    document.querySelectorAll('.toggle-group').forEach(btn => {
        btn.addEventListener('click', function() {
            const group = this.dataset.group;
            const checkboxes = document.querySelectorAll('.group-' + group);
            const allChecked = [...checkboxes].every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        });
    });
</script>
@endpush
