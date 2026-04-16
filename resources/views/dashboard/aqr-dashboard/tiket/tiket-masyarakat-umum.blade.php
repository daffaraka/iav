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

{{-- Forward to Kepala Sekolah/TU for Masyarakat Umum --}}
@hasanyrole(['super-admin', 'humas'])
    @if($tiket->status == 'Proses')
        <hr>
        <h6 class="fw-bold text-primary">Teruskan ke:</h6>
        <div class="form-group mb-3">
            <label>Pilih Jabatan:</label>
            <select name="forward_type" id="forwardType" class="form-control" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="kepala-sekolah">Kepala Sekolah</option>
                <option value="kepala-tu">Kepala TU</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Pilih Nama:</label>
            <select name="pic_id" id="picSelect" class="form-control" required disabled>
                <option value="">-- Pilih jabatan terlebih dahulu --</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Catatan (opsional):</label>
            <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan untuk PIC..."></textarea>
        </div>
        <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">
        <input type="hidden" name="action" value="forward">
    @endif
@endhasanyrole
