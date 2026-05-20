<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQR — Avicenna Quick Response</title>
    <meta name="description" content="Layanan kritik, saran, dan pengaduan untuk seluruh warga Avicenna.">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font: Inter (body) + Instrument Serif (display accent) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Select2 (dipakai halaman warga) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
              serif: ['"Instrument Serif"', 'ui-serif', 'Georgia', 'serif'],
            },
            colors: {
              ink: {
                50:  '#f7f7f8',
                100: '#eeeef0',
                200: '#e3e3e6',
                300: '#cacace',
                400: '#9b9ba1',
                500: '#6c6c74',
                600: '#494951',
                700: '#2f2f36',
                800: '#1d1d22',
                900: '#0e0e12',
              },
              accent: {
                50:  '#eef2ff',
                100: '#e0e7ff',
                500: '#6366f1',
                600: '#4f46e5',
                700: '#4338ca',
              }
            },
            boxShadow: {
              'soft':   '0 1px 2px rgba(15, 15, 20, 0.04), 0 1px 1px rgba(15, 15, 20, 0.03)',
              'card':   '0 1px 0 rgba(15, 15, 20, 0.04), 0 8px 24px -12px rgba(15, 15, 20, 0.08)',
              'pop':    '0 12px 32px -12px rgba(79, 70, 229, 0.25)',
            },
            borderRadius: {
              'xl2': '14px',
            }
          }
        }
      }
    </script>

    <style>
      html { font-feature-settings: "ss01", "cv11"; }
      body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
      .font-display { font-family: 'Instrument Serif', ui-serif, Georgia, serif; letter-spacing: -0.01em; }

      /* Subtle dotted background — Notion/Linear feel */
      .bg-dotted {
        background-color: #fbfbfc;
        background-image: radial-gradient(rgba(15,15,20,0.06) 1px, transparent 1px);
        background-size: 18px 18px;
      }

      /* Inputs (utility class) */
      .input {
        @apply w-full px-3.5 py-2.5 text-[15px] text-ink-800 bg-white
               border border-ink-200 rounded-lg shadow-soft
               placeholder:text-ink-400
               focus:outline-none focus:border-accent-500 focus:ring-4 focus:ring-accent-100
               transition;
      }
      .label {
        @apply block text-sm font-medium text-ink-700 mb-1.5;
      }
      .helper {
        @apply text-xs text-ink-500 mt-1.5;
      }
      .btn {
        @apply inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition;
      }
      .btn-primary {
        @apply btn bg-ink-900 text-white hover:bg-ink-800 active:bg-black shadow-soft;
      }
      .btn-secondary {
        @apply btn bg-white text-ink-700 border border-ink-200 hover:bg-ink-50;
      }
      .btn-ghost {
        @apply btn text-ink-600 hover:text-ink-900 hover:bg-ink-100;
      }
      .chip {
        @apply inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border;
      }
      .card {
        @apply bg-white border border-ink-200 rounded-2xl shadow-card;
      }

      /* Soft fade-in */
      @keyframes fadeUp { from { opacity:0; transform: translateY(8px) } to { opacity:1; transform: translateY(0) } }
      .fade-up { animation: fadeUp .5s ease-out both; }

      /* Disclosure (akordeon FAQ) */
      details > summary { list-style: none; cursor: pointer; }
      details > summary::-webkit-details-marker { display: none; }
      details[open] .chev { transform: rotate(180deg); }
      .chev { transition: transform .2s ease; }

      /* Select2 — flat minimal */
      .select2-container--default .select2-selection--single {
        height: 44px !important;
        border: 1px solid #e3e3e6 !important;
        border-radius: 8px !important;
        padding: 8px 12px !important;
        background: #fff !important;
        box-shadow: 0 1px 2px rgba(15,15,20,0.04);
      }
      .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 26px !important; padding-left: 0 !important; color: #2f2f36 !important;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px !important; }
      .select2-container--default.select2-container--focus .select2-selection--single,
      .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 4px #e0e7ff !important;
      }
      .select2-results__option { padding: 10px 14px !important; font-size: 14px !important; }
    </style>
</head>

<body class="bg-dotted text-ink-800 min-h-screen">

    {{-- Top Nav --}}
    <header class="sticky top-0 z-40 backdrop-blur bg-white/70 border-b border-ink-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-ink-900 text-white text-[11px] font-bold tracking-wider">AQR</span>
                <span class="text-sm font-semibold text-ink-900">Avicenna Quick Response</span>
            </a>
            <nav class="hidden md:flex items-center gap-1 text-sm">
                <a href="{{ route('helpdesk.home.cek-pengirim') }}" class="btn-ghost">Buat Tiket</a>
                <a href="{{ route('helpdesk.home.tiket-tracking') }}" class="btn-ghost">Lacak Tiket</a>
            </nav>
            <a href="{{ route('helpdesk.home.tiket-tracking') }}" class="btn-secondary md:hidden">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-10 md:py-14">
        @yield('content')
    </main>

    <footer class="border-t border-ink-200 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-ink-500">
            <p>© {{ date('Y') }} Avicenna. Suara kamu, prioritas kami.</p>
            <p class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Sistem aktif & responsif
            </p>
        </div>
    </footer>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>
