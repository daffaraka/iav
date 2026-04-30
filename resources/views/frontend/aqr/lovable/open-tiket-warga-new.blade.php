@extends('frontend.aqr.lovable.layout-new')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 fade-up">

    {{-- ============ KIRI ============ --}}
    <section class="lg:col-span-3 space-y-6">

        <div class="space-y-3">
            <span class="chip border-emerald-200 bg-emerald-50 text-emerald-700">
                <i class="fa-solid fa-graduation-cap"></i> Warga Sekolah
            </span>
            <h1 class="font-display text-4xl sm:text-5xl text-ink-900 leading-[1.05]">
                Cerita kamu, kami dengar.
            </h1>
            <p class="text-ink-500 text-[15px] max-w-xl">
                Verifikasi NISN dulu untuk mempercepat penanganan, lalu sampaikan kritik atau saranmu.
            </p>
        </div>

        {{-- Alerts --}}
        @if ($errors->any())
            <div class="card p-4 border-red-200 bg-red-50/60">
                <h3 class="text-sm font-semibold text-red-800 mb-1"><i class="fa-solid fa-circle-exclamation mr-1.5"></i> Periksa kembali</h3>
                <ul class="text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="card p-4 border-red-200 bg-red-50/60 text-sm text-red-700">{{ session('error') }}</div>
        @endif

        {{-- ====== Step 1: NISN ====== --}}
        <div id="step-nisn" class="card p-6 sm:p-8 space-y-5">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-ink-900 text-white text-xs font-semibold flex items-center justify-center">1</span>
                <h2 class="text-lg font-semibold text-ink-900">Validasi NISN</h2>
            </div>

            <div>
                <label class="label">NISN (Nomor Induk Siswa Nasional)</label>
                <input type="text" id="nisn-check" class="input" placeholder="Masukkan NISN…" inputmode="numeric">
                <p class="helper">Contoh: <span class="font-mono">1234567890</span> · <span class="font-mono">1234567891</span></p>
            </div>

            <div id="loading-nisn" class="hidden flex items-center gap-2 text-sm text-ink-500">
                <i class="fa-solid fa-spinner fa-spin"></i> Memvalidasi NISN…
            </div>

            <div id="nisn-error" class="hidden border border-red-200 bg-red-50 rounded-lg p-3 text-sm text-red-700">
                <i class="fa-solid fa-circle-exclamation mr-1.5"></i><span id="error-message"></span>
            </div>

            <button type="button" id="btn-check-nisn" class="btn-primary w-full">
                <i class="fa-solid fa-shield-halved"></i> Validasi & Lanjutkan
            </button>
        </div>

        {{-- ====== Step 2: Form ====== --}}
        <div id="step-form" class="hidden card p-6 sm:p-8 space-y-5">
            <form method="POST" enctype="multipart/form-data"
                  action="{{ route('helpdesk.home.tiket-store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="pengirim" value="Warga Sekolah">
                <input type="hidden" name="nisn" id="nisn-hidden">

                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-ink-900 text-white text-xs font-semibold flex items-center justify-center">2</span>
                    <h2 class="text-lg font-semibold text-ink-900">Detail kritik & saran</h2>
                </div>

                {{-- Data siswa (read-only) --}}
                <div class="bg-ink-50 border border-ink-100 rounded-xl p-4">
                    <p class="text-[11px] uppercase tracking-wider text-ink-500 mb-3">Identitas tervalidasi</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-ink-500 text-xs mb-0.5">NISN</p>
                            <input type="text" id="nisn-display" readonly class="input bg-white !py-2 !text-sm">
                        </div>
                        <div>
                            <p class="text-ink-500 text-xs mb-0.5">Nama siswa</p>
                            <input type="text" name="nama" id="nama-siswa" readonly class="input bg-white !py-2 !text-sm">
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-ink-500 text-xs mb-0.5">Nama orang tua</p>
                            <input type="text" id="nama-orangtua-display" readonly class="input bg-white !py-2 !text-sm">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="label">Email</label>
                        <input type="email" name="email" required class="input" placeholder="kamu@email.com">
                    </div>
                    <div>
                        <label class="label">No. handphone</label>
                        <input type="tel" name="no_hp" required class="input" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <div>
                    <label class="label">Judul</label>
                    <input type="text" name="judul_kendala" required class="input" placeholder="Ringkasan singkat">
                </div>

                <div>
                    <label class="label">Jenis kritik / saran</label>
                    <select name="kendala" id="kendala-select" required>
                        <option value="">Pilih jenis…</option>
                        @foreach ($options as $opt)
                            <option value="{{ $opt->id }}">{{ $opt->nama_option }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label">Lokasi</label>
                    <select name="lokasi_kendala" required class="input">
                        <option value="">Pilih lokasi…</option>
                        <option value="KB Avicenna Pamulang">KB Avicenna Pamulang</option>
                        <option value="TK Avicenna Jagakarsa">TK Avicenna Jagakarsa</option>
                        <option value="SD Avicenna Jagakarsa">SD Avicenna Jagakarsa</option>
                        <option value="SMP Avicenna Jagakarsa">SMP Avicenna Jagakarsa</option>
                        <option value="SMA Avicenna Jagakarsa">SMA Avicenna Jagakarsa</option>
                        <option value="SD Avicenna Cinere">SD Avicenna Cinere</option>
                        <option value="SMP Avicenna Cinere">SMP Avicenna Cinere</option>
                        <option value="SMA Avicenna Cinere">SMA Avicenna Cinere</option>
                    </select>
                </div>

                <div>
                    <label class="label flex items-center justify-between">
                        <span>Detail kritik / saran</span>
                        <button type="button" id="btn-ai-suggest"
                                class="text-xs font-medium text-accent-600 hover:text-accent-700 inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> Bantu rapikan dengan AI
                        </button>
                    </label>
                    <textarea id="detail-input" name="detail_kendala" required rows="5" class="input resize-none"
                              placeholder="Mis. Ruang Kelas 2A, Area Parkir, Kantin… ceritakan sedetail mungkin."></textarea>
                </div>

                <div id="ai-box" class="hidden border border-accent-100 bg-accent-50/60 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-sparkles text-accent-600 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-accent-700 mb-1">Saran AI</p>
                            <div id="ai-content" class="text-sm text-ink-700 whitespace-pre-wrap leading-relaxed"></div>
                            <div class="mt-3 flex gap-2">
                                <button type="button" id="ai-apply" class="btn-secondary !py-1.5 !px-3 text-xs"><i class="fa-solid fa-check"></i> Pakai versi ini</button>
                                <button type="button" id="ai-dismiss" class="btn-ghost !py-1.5 !px-3 text-xs">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="label">Lampiran <span class="text-ink-400 font-normal">(opsional)</span></label>
                    <input type="file" name="choosefile" accept="image/*" id="file-upload" class="hidden">
                    <label for="file-upload"
                           class="flex items-center gap-3 px-4 py-3 border border-dashed border-ink-300 rounded-lg cursor-pointer hover:border-accent-500 hover:bg-accent-50/40 transition">
                        <span class="w-9 h-9 rounded-md bg-ink-100 flex items-center justify-center text-ink-500"><i class="fa-solid fa-paperclip"></i></span>
                        <span class="text-sm">
                            <span class="text-ink-800 font-medium" id="file-label">Pilih foto / screenshot</span>
                            <span class="block text-xs text-ink-500">PNG / JPG, maks 10MB</span>
                        </span>
                    </label>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-ink-100">
                    <button type="button" id="btn-back" class="btn-ghost text-sm"><i class="fa-solid fa-arrow-left"></i> Ganti NISN</button>
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-paper-plane"></i> Kirim tiket</button>
                </div>
            </form>
        </div>
    </section>

    {{-- ============ KANAN ============ --}}
    <aside class="lg:col-span-2 space-y-6 lg:sticky lg:top-20 self-start">
        @include('frontend.aqr.partials.rekomendasi')
    </aside>
</div>

@push('scripts')
<script>
$(function () {
    // NISN validation
    $('#btn-check-nisn').click(function () {
        const nisn = $('#nisn-check').val().trim();
        if (!nisn) return showError('NISN harus diisi');
        $('#loading-nisn').removeClass('hidden');
        $('#nisn-error').addClass('hidden');
        $(this).prop('disabled', true);

        $.ajax({
            url: '{{ route("helpdesk.home.get-siswa") }}',
            method: 'POST',
            data: { nisn, _token: '{{ csrf_token() }}' },
            success(res) {
                $('#loading-nisn').addClass('hidden');
                if (res.success) {
                    $('#step-nisn').fadeOut(200, () => $('#step-form').fadeIn(220).addClass('fade-up'));
                    $('#nisn-hidden, #nisn-display').val(nisn);
                    $('#nama-siswa').val(res.data.nama);
                    $('#nama-orangtua-display').val(res.data.nama_orang_tua || 'Tidak ada data');
                } else showError(res.message);
            },
            error() { $('#loading-nisn').addClass('hidden'); showError('Terjadi kesalahan sistem.'); },
            complete() { $('#btn-check-nisn').prop('disabled', false); }
        });
    });

    $('#btn-back').click(() => {
        $('#step-form').fadeOut(180, () => $('#step-nisn').fadeIn(200));
    });
    $('#nisn-check').keypress(e => { if (e.which === 13) $('#btn-check-nisn').click(); });

    function showError(msg) {
        $('#error-message').text(msg);
        $('#nisn-error').removeClass('hidden');
        $('#nisn-check').focus();
    }

    // File label
    $('#file-upload').change(function (e) {
        const n = e.target.files[0]?.name; if (n) $('#file-label').text(n);
    });

    // Select2
    $('#kendala-select').select2({
        placeholder: 'Cari jenis kritik / saran…',
        allowClear: true,
        width: '100%',
    });

    // AI suggestion
    $('#btn-ai-suggest').click(async function () {
        const text = $('#detail-input').val().trim();
        const $btn = $(this), $box = $('#ai-box'), $out = $('#ai-content');
        if (text.length < 10) { $out.text('Tulis dulu minimal 1–2 kalimat ✍️'); $box.removeClass('hidden'); return; }
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Memproses…');
        $out.text(''); $box.removeClass('hidden');
        try {
            const res = await fetch('{{ url("/helpdesk/ai-suggest") }}', {
                method: 'POST',
                headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
                body: JSON.stringify({ text })
            });
            const data = await res.json();
            $out.text(data.suggestion || 'Tidak ada saran saat ini.');
            $('#ai-apply').off('click').on('click', () => { $('#detail-input').val(data.suggestion); $box.addClass('hidden'); });
        } catch { $out.text('Gagal memuat saran AI.'); }
        finally { $btn.prop('disabled', false).html('<i class="fa-solid fa-wand-magic-sparkles"></i> Bantu rapikan dengan AI'); }
    });
    $('#ai-dismiss').click(() => $('#ai-box').addClass('hidden'));
});
</script>
@endpush
@endsection
