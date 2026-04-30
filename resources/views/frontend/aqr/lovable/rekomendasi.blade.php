{{--
    Partial: Rekomendasi pembahasan (FAQ + tips).
    Letakkan di: resources/views/frontend/aqr/partials/rekomendasi.blade.php
--}}

<div class="card p-5">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-semibold text-ink-900 flex items-center gap-2">
            <i class="fa-solid fa-lightbulb text-amber-500"></i>
            Mungkin pertanyaanmu sudah terjawab
        </h3>
        <span class="text-[11px] text-ink-400">FAQ</span>
    </div>

    <div class="divide-y divide-ink-100">
        @php
            $faqs = [
                [
                    'q' => 'Berapa lama tiket saya akan ditangani?',
                    'a' => 'Tiket umumnya direspon dalam 1×24 jam pada hari kerja. Untuk kasus mendesak (kekerasan, keselamatan), tim akan menghubungi langsung dalam beberapa jam.'
                ],
                [
                    'q' => 'Apakah identitas saya aman?',
                    'a' => 'Ya. Data kamu hanya terlihat oleh tim helpdesk dan PIC terkait. Kami tidak membagikan ke pihak luar.'
                ],
                [
                    'q' => 'Bagaimana cara melacak tiket?',
                    'a' => 'Setelah tiket dikirim, kamu akan mendapat nomor tiket. Buka menu “Lacak Tiket” dan masukkan nomor tersebut.'
                ],
                [
                    'q' => 'Bisa kirim lampiran video?',
                    'a' => 'Saat ini hanya gambar (PNG/JPG, maks 10MB). Untuk video, sertakan tautan Google Drive di kolom detail.'
                ],
                [
                    'q' => 'Saya warga sekolah, kenapa diminta NISN?',
                    'a' => 'NISN dipakai untuk verifikasi otomatis agar tiketmu langsung diteruskan ke wali kelas atau unit yang tepat.'
                ],
            ];
        @endphp

        @foreach ($faqs as $i => $f)
            <details class="group py-3" @if($i===0) open @endif>
                <summary class="flex items-center justify-between gap-3">
                    <span class="text-[14px] font-medium text-ink-800 group-hover:text-ink-900">{{ $f['q'] }}</span>
                    <i class="fa-solid fa-chevron-down text-ink-400 text-xs chev"></i>
                </summary>
                <p class="mt-2 text-sm text-ink-600 leading-relaxed">{{ $f['a'] }}</p>
            </details>
        @endforeach
    </div>
</div>

<div class="card p-5">
    <h3 class="text-sm font-semibold text-ink-900 flex items-center gap-2 mb-3">
        <i class="fa-solid fa-bolt text-accent-600"></i>
        Tips menulis tiket yang efektif
    </h3>
    <ul class="space-y-2.5 text-sm text-ink-600">
        <li class="flex gap-2"><span class="text-ink-400">01</span> Tulis <b class="text-ink-800">apa</b> yang terjadi.</li>
        <li class="flex gap-2"><span class="text-ink-400">02</span> Sebut <b class="text-ink-800">kapan</b> dan <b class="text-ink-800">di mana</b>.</li>
        <li class="flex gap-2"><span class="text-ink-400">03</span> Jelaskan <b class="text-ink-800">harapan</b> kamu.</li>
        <li class="flex gap-2"><span class="text-ink-400">04</span> Lampirkan <b class="text-ink-800">bukti</b> bila ada.</li>
    </ul>
</div>

<div class="card p-5 bg-ink-900 text-white border-ink-900">
    <p class="text-xs uppercase tracking-wider text-ink-400 mb-2">Butuh bantuan cepat?</p>
    <p class="font-display text-2xl leading-tight mb-3">
        Hubungi tim helpdesk lewat WhatsApp.
    </p>
    <a href="https://wa.me/6281234567890" target="_blank"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-white text-ink-900 text-sm font-medium hover:bg-ink-100 transition">
        <i class="fa-brands fa-whatsapp text-emerald-600"></i> Chat sekarang
    </a>
</div>
