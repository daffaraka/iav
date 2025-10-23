@extends('dashboard.layout')
@section('content')
    <div class="container my-3">

        <div class="card mb-3">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title fw-bold text-uppercase mb-0">{{ $title }}</h2>
                </div>

            </div>


            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('wig.lead-measure.store', $wig->id) }}" method="POST">
                            @csrf
                            <div class="form-group my-3">
                                <label class="fw-bold"for="">Judul Lead</label>
                                <input required type="text" name="judul_lead" id=""
                                    value="{{ old('judul_lead') }}"
                                    class="form-control @error('judul_lead') is-invalid @enderror">
                                @error('judul_lead')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label class="fw-bold"for="">Deskripsi Lead</label>
                                <textarea name="deskripsi_lead" class="form-control @error('deskripsi_lead') is-invalid @enderror" rows="3">{{ old('deskripsi_lead') }}</textarea>
                                @error('deskripsi_lead')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-3">
                                <label class="fw-bold"for="">Satuan</label>
                                <select name="satuan" id="" class="form-control">
                                    <option value="%"> Persen (%)</option>
                                    <option value="Angka"> Unit </option>
                                </select>
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-3">

                                <label class="fw-bold"for="">Target</label>
                                <input type="number" name="target"
                                    class="form-control  @error('target') is-invalid @enderror" value="{{ old('target') }}">
                                @error('target')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group my-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="fw-bold"for="">Tanggal Mulai</label>
                                        <input type="date" name="tanggal_mulai"
                                            class="form-control  @error('tanggal_mulai') is-invalid @enderror"
                                            value="{{ old('tanggal_mulai') }}">
                                        @error('tanggal_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label class="fw-bold"for="">Tanggal Selesai</label>
                                        <input type="date" name="tanggal_selesai"
                                            class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                            value="{{ old('tanggal_selesai') }}">
                                        @error('tanggal_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                            </div>



                            <div class="form-group my-3">
                                <label class="fw-bold"for="">Status</label>
                                <select name="status" id="" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @error('status')
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
@endsection
