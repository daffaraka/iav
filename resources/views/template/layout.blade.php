<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Prototype - Avicenna</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for Prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6', // Soft Teal
                            600: '#0d9488',
                            900: '#134e4a',
                        },
                        surface: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'softer': '0 2px 10px -1px rgba(0, 0, 0, 0.02)',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Phosphor Icons (Sangat modern dan soft) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-surface-50 text-slate-800 font-sans antialiased selection:bg-brand-100 selection:text-brand-900 overflow-x-hidden">

    <div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full w-0'" class="fixed inset-y-0 left-0 z-50 bg-white border-r border-surface-200 transition-all duration-300 ease-in-out lg:static lg:block flex flex-col h-full shadow-softer">
            <!-- Logo -->
            <div class="h-16 flex items-center px-6 border-b border-surface-100">
                <div class="w-8 h-8 rounded-lg bg-brand-500 text-white flex items-center justify-center font-bold text-xl mr-3">
                    A
                </div>
                <div class="flex flex-col overflow-hidden whitespace-nowrap" x-show="sidebarOpen">
                    <span class="font-bold text-slate-800 leading-tight">Avicenna</span>
                    <span class="text-xs text-slate-500 font-medium">Dashboard</span>
                </div>
            </div>

            <!-- Menu -->
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1 scrollbar-hide">
                <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-4" x-show="sidebarOpen">Overview</p>
                <a href="#" class="flex items-center px-3 py-2.5 bg-brand-50 text-brand-600 rounded-xl group transition-all">
                    <i class="ph ph-squares-four text-xl mr-3"></i>
                    <span class="font-medium text-sm" x-show="sidebarOpen">Dashboard</span>
                </a>
                
                <a href="#" class="flex items-center px-3 py-2.5 text-slate-500 hover:bg-surface-50 hover:text-slate-800 rounded-xl group transition-all">
                    <i class="ph ph-ticket text-xl mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="font-medium text-sm" x-show="sidebarOpen">AQR Tiket</span>
                </a>

                <a href="#" class="flex items-center px-3 py-2.5 text-slate-500 hover:bg-surface-50 hover:text-slate-800 rounded-xl group transition-all">
                    <i class="ph ph-chart-line-up text-xl mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="font-medium text-sm" x-show="sidebarOpen">WIG Progress</span>
                </a>

                <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-6" x-show="sidebarOpen">Master Data</p>
                
                <a href="#" class="flex items-center px-3 py-2.5 text-slate-500 hover:bg-surface-50 hover:text-slate-800 rounded-xl group transition-all">
                    <i class="ph ph-users text-xl mr-3 group-hover:text-brand-500 transition-colors"></i>
                    <span class="font-medium text-sm" x-show="sidebarOpen">Data Siswa</span>
                </a>
            </div>

            <!-- Footer Sidebar -->
            <div class="p-4 border-t border-surface-100">
                <div class="flex items-center p-2 rounded-xl hover:bg-surface-50 transition-colors cursor-pointer overflow-hidden" x-show="sidebarOpen">
                    <img src="https://ui-avatars.com/api/?name=Admin+Avicenna&background=f1f5f9&color=0f172a" alt="User" class="w-9 h-9 rounded-full">
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-slate-800">Admin</p>
                        <p class="text-xs text-slate-500">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-surface-50">
            
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-surface-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-softer z-40">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-brand-600 transition-colors focus:outline-none p-1 rounded-md">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                    
                    <!-- Global Search -->
                    <div class="hidden md:flex relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-magnifying-glass text-slate-400 group-focus-within:text-brand-500 transition-colors"></i>
                        </div>
                        <input type="text" class="block w-64 pl-10 pr-3 py-2 border-none bg-surface-100 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:bg-white transition-all text-slate-700" placeholder="Cari apapun (Ctrl+K)...">
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-slate-400 hover:text-brand-600 transition-colors rounded-full hover:bg-brand-50">
                        <i class="ph ph-bell text-xl"></i>
                        <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                    </button>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-surface-50 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
