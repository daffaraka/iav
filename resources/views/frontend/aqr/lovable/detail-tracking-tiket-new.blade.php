@extends('frontend.aqr.lovable.layout-new')

@section('content')
@php
    $statusColor = [
        'New'     => 'bg-blue-50 text-blue-700 border-blue-200',
        'Proses'  => 'bg-amber-50 text-amber-700 border-amber-200',
        'Selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
    ][$tiket->status] ?? 'bg-ink-50 text-ink-700 border-ink-200';
@endphp

<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 fade-up">

    {{-- ============ KIRI: DETAIL TIKET ============ --}}
    <section class="lg:col-span-3 space-y-6">

        {{-- Header --}}
        <div class="card p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink-400 mb-1">Nomor Tiket</p>
                    <h1 class="font-display text-3xl sm:text-4xl text-ink-900 leading-tight">
                        #{{ $tiket->no_tiket }}
                    </h1>
                    <p class="text-sm text-ink-500 mt-2">
                        <i class="fa-regular fa-clock mr-1"></i>
                        {{ $tiket->created_at->isoFormat('D MMMM YYYY · HH:mm') }}
                    </p>
                </div>
                <span class="chip {{ $statusColor }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $tiket->status }}
                </span>
            </div>

            @if ($tiket->status == 'Selesai')
                <div class="mt-5 pt-5 border-t border-ink-100">
                    @if ($tiket->rating == null)
                        <button onclick="document.getElementById('satisfyModal').classList.remove('hidden')"
                                class="btn-primary">
                            <i class="fa-solid fa-star"></i> Beri penilaian
                        </button>
                    @else
                        <p class="text-sm text-ink-600">
                            <i class="fa-solid fa-circle-check text-emerald-500 mr-1.5"></i>
                            Terima kasih, kamu sudah memberi rating <b>{{ $tiket->rating }}</b>.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Identitas + Info --}}
        <div class="card p-6 sm:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xs uppercase tracking-wider text-ink-500 mb-3">Identitas pengisi</h3>
                    <dl class="space-y-2.5 text-sm">
                        <div class="flex gap-2"><dt class="text-ink-500 w-24">Nama</dt><dd class="text-ink-800 font-medium">{{ $tiket->nama }}</dd></div>
                        <div class="flex gap-2"><dt class="text-ink-500 w-24">Email</dt><dd class="text-ink-800">{{ $tiket->email }}</dd></div>
                        <div class="flex gap-2"><dt class="text-ink-500 w-24">No. HP</dt><dd class="text-ink-800">{{ $tiket->no_hp }}</dd></div>
                        @if ($tiket->pengirim == 'Warga Sekolah')
                            <div class="flex gap-2"><dt class="text-ink-500 w-24">NISN</dt><dd class="text-ink-800 font-mono">{{ $tiket->nisn ?? '-' }}</dd></div>
                            @if ($tiket->nama_orangtua)
                                <div class="flex gap-2"><dt class="text-ink-500 w-24">Orang tua</dt><dd class="text-ink-800">{{ $tiket->nama_orangtua }}</dd></div>
                            @endif
                        @endif
                    </dl>
                </div>
                <div>
                    <h3 class="text-xs uppercase tracking-wider text-ink-500 mb-3">Informasi tiket</h3>
                    <dl class="space-y-2.5 text-sm">
                        <div class="flex gap-2"><dt class="text-ink-500 w-24">Pengirim</dt>
                            <dd>
                                <span class="chip {{ $tiket->pengirim == 'Warga Sekolah' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-accent-50 text-accent-700 border-accent-100' }}">
                                    <i class="fa-solid {{ $tiket->pengirim == 'Warga Sekolah' ? 'fa-graduation-cap' : 'fa-users' }}"></i>
                                    {{ $tiket->pengirim }}
                                </span>
                            </dd>
                        </div>
                        @if ($tiket->lokasi_kendala)
                            <div class="flex gap-2"><dt class="text-ink-500 w-24">Lokasi</dt><dd class="text-ink-800">{{ $tiket->lokasi_kendala }}</dd></div>
                        @endif
                        @if ($tiket->problem)
                            <div class="flex gap-2"><dt class="text-ink-500 w-24">Jenis</dt><dd class="text-ink-800">{{ $tiket->problem }}</dd></div>
                        @endif
                    </dl>
                </div>
            </div>

            <div class="border-t border-ink-100 pt-6 space-y-5">
                @if ($tiket->pengirim == 'Warga Sekolah')
                    <div>
                        <p class="text-xs uppercase tracking-wider text-ink-500 mb-1.5">Jenis kritik</p>
                        <p class="text-ink-800 font-medium">{{ $tiket->option->nama_option }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink-500 mb-1.5">Judul</p>
                    <p class="text-ink-900 font-display text-2xl leading-snug">{{ $tiket->judul_kendala }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink-500 mb-1.5">Detail</p>
                    <p class="text-ink-700 leading-relaxed whitespace-pre-wrap">{{ $tiket->detail_kendala }}</p>
                </div>
                @if ($tiket->filename)
                    <a href="{{ asset($tiket->filename) }}" target="_blank" class="btn-secondary">
                        <i class="fa-regular fa-image"></i> Lihat lampiran
                    </a>
                @endif
            </div>
        </div>

        {{-- Riwayat penanganan --}}
        @if ($tiket->pic_id != null && $tiket->progres->count() > 0)
            <div class="space-y-4">
                <h2 class="text-sm font-semibold text-ink-900 flex items-center gap-2">
                    <i class="fa-solid fa-timeline text-accent-600"></i> Riwayat penanganan
                </h2>

                <div class="relative pl-6">
                    <div class="absolute left-2 top-1 bottom-1 w-px bg-ink-200"></div>
                    @foreach ($tiket->progres as $progres)
                        <div class="relative mb-5 fade-up" style="animation-delay: {{ $loop->index * 0.05 }}s">
                            <span class="absolute -left-[18px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-ink-900"></span>
                            <div class="card p-5">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-ink-900 text-sm">{{ $tiket->pic->name }}</p>
                                    <span class="chip border-ink-200 bg-ink-50 text-ink-600">Update #{{ $loop->iteration }}</span>
                                </div>
                                <p class="text-xs text-ink-500 mb-3">
                                    <i class="fa-regular fa-clock mr-1"></i>{{ $progres->created_at->isoFormat('D MMMM YYYY · HH:mm') }}
                                </p>
                                <p class="text-sm text-ink-700 whitespace-pre-wrap leading-relaxed">{{ $progres->penanganan }}</p>
                                @if ($progres->fotopengerjaan)
                                    <a href="{{ asset($progres->fotopengerjaan) }}" target="_blank"
                                       class="btn-secondary mt-3 !py-1.5 !px-3 text-xs">
                                        <i class="fa-regular fa-image"></i> Foto penanganan
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <a href="{{ route('helpdesk.home.tiket-tracking') }}" class="btn-ghost text-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke pencarian
        </a>
    </section>

    {{-- ============ KANAN ============ --}}
    <aside class="lg:col-span-2 space-y-6 lg:sticky lg:top-20 self-start">
        @include('frontend.aqr.partials.rekomendasi')
    </aside>
</div>

{{-- Satisfaction Modal --}}
@if ($tiket->status == 'Selesai' && $tiket->kepuasan == null)
<div id="satisfyModal" class="fixed inset-0 bg-ink-900/50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="card max-w-lg w-full p-6 fade-up">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-display text-2xl text-ink-900">Seberapa puas kamu?</h3>
                <button onclick="document.getElementById('satisfyModal').classList.add('hidden')" class="btn-ghost !p-2">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('helpdesk.home.kepuasan-store', $tiket->id) }}" method="POST" class="space-y-5">
                @csrf
                <p class="text-sm text-ink-600">Penilaian kamu membantu kami terus jadi lebih baik.</p>

                <div class="text-center">
                    <div class="flex justify-center gap-2 mb-2">
                        @for ($i=1;$i<=5;$i++)
                            <i class="fa-solid fa-star text-3xl cursor-pointer text-ink-200 hover:text-amber-400 transition"
                               data-rating="{{ $i }}" onclick="setRating({{ $i }})"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="kepuasan" id="rating-input" required>
                    <input type="hidden" name="rating" id="rating-value" required>
                    <p class="text-xs text-ink-500" id="rating-text">Klik bintang untuk memberi rating</p>
                </div>

                <div>
                    <label class="label">Catatan tambahan <span class="text-ink-400 font-normal">(opsional)</span></label>
                    <textarea name="deskripsi_penilaian" rows="3" class="input resize-none"
                              placeholder="Apa yang bisa kami tingkatkan?"></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('satisfyModal').classList.add('hidden')"
                            class="btn-secondary flex-1">Batal</button>
                    <button type="submit" class="btn-primary flex-1">Kirim penilaian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
function setRating(r) {
    document.querySelectorAll('[data-rating]').forEach(s => {
        s.classList.toggle('text-amber-400', +s.dataset.rating <= r);
        s.classList.toggle('text-ink-200',   +s.dataset.rating > r);
    });
    document.getElementById('rating-input').value = r;
    document.getElementById('rating-value').value = r;
    const t = {1:'Sangat tidak puas',2:'Tidak puas',3:'Cukup',4:'Puas',5:'Sangat puas'};
    document.getElementById('rating-text').textContent = `${r}/5 — ${t[r]}`;
}
</script>
@endpush
@endsection
