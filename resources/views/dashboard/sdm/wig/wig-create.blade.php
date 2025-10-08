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
                            <form action="{{ route('wig.store') }}" method="POST">
                                @csrf
                                <div class="form-group my-3">
                                    <label for="">Nama WIG</label>
                                    <input required type="text" name="nama_wig" id=""
                                        value="{{ old('nama_wig') }}"
                                        class="form-control @error('nama_wig') is-invalid @enderror">
                                    @error('nama_wig')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Deskripsi WIG</label>
                                    <textarea name="deskripsi_wig" class="form-control @error('deskripsi_wig') is-invalid @enderror" rows="3">{{ old('deskripsi_wig') }}</textarea>
                                    @error('deskripsi_wig')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Tanggal Mulai</label>
                                    <input required type="date" name="tanggal_mulai_wig"
                                        value="{{ old('tanggal_mulai_wig') }}"
                                        class="form-control @error('tanggal_mulai_wig') is-invalid @enderror">
                                    @error('tanggal_mulai_wig')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Tanggal Berakhir</label>
                                    <input required type="date" name="tanggal_berakhir_wig"
                                        value="{{ old('tanggal_berakhir_wig') }}"
                                        class="form-control @error('tanggal_berakhir_wig') is-invalid @enderror">
                                    @error('tanggal_berakhir_wig')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Unit / Department</label>
                                    <select required name="unit_id"
                                        class="form-control @error('unit_id') is-invalid @enderror" id="unit">
                                        <option value="IT Branding">IT & Branding</option>
                                        <option value="SDM">SDM</option>
                                        <option value="RND">RND</option>

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
