@extends('frontend.aqr.layout-new')

@section('content')
    <div class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">

        <div class="text-center space-y-4">
            <img src="{{ asset('image/avicenna-helpdesk.png') }}" alt="AQR Logo"
                class="mx-auto h-24 w-auto drop-shadow-md mb-2">
            <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Pusat Bantuan Avicenna</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Cari solusi instan dari masalah yang sering ditanyakan, atau
                buat tiket baru jika butuh bantuan admin.</p>

            <div class="max-w-3xl mx-auto pt-6">
                <form action="#" method="GET" class="relative group shadow-lg rounded-2xl">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i
                            class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors text-lg"></i>
                    </div>
                    <input type="text" name="q"
                        class="block w-full pl-14 pr-32 py-5 bg-white border-2 border-transparent rounded-2xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-blue-500 transition-all shadow-sm text-lg"
                        placeholder="Cari kendala... (misal: Seragam, PPDB, E-Learning)">
                    <button type="submit"
                        class="absolute inset-y-2 right-2 px-8 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-md">
                        Cari
                    </button>
                </form>
            </div>
        </div>
        {{-- 
        <div class="text-center">
            <p class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-widest">Topik Populer</p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="#"
                    class="px-5 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-semibold text-gray-600 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-all shadow-sm transform hover:-translate-y-1">
                    <i class="fas fa-graduation-cap mr-2"></i>Akademik
                </a>
                <a href="#"
                    class="px-5 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-semibold text-gray-600 hover:bg-green-50 hover:border-green-300 hover:text-green-600 transition-all shadow-sm transform hover:-translate-y-1">
                    <i class="fas fa-money-bill-wave mr-2"></i>Keuangan
                </a>
                <a href="#"
                    class="px-5 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-semibold text-gray-600 hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 transition-all shadow-sm transform hover:-translate-y-1">
                    <i class="fas fa-building mr-2"></i>Fasilitas Sarpras
                </a>
                <a href="#"
                    class="px-5 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-semibold text-gray-600 hover:bg-purple-50 hover:border-purple-300 hover:text-purple-600 transition-all shadow-sm transform hover:-translate-y-1">
                    <i class="fas fa-user-plus mr-2"></i>PPDB
                </a>
            </div>
        </div> --}}

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <div class="lg:col-span-5 space-y-6 sticky top-6">
                <div class="bg-white shadow-xl p-8 border-2 border-gray-200 relative overflow-hidden">

                    <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Buka Tiket Baru</h3>
                    <p class="text-sm text-gray-500 mb-6">Pilih peran Anda di bawah ini untuk membuat tiket baru.</p>

                    <div class="space-y-4">

                        <a href="{{ route('helpdesk.home.open-tiket', ['pengirim' => 'Warga Sekolah']) }}"
                            class="group flex items-center justify-between p-4 border-2 border-gray-300 hover:border-emerald-500 hover:bg-emerald-50 hover:shadow-md transition-all duration-300 bg-green-50">
                            <div>
                                <h4 class="text-base font-bold text-gray-900">Warga Sekolah</h4>
                                <p class="text-xs text-gray-500 mt-1">Siswa, guru, dan staf internal.</p>
                            </div>
                        </a>

                        <a href="{{ route('helpdesk.home.open-tiket', ['pengirim' => 'Masyarakat Umum']) }}"
                            class="group flex items-center justify-between p-4 border-2 border-gray-300 hover:border-blue-500 hover:bg-blue-50 hover:shadow-md transition-all duration-300 bg-white">
                            <div>
                                <h4 class="text-base font-bold text-gray-900">Masyarakat Umum</h4>
                                <p class="text-xs text-gray-500 mt-1">Calon siswa, wali murid, dll.</p>
                            </div>
                        </a>

                    </div>

                    <div class="mt-8 pt-6 border-t-2 border-gray-200">
                        <a href="{{ route('helpdesk.home.tiket-tracking') }}"
                            class="w-full flex items-center justify-center py-4 px-4 border-2 border-gray-800 text-sm font-bold rounded-xl bg-gray-900 text-white hover:bg-gray-800 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                            Lacak Tiket Anda
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                @auth
                    @php
                        $votedIds = \App\Models\FqVote::where('user_id', Auth::id())
                            ->pluck('featured_question_id')
                            ->toArray();
                    @endphp
                @else
                    @php $votedIds = []; @endphp
                @endauth

                <div class="bg-white shadow-xl border border-gray-100 flex flex-col overflow-hidden">

                    <div class="p-6 border-b border-gray-100 bg-gray-50/80 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <i class="fas fa-fire text-orange-500 mr-2"></i> Pertanyaan yang Sering Ditanyakan
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">Sundul pertanyaan ini jika kamu memiliki masalah yang
                                sama!</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        @forelse($featuredQuestions as $fq)
                            <div
                                class="border {{ in_array($fq->id, $votedIds) ? 'border-orange-200 bg-orange-50/30' : 'border-gray-100 bg-white' }} p-5 hover:border-blue-200 hover:shadow-md transition-all relative group">
                                <div class="flex gap-5">
                                    {{-- Vote Button --}}
                                    <div class="flex flex-col items-center justify-start gap-1 pt-1">
                                        <button id="vote-btn-{{ $fq->id }}" onclick="toggleVote({{ $fq->id }})"
                                            class="w-12 h-12 rounded-xl border-2 flex items-center justify-center transition-all shadow-sm
                                            {{ in_array($fq->id, $votedIds)
                                                ? 'border-orange-500 bg-orange-500 text-white'
                                                : 'border-gray-200 bg-white text-gray-400 hover:text-orange-500 hover:border-orange-500 hover:bg-orange-50' }}"
                                            title="Sundul Pertanyaan Ini!">
                                            <i class="fas fa-caret-up text-3xl mb-1"></i>
                                        </button>
                                        <span id="vote-count-{{ $fq->id }}"
                                            class="text-sm font-extrabold {{ in_array($fq->id, $votedIds) ? 'text-orange-600' : 'text-gray-700' }}">{{ $fq->vote_count }}</span>
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-2 gap-2">
                                            <h4 class="fq-toggle font-bold text-gray-900 text-lg leading-tight group-hover:text-blue-600 transition-colors cursor-pointer flex items-center gap-2"
                                                data-fq-id="{{ $fq->id }}">
                                                @if ($fq->is_pinned)
                                                    <i class="fas fa-thumbtack text-orange-400 text-xs"
                                                        title="Disematkan"></i>
                                                @endif
                                                {{ $fq->judul }}
                                                <i id="fq-icon-{{ $fq->id }}"
                                                    class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-300"></i>
                                            </h4>
                                            @if ($fq->kategori)
                                                @php
                                                    $badgeColors = [
                                                        'Akademik' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                        'Keuangan' => 'bg-green-100 text-green-800 border-green-200',
                                                        'Fasilitas Sarpras' =>
                                                            'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                        'PPDB' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                        'SDM' => 'bg-red-100 text-red-800 border-red-200',
                                                        'IT' => 'bg-gray-100 text-gray-800 border-gray-200',
                                                        'Lainnya' => 'bg-gray-100 text-gray-600 border-gray-200',
                                                    ];
                                                    $badgeColor =
                                                        $badgeColors[$fq->kategori] ??
                                                        'bg-gray-100 text-gray-600
                                    border-gray-200';
                                                @endphp
                                                <span
                                                    class="flex-shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $badgeColor }} border">
                                                    {{ $fq->kategori }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Accordion body --}}
                                        <div id="fq-body-{{ $fq->id }}" class="hidden mb-4">
                                            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                                                {{ $fq->jawaban }}</p>
                                        </div>

                                        <div class="flex flex-wrap items-center text-xs font-medium text-gray-500 gap-4">
                                            <span id="fq-views-{{ $fq->id }}" class="flex items-center">
                                                <i class="fas fa-eye text-gray-400 mr-1.5"></i> {{ $fq->view_count }} orang
                                                melihat
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p class="text-sm">Belum ada pertanyaan populer saat ini.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                        <button class="text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors">Muat Lebih
                            Banyak <i class="fas fa-angle-down ml-1"></i></button>
                    </div>

                </div>
            </div>
        </div>



    </div>
@endsection

@push('scripts')
    <script>
        // Cookie helpers
        function setCookie(name, value, days) {
            const d = new Date();
            d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
        }

        function getCookie(name) {
            const v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
            return v ? v[2] : null;
        }

        function getVisitorId() {
            let id = getCookie('aqr_visitor_id');
            if (!id) {
                id = crypto.randomUUID();
                setCookie('aqr_visitor_id', id, 365);
            }
            return id;
        }

        // Track interest (klik, tanpa login)
        function trackInterest(fqId) {
            if (localStorage.getItem('fq_tracked_' + fqId)) return;
            const visitorId = getVisitorId();
            fetch('{{ route('helpdesk.home.faq-track') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        fq_id: fqId,
                        visitor_id: visitorId
                    })
                })
                .then(r => r.json())
                .then(data => {
                    localStorage.setItem('fq_tracked_' + fqId, '1');
                    if (data.new_count) {
                        const el = document.getElementById('fq-views-' + fqId);
                        if (el) el.textContent = data.new_count + ' orang melihat';
                    }
                });
        }

        // Toggle sundul (wajib login)
        function toggleVote(fqId) {
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            if (!isLoggedIn) {
                window.location.href = '/login';
                return;
            }
            fetch('{{ route('helpdesk.home.faq-vote') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        fq_id: fqId
                    })
                })
                .then(r => r.json())
                .then(data => {
                    const btn = document.getElementById('vote-btn-' + fqId);
                    const count = document.getElementById('vote-count-' + fqId);
                    if (data.voted) {
                        btn.classList.add('border-orange-500', 'bg-orange-500', 'text-white');
                        btn.classList.remove('border-gray-200', 'bg-white', 'text-gray-400');
                    } else {
                        btn.classList.remove('border-orange-500', 'bg-orange-500', 'text-white');
                        btn.classList.add('border-gray-200', 'bg-white', 'text-gray-400');
                    }
                    count.textContent = data.new_count;
                });
        }

        // Accordion toggle
        document.querySelectorAll('.fq-toggle').forEach(el => {
            el.addEventListener('click', function() {
                const fqId = this.dataset.fqId;
                const body = document.getElementById('fq-body-' + fqId);
                const icon = document.getElementById('fq-icon-' + fqId);
                body.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
                // Track on first expand
                if (!body.classList.contains('hidden')) {
                    trackInterest(fqId);
                }
            });
        });
    </script>
@endpush
