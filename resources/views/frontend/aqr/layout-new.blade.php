<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AQR - Avicenna Quick Response</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <nav class="fixed top-0 w-full bg-white border-b border-gray-200 z-50">
        <div class="max-w-screen-xl flex items-center justify-between mx-auto px-4 sm:px-6 py-3">
            <a href="{{ route('helpdesk.home.cek-pengirim') }}" class="flex flex-col">
                <span class="text-2xl font-bold text-gray-800 leading-tight">Avicenna</span>
                <span class="text-[14px] font-medium text-orange-700">Quick Response</span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('helpdesk.home.open-tiket', ['pengirim' => 'Warga Sekolah']) }}"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                    Tiket Warga Sekolah
                </a>
                <a href="{{ route('helpdesk.home.open-tiket', ['pengirim' => 'Masyarakat Umum']) }}"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                    Tiket Masyarakat Umum
                </a>
            </div>
            <a href="{{ route('helpdesk.home.tiket-tracking') }}"
                class="hidden md:inline-flex px-4 py-2 bg-orange-600 text-white text-sm font-medium hover:bg-orange-700 transition-colors rounded-none">
                Lacak Tiket
            </a>

            {{-- Hamburger button --}}
            <button id="nav-toggle" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                <i id="nav-icon-open" class="fas fa-bars text-xl"></i>
                <i id="nav-icon-close" class="fas fa-times text-xl hidden"></i>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div id="nav-mobile" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('helpdesk.home.open-tiket', ['pengirim' => 'Warga Sekolah']) }}"
                   class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    Tiket Warga Sekolah
                </a>
                <a href="{{ route('helpdesk.home.open-tiket', ['pengirim' => 'Masyarakat Umum']) }}"
                   class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    Tiket Masyarakat Umum
                </a>
                <a href="{{ route('helpdesk.home.tiket-tracking') }}"
                   class="block px-3 py-2.5 bg-orange-600 text-white text-center text-sm font-medium hover:bg-orange-700 transition-colors rounded-none">
                    Lacak Tiket
                </a>
            </div>
        </div>
    </nav>

    <script>
        document.getElementById('nav-toggle').addEventListener('click', function () {
            const menu = document.getElementById('nav-mobile');
            const iconOpen = document.getElementById('nav-icon-open');
            const iconClose = document.getElementById('nav-icon-close');
            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });
    </script>

    <div class="mt-10">
        <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </div>

    <div class="text-center text-sm font-medium text-gray-200 py-12 bg-gray-500">
        <p>© {{ date('Y') }} Avicenna School. Ditenagai oleh AQR.</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
