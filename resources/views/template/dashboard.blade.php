@extends('template.layout')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Overview</h1>
            <p class="text-sm text-slate-500 mt-1">Selamat datang kembali, lihat ringkasan data terbaru hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-white border border-surface-200 text-slate-600 rounded-xl text-sm font-medium shadow-softer hover:bg-surface-50 transition-colors flex items-center">
                <i class="ph ph-calendar-blank mr-2 text-lg"></i>
                Hari Ini
            </button>
            <button class="px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 transition-colors flex items-center">
                <i class="ph ph-plus mr-2 text-lg"></i>
                Tiket Baru
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl border border-surface-100 shadow-soft relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-brand-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Total Tiket Bulan Ini</p>
                    <h3 class="text-3xl font-bold text-slate-800">1,248</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                    <i class="ph ph-ticket text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative z-10">
                <span class="text-emerald-500 font-medium flex items-center bg-emerald-50 px-2 py-0.5 rounded-md">
                    <i class="ph ph-trend-up mr-1"></i> +12%
                </span>
                <span class="text-slate-400 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-surface-100 shadow-soft relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Tiket Selesai</p>
                    <h3 class="text-3xl font-bold text-slate-800">956</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="ph ph-check-circle text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative z-10">
                <span class="text-emerald-500 font-medium flex items-center bg-emerald-50 px-2 py-0.5 rounded-md">
                    <i class="ph ph-trend-up mr-1"></i> +5.4%
                </span>
                <span class="text-slate-400 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl border border-surface-100 shadow-soft relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-amber-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Menunggu Respon</p>
                    <h3 class="text-3xl font-bold text-slate-800">42</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i class="ph ph-clock text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative z-10">
                <span class="text-amber-500 font-medium flex items-center bg-amber-50 px-2 py-0.5 rounded-md">
                    <i class="ph ph-minus mr-1"></i> 0%
                </span>
                <span class="text-slate-400 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-6 rounded-2xl border border-surface-100 shadow-soft relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Kepuasan Layanan</p>
                    <h3 class="text-3xl font-bold text-slate-800">4.8<span class="text-lg text-slate-400 font-normal">/5</span></h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i class="ph ph-star text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative z-10">
                <span class="text-emerald-500 font-medium flex items-center bg-emerald-50 px-2 py-0.5 rounded-md">
                    <i class="ph ph-trend-up mr-1"></i> +0.2
                </span>
                <span class="text-slate-400 ml-2">dari bulan lalu</span>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-surface-100 shadow-soft p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-slate-800">Tren Tiket Masuk</h2>
                <select class="text-sm border-none bg-surface-50 text-slate-600 rounded-lg focus:ring-0 cursor-pointer">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
            <div id="mainChart" class="w-full h-72"></div>
        </div>

        <!-- Doughnut Chart -->
        <div class="bg-white rounded-2xl border border-surface-100 shadow-soft p-6 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-slate-800">Distribusi Kategori</h2>
                <button class="text-slate-400 hover:text-brand-500"><i class="ph ph-dots-three text-xl"></i></button>
            </div>
            <div id="donutChart" class="w-full flex-1 flex items-center justify-center"></div>
        </div>
    </div>

    <!-- Live Search / Datatable Section -->
    <div class="bg-white rounded-2xl border border-surface-100 shadow-soft overflow-hidden" 
         x-data="dataTable()">
        
        <!-- Table Header & Search -->
        <div class="p-6 border-b border-surface-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
            <h2 class="text-lg font-bold text-slate-800">Tiket Terbaru</h2>
            
            <div class="relative w-full sm:w-72 group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ph ph-magnifying-glass text-slate-400 group-focus-within:text-brand-500 transition-colors"></i>
                </div>
                <!-- x-model binds this input to Alpine's searchQuery -->
                <input x-model="searchQuery" type="text" class="block w-full pl-10 pr-3 py-2 border border-surface-200 bg-surface-50 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all text-slate-700 shadow-sm" placeholder="Cari ID, Judul, atau Kategori...">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-50/50 text-slate-500 text-xs uppercase tracking-wider border-b border-surface-100">
                        <th class="px-6 py-4 font-semibold">ID Tiket</th>
                        <th class="px-6 py-4 font-semibold">Judul Kendala</th>
                        <th class="px-6 py-4 font-semibold">Kategori</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-100">
                    <!-- Loop through filtered items using Alpine -->
                    <template x-for="item in filteredItems" :key="item.id">
                        <tr class="hover:bg-surface-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-slate-800" x-text="item.id"></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-700 font-medium" x-text="item.judul"></div>
                                <div class="text-xs text-slate-400 mt-0.5" x-text="item.pelapor"></div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-surface-100 text-slate-600 border border-surface-200" x-text="item.kategori"></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium"
                                      :class="{
                                          'bg-amber-50 text-amber-700 border border-amber-200': item.status === 'Proses',
                                          'bg-emerald-50 text-emerald-700 border border-emerald-200': item.status === 'Selesai',
                                          'bg-blue-50 text-blue-700 border border-blue-200': item.status === 'Baru'
                                      }">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5"
                                          :class="{
                                              'bg-amber-500': item.status === 'Proses',
                                              'bg-emerald-500': item.status === 'Selesai',
                                              'bg-blue-500': item.status === 'Baru'
                                          }"></span>
                                    <span x-text="item.status"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500" x-text="item.tanggal"></span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors">
                                    <i class="ph ph-eye text-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <!-- Empty State -->
                    <tr x-show="filteredItems.length === 0" x-cloak>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <i class="ph ph-magnifying-glass text-4xl mb-3 text-slate-300"></i>
                            <p>Data tidak ditemukan untuk "<span x-text="searchQuery" class="font-semibold"></span>"</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Dummy -->
        <div class="px-6 py-4 border-t border-surface-100 flex items-center justify-between bg-white">
            <span class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-800">1</span> sampai <span class="font-medium text-slate-800">5</span> dari <span class="font-medium text-slate-800">12</span> data</span>
            <div class="flex gap-1">
                <button class="px-3 py-1.5 border border-surface-200 rounded-lg text-sm font-medium text-slate-400 cursor-not-allowed bg-surface-50">Sebelumnnya</button>
                <button class="px-3 py-1.5 border border-surface-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-surface-50 transition-colors">Selanjutnya</button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// --- ApexCharts Configuration (Modern & Soft Colors) ---
document.addEventListener('DOMContentLoaded', function () {
    
    // Main Area Chart
    var optionsMain = {
        series: [{
            name: 'Tiket Masuk',
            data: [31, 40, 28, 51, 42, 109, 100]
        }, {
            name: 'Tiket Selesai',
            data: [11, 32, 45, 32, 34, 52, 41]
        }],
        chart: {
            height: 300,
            type: 'area',
            fontFamily: 'Inter, sans-serif',
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        colors: ['#14b8a6', '#6366f1'], // Soft Teal & Soft Indigo
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        xaxis: {
            categories: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: { colors: '#94a3b8', fontSize: '12px' }
            }
        },
        yaxis: {
            labels: {
                style: { colors: '#94a3b8', fontSize: '12px' }
            }
        },
        grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4,
            yaxis: { lines: { show: true } },
            xaxis: { lines: { show: false } },
            padding: { top: 0, right: 0, bottom: 0, left: 10 }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            markers: { radius: 12 },
            itemMargin: { horizontal: 10, vertical: 0 }
        }
    };
    new ApexCharts(document.querySelector("#mainChart"), optionsMain).render();

    // Donut Chart
    var optionsDonut = {
        series: [44, 55, 13, 33],
        labels: ['Fasilitas', 'Akademik', 'Keuangan', 'IT Support'],
        chart: {
            type: 'donut',
            height: 280,
            fontFamily: 'Inter, sans-serif',
        },
        colors: ['#38bdf8', '#818cf8', '#34d399', '#f472b6'], // Soft Blue, Indigo, Emerald, Pink
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    labels: {
                        show: true,
                        name: { fontSize: '12px', color: '#64748b' },
                        value: {
                            fontSize: '24px',
                            fontWeight: 700,
                            color: '#1e293b',
                            formatter: function (val) { return val }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            fontSize: '14px',
                            color: '#64748b'
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        stroke: { show: false },
        legend: { show: false }
    };
    new ApexCharts(document.querySelector("#donutChart"), optionsDonut).render();
});

// --- Alpine.js Data for Live Search Table ---
function dataTable() {
    return {
        searchQuery: '',
        items: [
            { id: 'AQR-001', judul: 'AC Kelas 10A Mati', pelapor: 'Budi Santoso', kategori: 'Fasilitas Sarpras', status: 'Baru', tanggal: '12 Okt 2026' },
            { id: 'AQR-002', judul: 'Lupa Password E-Learning', pelapor: 'Siti Aminah', kategori: 'IT', status: 'Selesai', tanggal: '12 Okt 2026' },
            { id: 'AQR-003', judul: 'Jadwal Ekskul Basket Bentrok', pelapor: 'Agus Pratama', kategori: 'Akademik', status: 'Proses', tanggal: '11 Okt 2026' },
            { id: 'AQR-004', judul: 'Buku Seragam Belum Diterima', pelapor: 'Ibu Rina', kategori: 'Koperasi', status: 'Proses', tanggal: '11 Okt 2026' },
            { id: 'AQR-005', judul: 'Pembayaran SPP Gagal', pelapor: 'Bapak Joko', kategori: 'Keuangan', status: 'Selesai', tanggal: '10 Okt 2026' },
        ],
        get filteredItems() {
            if (this.searchQuery === '') {
                return this.items;
            }
            const lowerCaseQuery = this.searchQuery.toLowerCase();
            return this.items.filter(item => {
                return item.id.toLowerCase().includes(lowerCaseQuery) ||
                       item.judul.toLowerCase().includes(lowerCaseQuery) ||
                       item.pelapor.toLowerCase().includes(lowerCaseQuery) ||
                       item.kategori.toLowerCase().includes(lowerCaseQuery);
            });
        }
    }
}
</script>
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
