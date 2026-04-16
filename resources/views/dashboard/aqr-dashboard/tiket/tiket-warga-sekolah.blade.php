   @switch($tiket->status)
       @case('New')
           @if ($tiket->pengirim == 'Warga Sekolah')
               <div class="mb-3">
                   <label class="text-dark">Kepala Sekolah/Kepala TU/Kepala Psikolog
                       :</label>
                   <input type="text" class="form-control fw-bold" readonly
                       value="{{ $tiket->first_pic->name ?? 'Belum ditentukan' }}">
               </div>


               <div class="departement">
                   <div class="form-group mb-3">
                       <label for="Status">Pilih Departemen Terkait</label>
                       <select class="form-control mb-3" name="departemen" id="departemen" required>
                           <option value="Wakil Kurikulum">Wakil Kurikulum</option>
                           <option value="Wakil Kesiswaan">Wakil Kesiswaan</option>
                           <option value="Guru Kelas">Wali Kelas</option>
                           <option value="Psikolog">Psikolog</option>
                           <option value="Guru BK">BK</option>
                           <option value="Keuangan">Keuangan</option>
                           <option value="Staf Sarpra">Sarana dan Prasarana</option>
                           <option value="Tata Usaha">Tata Usaha</option>
                           <option value="Teknisi">Teknisi</option>
                           <option value="Humas">Humas
                           </option>
                           <option value="Koperasi">Koperasi</option>
                           {{-- <option value="Kepala Sekolah">Kepala Sekolah</option> --}}


                       </select>
                   </div>
               </div>
               <div class="humas mb-3">
                   <div class="form-group mb-3">
                       <label for="Status">Pilih PIC Yang Menanganani</label>
                       <select class="form-control mb-3" name="pic_menanggapi" id="pic_menanggapi" required>
                           {{-- @foreach ($picSelect as $select)
                                                                <option value="{{ $select->id }}"> <span
                                                                        class="text-danger">{{ $select->departemen ?? '-' }}
                                                                    </span>
                                                                    - {{ $select->name }}
                                                                </option>
                                                            @endforeach --}}
                       </select>
                   </div>
               </div>
           @endif
       @break

       @case('Proses')
           @if (Auth::user()->hasAnyRole([['super-admin', 'tata-usaha', 'humas', 'admin', 'kepala-sekolah','kepala-tata-usaha']]))
               <h6 class="mt-3 mb-4 text-dark">PIC sudah ditentukan</h6>

               {{-- <input type="hidden" name="menanggapi" value="selesai"> --}}

               <div class="mb-3">
                   <strong><label for="">Kepsek / Kepala TU </label></strong>
                   <input type="text" name="" id="" value="{{ $tiket->first_pic->name }}"
                       class="form-control" disabled>
               </div>
               <div class="mb-3">
                   <strong><label for="">Departemen</label></strong>
                   <input type="text" name="departemen" id="" value="{{ $tiket->departemen }}" class="form-control"
                       disabled>
               </div>
               <div class="mb-3">
                   <strong><label for="">Pic Menanggapi</label></strong>
                   <input type="text" name="" id=""
                       value="{{ $tiket->pic->name }} @role('super-admin') - {{ $tiket->pic->email }}  @endrole"
                       class="form-control" disabled>
               </div>

               <div class="mb-3">
                   <strong><label for="Deskripsi">Deskripsi Penanganan</label></strong>
                   <textarea class="form-control mb-3" id="penanganan" name="penanganan" class="materialize-textarea validate"
                       length="120" disabled> {{ $tiket->penanganan ?? 'Belum ditangani' }}</textarea>
               </div>

               <div class="mb-3">
                   <strong><label for="">Status</label></strong>
                   <input type="text" class="form-control" value="{{ $tiket->status }}" disabled>
               </div>


               <div>
                   <strong><label for="fotoperbaikan">Foto Penanganan</label></strong>
                   <br>
                   @if ($tiket->fotopengerjaan == null)
                       <input type="text" name="fotopengerjaan" class="form-control" value="PIC belum menangani" disabled>
                   @else
                       <img class="img-fluid" src="{{ asset($tiket->fotopengerjaan) }}" alt="">
                   @endif
               </div>


               <button type="button" class="btn btn-info mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit
                   Ulang</button>
           @else
               {{-- Ketika proses dan akan mengisi --}}
               {{-- <input type="hidden" name="menanggapi" value="selesai"> --}}
               <div class="mb-3">
                   <strong><label for="">Departemen</label></strong>
                   <input type="text" name="departemen" id="" value="{{ $tiket->departemen }}" class="form-control"
                       disabled>
               </div>
               <div class="mb-3">
                   <strong><label for="">Pic Menanggapi</label></strong>
                   <input type="text" name="" id="" value="{{ $tiket->pic->name }} (Anda)"
                       class="form-control" disabled>
               </div>

               <div class="mb-3">
                   <strong><label for="Deskripsi">Deskripsi Penanganan</label></strong>
                   <textarea class="form-control mb-3" id="penanganan" name="penanganan" class="materialize-textarea validate"
                       length="120"> {{ $tiket->penanganan }}</textarea>
               </div>


               <div>
                   <strong><label for="fotoperbaikan">Foto Penanganan</label></strong>
                   <br>
                   <input type="file" name="fotopengerjaan" class="form-control" accept="image/*" id="">
               </div>
           @endif
       @break

       @default
           <h3 class="font-weight-bold">Selesai</h3>
       @break

   @endswitch
