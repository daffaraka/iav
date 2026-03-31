{{-- Ketika masih new dan humas harus menanggapi --}}



<div class="mb-3">
     <strong><label for="Deskripsi">Deskripsi Penanganan</label></strong>
     <textarea class="form-control mb-3" id="penanganan" name="penanganan" class="materialize-textarea validate" length="120"> {{ $tiket->penanganan }}</textarea>
 </div>


 <div>
     <strong><label for="fotoperbaikan">Foto Penanganan</label></strong>
     <br>
     <input type="file" name="fotopengerjaan" class="form-control" accept="image/*" id="">
 </div>
