@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
            <a href="{{ route('user.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <button class="btn btn-warning mb-3" id="toggle-data-btn">Lihat Data Sekarang</button>
                <div id="data-sekarang" style="display: none;">
                    <h3 class="fw-bold">Data Sekarang</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Karyawan</label>
                                <input type="text" class="form-control" value="{{ $user->kode_karyawan }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" value="********" disabled>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" class="form-control" value="{{ $user->nip ?? '-' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" value="{{ $user->unit }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenjang</label>
                                <input type="text" class="form-control" value="{{ $user->jenjang }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Departemen</label>
                                <input type="text" class="form-control" value="{{ $user->departemen }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text" class="form-control" value="{{ $user->no_hp }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" class="form-control" value="{{ $user->jabatan }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" class="form-control" value="{{ $user->kelas }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Sub Kelas</label>
                                <input type="text" class="form-control" value="{{ $user->sub_kelas }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('user.update',$user->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group my-2">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') ?? $user->name }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-2">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-2">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                               <div class="form-group my-2">
                                <label>Role <span class="text-danger">*</span></label>
                                <select name="role" id="select-roles" class="form-control @error('role') is-invalid @enderror" multiple>
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="form-group my-2">
                                <label>Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div> --}}


                            {{-- <div class="form-group my-2">
                                <label for="Unit">Unit</label>
                                <input type="text" class="form-control" name="unit" value="{{ $user->unit }}">
                            </div> --}}
                        </div>

                        <div class="col-md-6">
                            {{-- <div class="form-group my-2">
                                <label>Kode Karyawan</label>
                                <input type="text" name="employee_code"
                                    class="form-control @error('employee_code') is-invalid @enderror"
                                    value="{{ old('employee_code') }}">
                                @error('employee_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="form-group my-2">
                                <label>Jabatan</label>
                                <div class="form-group">

                                    <select id="select-jabatan" class="form-control" name="jabatan">
                                        @foreach ($jabatans as $index => $jabatan)
                                            <option value="{{ $jabatan }}"
                                                {{ old('jabatan') == $jabatan ? 'selected' : '' }}>{{ $jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-2">
                                <label>Departemen</label>
                                <div class="form-group">

                                    <select id="select-departemen" class="form-control" name="departemen">
                                        @foreach ($departemens as $index => $departemen)
                                            <option value="{{ $departemen }}"
                                                {{ old('departemen') == $departemen ? 'selected' : '' }}>
                                                {{ $departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('departemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-2">
                                <label>Unit</label>
                                <select name="unit" class="form-control @error('unit') is-invalid @enderror">
                                    <option value="">Pilih Unit</option>
                                    <option value="Cinere" {{ old('unit') == 'Cinere' ? 'selected' : '' }}>Cinere
                                    </option>
                                    <option value="Jagakarsa" {{ old('unit') == 'Jagakarsa' ? 'selected' : '' }}>
                                        Jagakarsa</option>
                                    <option value="Pamulang" {{ old('unit') == 'Pamulang' ? 'selected' : '' }}>
                                        Pamulang
                                    </option>
                                    <option value="BPS" {{ old('unit') == 'BPS' ? 'selected' : '' }}>BPS</option>
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_wali_kelas"
                                        name="is_wali_kelas" value="1" {{ old('is_wali_kelas') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_wali_kelas">
                                        Apakah wali kelas?
                                    </label>
                                </div>
                            </div>

                            <div class="form-group my-2">
                                <label>Jenjang</label>
                                <select name="jenjang" id="select-jenjang"
                                    class="form-control @error('jenjang') is-invalid @enderror" disabled>
                                    <option value="">Pilih Jenjang</option>
                                    <option value="KB" {{ old('jenjang') == 'KB' ? 'selected' : '' }}>KB</option>
                                    <option value="TK" {{ old('jenjang') == 'TK' ? 'selected' : '' }}>TK</option>
                                    <option value="SD" {{ old('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ old('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ old('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                </select>
                                @error('jenjang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-2">
                                <label>Kelas</label>
                                <select name="kelas" id="select-kelas"
                                    class="form-control @error('kelas') is-invalid @enderror" disabled>
                                    <option value="">Pilih Kelas</option>
                                    {{-- Options populated by JS --}}
                                </select>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-2">
                                <label>Sub Kelas</label>
                                <select name="sub_kelas" id="select-sub_kelas"
                                    class="form-control @error('sub_kelas') is-invalid @enderror" disabled>
                                    <option value="">Pilih Sub Kelas</option>
                                    <option value="A" {{ old('sub_kelas') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('sub_kelas') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('sub_kelas') == 'C' ? 'selected' : '' }}>C</option>
                                </select>
                                @error('sub_kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>





                        </div>
                    </div>

                    <div class="form-group my-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#select-jabatan').select2({
            allowClear: true,
            width: '100%',
        });


         $('#select-roles').select2({
            // placeholder: 'Ketik untuk mencari jenis kritik/saran...',
            allowClear: true,
            width: '100%',
        });

        // Custom styling for Select2 to match Tailwind
        $('.select2-container--default .select2-selection--single').css({
            'height': '48px',
            'border': '1px solid #d1d5db',
            'border-radius': '12px',
            'padding': '12px 16px',
            'font-size': '14px'
        });

        $('.select2-container--default .select2-selection--single .select2-selection__rendered').css({
            'line-height': '24px',
            'padding-left': '0'
        });

        $('.select2-container--default .select2-selection--single .select2-selection__arrow').css({
            'height': '46px'
        });

        // Focus styling
        $('#kendala-select').on('select2:open', function() {
            $('.select2-container--default .select2-selection--single').css({
                'border-color': '#10b981',
                'box-shadow': '0 0 0 2px rgba(16, 185, 129, 0.2)'
            });
        });

        $('#kendala-select').on('select2:close', function() {
            $('.select2-container--default .select2-selection--single').css({
                'border-color': '#d1d5db',
                'box-shadow': 'none'
            });
        });

        // Custom CSS for larger dropdown
        $('<style>').prop('type', 'text/css').html(`
                    .select2-results {
                        max-height: 500px !important;
                    }
                    .select2-results__option {
                        padding: 12px 16px !important;
                        font-size: 14px !important;
                        line-height: 1.4 !important;
                    }
                `).appendTo('head');
    </script>
    <script>
        $(document).ready(function() {
            const isWaliKelasCheckbox = $('#is_wali_kelas');
            const jenjangSelect = $('#select-jenjang');
            const kelasSelect = $('#select-kelas');
            const subKelasSelect = $('#select-sub_kelas');

            const waliKelasFields = [jenjangSelect, kelasSelect, subKelasSelect];

            const kelasMap = {
                'SD': {
                    start: 1,
                    end: 6
                },
                'SMP': {
                    start: 7,
                    end: 9
                },
                'SMA': {
                    start: 10,
                    end: 12
                }
            };

            function populateKelas(selectedJenjang, preselectKelas = null) {
                kelasSelect.html('<option value="">Pilih Kelas</option>');
                if (selectedJenjang && kelasMap[selectedJenjang]) {
                    const range = kelasMap[selectedJenjang];
                    for (let i = range.start; i <= range.end; i++) {
                        const selectedAttr = (preselectKelas && i == preselectKelas) ? 'selected' : '';
                        kelasSelect.append(`<option value="${i}" ${selectedAttr}>${i}</option>`);
                    }
                }
            }

            function toggleWaliKelasFields(enable) {
                waliKelasFields.forEach(field => {
                    field.prop('disabled', !enable);
                });

                if (!enable) {
                    jenjangSelect.val('');
                    kelasSelect.html('<option value="">Pilih Kelas</option>').val('');
                    subKelasSelect.val('');
                }
            }

            isWaliKelasCheckbox.on('change', function() {
                toggleWaliKelasFields($(this).is(':checked'));
            });

            jenjangSelect.on('change', function() {
                populateKelas($(this).val());
            });

            // --- Initial execution on page load ---
            const isCheckedInitially = isWaliKelasCheckbox.is(':checked');
            toggleWaliKelasFields(isCheckedInitially);

            if (isCheckedInitially && jenjangSelect.val()) {
                populateKelas(jenjangSelect.val(), "{{ old('kelas') }}");
            }

            // Toggle visibility for #data-sekarang
            $('#toggle-data-btn').on('click', function() {
                const dataDiv = $('#data-sekarang');
                dataDiv.slideToggle();
                if (dataDiv.is(':visible')) {
                    $(this).text('Tutup Data Sekarang');
                } else {
                    $(this).text('Lihat Data Sekarang');
                }
            });
        });
    </script>
@endpush
