@extends('dashboard.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">


            <div class="card-body p-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Tambah WIG Baru</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('wig.update',$wig->id) }}" method="POST">
                                @csrf
                                <div class="form-group my-3">
                                    <label class="fw-bold"for="">Nama WIG</label>
                                    <input required type="text" name="nama_wig" id=""
                                        value="{{ $wig->nama_wig ?? old('nama_wig') }}"
                                        class="form-control @error('nama_wig') is-invalid @enderror">
                                    @error('nama_wig')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label class="fw-bold"for="">Deskripsi WIG</label>
                                    <textarea name="deskripsi_wig" class="form-control @error('deskripsi_wig') is-invalid @enderror" rows="3">{{ $wig->deskripsi_wig ?? old('deskripsi_wig') }}</textarea>
                                    @error('deskripsi_wig')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group my-3">

                                    <div class="row">
                                        <div class="col-6">
                                            <label class="fw-bold"for="">Tanggal Mulai</label>
                                            <input required type="date" name="tanggal_mulai_wig"
                                                value="{{ $wig->tanggal_mulai_wig ?? old('tanggal_mulai_wig') }}"
                                                class="form-control @error('tanggal_mulai_wig') is-invalid @enderror">
                                            @error('tanggal_mulai_wig')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <label class="fw-bold"for="">Tanggal Berakhir</label>
                                            <input required type="date" name="tanggal_berakhir_wig"
                                                value="{{ $wig->tanggal_berakhir_wig ?? old('tanggal_berakhir_wig') }}"
                                                class="form-control @error('tanggal_berakhir_wig') is-invalid @enderror">
                                            @error('tanggal_berakhir_wig')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>



                                </div>

                                <div class="form-group my-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="fw-bold"for="">From X (Angka)</label>
                                            <input type="number" name="from_x" class="form-control" value="{{ $wig->from_x ?? old('from_x') }}">
                                        </div>

                                        <div class="col-6">
                                            <label class="fw-bold"for="">To Y (Angka)</label>
                                            <input type="number" name="from_y" class="form-control" value="{{ $wig->from_y ?? old('from_y') }}">
                                        </div>
                                    </div>


                                </div>


                                <div class="form-group my-3">
                                    <label class="fw-bold"for="">Unit</label>
                                    <select name="unit" id="" class="form-control">
                                        <option value="%" {{ ($wig->unit ?? old('unit')) == '%' ? 'selected' : '' }}> Persen (%)</option>
                                        <option value="Angka" {{ ($wig->unit ?? old('unit')) == 'Angka' ? 'selected' : '' }}> Angka </option>


                                    </select>
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group my-3">
                                    <label class="fw-bold"for="">Unit / Department</label>
                                    <select required name="unit_id"
                                        class="form-control @error('unit_id') is-invalid @enderror" id="unit">
                                        <option value="IT Branding" {{ ($wig->unit_id ?? old('unit_id')) == 'IT Branding' ? 'selected' : '' }}>IT & Branding</option>
                                        <option value="SDM" {{ ($wig->unit_id ?? old('unit_id')) == 'SDM' ? 'selected' : '' }}>SDM</option>
                                        <option value="RND" {{ ($wig->unit_id ?? old('unit_id')) == 'RND' ? 'selected' : '' }}>RND</option>

                                    </select>
                                    @error('unit_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary mt-3 shadow" type="submit">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>


            </div>


        </div>

    </div>
@endsection
