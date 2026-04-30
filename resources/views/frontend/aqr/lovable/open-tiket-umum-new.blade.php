@extends('frontend.aqr.lovable.layout-new')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 fade-up">

    {{-- ============ KIRI: FORM ============ --}}
    <section class="lg:col-span-3 space-y-6">

        {{-- Header --}}
        <div class="space-y-3">
            <span class="chip border-ink-200 bg-white text-ink-600">
                <i class="fa-solid fa-users text-accent-600"></i> Masyarakat Umum
            </span>
            <h1 class="font-display text-4xl sm:text-5xl text-ink-900 leading-[1.05]">
                Sampaikan kritik & saran kamu.
            </h1>
            <p class="text-ink-500 text-[15px] max-w-xl">
                Cerita kamu membantu sekolah jadi lebih baik. Isi form di bawah — singkat, jelas, dan langsung ke intinya.
            </p>
        </div>

        {{-- Alerts --}}
        @if ($errors->any())
            <div class="card p-4 border-red-200 bg-red-50/60">
                <div class="flex gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800">Ada yang perlu diperbaiki</h3>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="card p-4 border-red-200 bg-red-50/60">
                <p class="text-sm text-red-700"><i class="fa-solid fa-circle-exclamation mr-2"></i>{{ session('error') }}</p>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" enctype="multipart/form-data"
              action="{{ route('helpdesk.home.tiket-store') }}"
              class="card p-6 sm:p-8 space-y-5">
            @csrf
            <input type="hidden" name="pengirim" value="Masyarakat Umum">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="label">Nama lengkap</label>
                    <input type="text" name="nama" required class="input" placeholder="Mis. Andi Pratama">
                </div>
                <div>
                    <label class="label">Email</label>
                    <input type="email" name="email" required class="input" placeholder="kamu@email.com">
                </div>
            </div>

            <div>
                <label class="label">Nomor handphone</label>
                <input type="tel" name="no_hp" required class="input" placeholder="08xxxxxxxxxx">
            </div>

            <div>
                <label class="label">Judul</label>
                <input type="text" name="judul_kendala" required class="input"
                       placeholder="Ringkas dalam 1 kalimat — apa intinya?">
            </div>

            <div>
                <label class="label flex items-center justify-between">
                    <span>Detail kritik / saran</span>
                    <button type="button" id="btn-ai-suggest"
                            class="text-xs font-medium text-accent-600 hover:text-accent-700 inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Bantu rapikan dengan AI
                    </button>
                </label>
                <textarea id="detail-input" name="detail_kendala" required rows="5"
                          class="input resize-none"
                          placeholder="Cerita lebih lengkap di sini — apa yang terjadi, di mana, dan harapanmu seperti apa."></textarea>
                <p class="helper">Tips: makin spesifik, makin cepat ditangani.</p>
            </div>

            {{-- AI suggestion box --}}
            <div id="ai-box" class="hidden border border-accent-100 bg-accent-50/60 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-sparkles text-accent-600 mt-0.5"></i>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-accent-700 mb-1">Saran AI</p>
                        <div id="ai-content" class="text-sm text-ink-700 whitespace-pre-wrap leading-relaxed"></div>
                        <div class="mt-3 flex gap-2">
                            <button type="button" id="ai-apply" class="btn-secondary !py-1.5 !px-3 text-xs">
                                <i class="fa-solid fa-check"></i> Pakai versi ini
                            </button>
                            <button type="button" id="ai-dismiss" class="btn-ghost !py-1.5 !px-3 text-xs">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- File --}}
            <div>
                <label class="label">Lampiran <span class="text-ink-400 font-normal">(opsional)</span></label>
                <input type="file" name="choosefile" accept="image/*" id="file-upload" class="hidden">
                <label for="file-upload"
                       class="flex items-center gap-3 px-4 py-3 border border-dashed border-ink-300 rounded-lg cursor-pointer hover:border-accent-500 hover:bg-accent-50/40 transition">
                    <span class="w-9 h-9 rounded-md bg-ink-100 flex items-center justify-center text-ink-500">
                        <i class="fa-solid fa-paperclip"></i>
                    </span>
                    <span class="text-sm">
                        <span class="text-ink-800 font-medium" id="file-label">Pilih foto atau screenshot</span>
                        <span class="block text-xs text-ink-500">PNG / JPG, maks 10MB</span>
                    </span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-2 border-t border-ink-100">
                <a href="{{ route('helpdesk.home.cek-pengirim') }}" class="btn-ghost text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-paper-plane"></i> Kirim
                </button>
            </div>
        </form>
    </section>

    {{-- ============ KANAN: REKOMENDASI / FAQ ============ --}}
    <aside class="lg:col-span-2 space-y-6 lg:sticky lg:top-20 self-start">
        @include('frontend.aqr.partials.rekomendasi')
    </aside>
</div>

@push('scripts')
<script>
    // File label
    const fileInput = document.getElementById('file-upload');
    fileInput.addEventListener('change', e => {
        const name = e.target.files[0]?.name;
        if (name) document.getElementById('file-label').textContent = name;
    });

    // AI suggest — POST ke endpoint Laravel kamu (lihat ai-suggest-controller.php contoh)
    const btn  = document.getElementById('btn-ai-suggest');
    const box  = document.getElementById('ai-box');
    const out  = document.getElementById('ai-content');
    const ta   = document.getElementById('detail-input');

    btn.addEventListener('click', async () => {
        const text = ta.value.trim();
        if (text.length < 10) {
            out.textContent = 'Tulis dulu minimal 1–2 kalimat, baru AI bisa bantu rapikan ✍️';
            box.classList.remove('hidden'); return;
        }
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses…';
        out.textContent = ''; box.classList.remove('hidden');
        try {
            const res = await fetch('{{ url("/helpdesk/ai-suggest") }}', {
                method: 'POST',
                headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
                body: JSON.stringify({ text })
            });
            const data = await res.json();
            out.textContent = data.suggestion || 'Tidak ada saran saat ini.';
            document.getElementById('ai-apply').onclick = () => {
                ta.value = data.suggestion; box.classList.add('hidden');
            };
        } catch(e) {
            out.textContent = 'Gagal memuat saran AI. Coba lagi sebentar ya.';
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles"></i> Bantu rapikan dengan AI';
        }
    });
    document.getElementById('ai-dismiss').onclick = () => box.classList.add('hidden');
</script>
@endpush
@endsection
