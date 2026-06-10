import React, { useState, useMemo } from 'react';
import { Head } from '@inertiajs/react';
import Chart from 'react-apexcharts';
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout';
import { useTheme } from '../Contexts/ThemeContext';

export default function DashboardPrototype() {
    const { isDarkMode } = useTheme();
    const [searchQuery, setSearchQuery] = useState('');

    // Dummy Data
    const items = [
        { id: 'AQR-001', judul: 'AC Kelas 10A Mati', pelapor: 'Budi Santoso', kategori: 'Fasilitas Sarpras', status: 'Baru', tanggal: '12 Okt 2026' },
        { id: 'AQR-002', judul: 'Lupa Password E-Learning', pelapor: 'Siti Aminah', kategori: 'IT', status: 'Selesai', tanggal: '12 Okt 2026' },
        { id: 'AQR-003', judul: 'Jadwal Ekskul Basket Bentrok', pelapor: 'Agus Pratama', kategori: 'Akademik', status: 'Proses', tanggal: '11 Okt 2026' },
        { id: 'AQR-004', judul: 'Buku Seragam Belum Diterima', pelapor: 'Ibu Rina', kategori: 'Koperasi', status: 'Proses', tanggal: '11 Okt 2026' },
        { id: 'AQR-005', judul: 'Pembayaran SPP Gagal', pelapor: 'Bapak Joko', kategori: 'Keuangan', status: 'Selesai', tanggal: '10 Okt 2026' },
    ];

    // Filter Logic
    const filteredItems = useMemo(() => {
        if (!searchQuery) return items;
        const lower = searchQuery.toLowerCase();
        return items.filter(item => 
            item.id.toLowerCase().includes(lower) ||
            item.judul.toLowerCase().includes(lower) ||
            item.pelapor.toLowerCase().includes(lower) ||
            item.kategori.toLowerCase().includes(lower)
        );
    }, [searchQuery, items]);

    // Main Chart Options
    const mainChartOptions = {
        chart: {
            fontFamily: '"Plus Jakarta Sans", sans-serif',
            toolbar: { show: false },
            zoom: { enabled: false },
            background: 'transparent',
            foreColor: isDarkMode ? '#cbd5e1' : '#64748b'
        },
        theme: { mode: isDarkMode ? 'dark' : 'light' },
        colors: ['#14b8a6', '#6366f1'],
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
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        grid: {
            borderColor: isDarkMode ? '#334155' : '#f1f5f9',
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

    const mainChartSeries = [
        { name: 'Tiket Masuk', data: [31, 40, 28, 51, 42, 109, 100] },
        { name: 'Tiket Selesai', data: [11, 32, 45, 32, 34, 52, 41] }
    ];

    // Donut Chart Options
    const donutChartOptions = {
        labels: ['Fasilitas', 'Akademik', 'Keuangan', 'IT Support'],
        chart: { 
            fontFamily: '"Plus Jakarta Sans", sans-serif',
            background: 'transparent',
            foreColor: isDarkMode ? '#cbd5e1' : '#64748b'
        },
        theme: { mode: isDarkMode ? 'dark' : 'light' },
        colors: ['#38bdf8', '#818cf8', '#34d399', '#f472b6'],
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    labels: {
                        show: true,
                        name: { fontSize: '12px' },
                        value: { fontSize: '24px', fontWeight: 700, color: isDarkMode ? '#f8fafc' : '#1e293b' },
                        total: { show: true, showAlways: true, label: 'Total', fontSize: '14px' }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        stroke: { show: false },
        legend: { show: false }
    };

    const donutChartSeries = [44, 55, 13, 33];

    return (
        <AuthenticatedLayout>
            <Head title="Dashboard" />
            
            {/* Page Header */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Dashboard Overview</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-300 mt-1">Selamat datang kembali, lihat ringkasan data terbaru hari ini.</p>
                </div>
                <div className="flex items-center gap-3">
                    <button className="px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 transition-colors flex items-center">
                        <i className="ph ph-plus mr-2 text-lg"></i>
                        Tiket Baru
                    </button>
                </div>
            </div>

            {/* Summary Cards */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft relative overflow-hidden group transition-colors duration-300">
                    <div className="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-brand-50 dark:bg-brand-500/10 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div className="flex justify-between items-start relative z-10">
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-300 mb-1">Total Tiket</p>
                            <h3 className="text-3xl font-bold text-slate-800 dark:text-white">1,248</h3>
                        </div>
                        <div className="w-10 h-10 rounded-xl bg-brand-50 dark:bg-brand-500/20 text-brand-600 dark:text-brand-400 flex items-center justify-center">
                            <i className="ph ph-ticket text-xl"></i>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft relative overflow-hidden group transition-colors duration-300">
                    <div className="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 dark:bg-blue-500/10 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div className="flex justify-between items-start relative z-10">
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-300 mb-1">Tiket Selesai</p>
                            <h3 className="text-3xl font-bold text-slate-800 dark:text-white">956</h3>
                        </div>
                        <div className="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                            <i className="ph ph-check-circle text-xl"></i>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft relative overflow-hidden group transition-colors duration-300">
                    <div className="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-amber-50 dark:bg-amber-500/10 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div className="flex justify-between items-start relative z-10">
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-300 mb-1">Menunggu Respon</p>
                            <h3 className="text-3xl font-bold text-slate-800 dark:text-white">42</h3>
                        </div>
                        <div className="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                            <i className="ph ph-clock text-xl"></i>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft relative overflow-hidden group transition-colors duration-300">
                    <div className="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-50 dark:bg-indigo-500/10 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div className="flex justify-between items-start relative z-10">
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-300 mb-1">Kepuasan</p>
                            <h3 className="text-3xl font-bold text-slate-800 dark:text-white">4.8</h3>
                        </div>
                        <div className="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                            <i className="ph ph-star text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {/* Chart Section */}
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div className="lg:col-span-2 bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 transition-colors duration-300">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4">Tren Tiket Masuk</h2>
                    <Chart options={mainChartOptions} series={mainChartSeries} type="area" height={300} />
                </div>
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 flex flex-col transition-colors duration-300">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4">Distribusi Kategori</h2>
                    <div className="flex-1 flex items-center justify-center">
                        <Chart options={donutChartOptions} series={donutChartSeries} type="donut" height={280} />
                    </div>
                </div>
            </div>

            {/* Datatable Section */}
            <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden transition-colors duration-300">
                <div className="p-4 lg:p-6 border-b border-surface-100 dark:border-surface-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white">Tiket Terbaru</h2>
                    <div className="relative w-full sm:w-72 group">
                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i className="ph ph-magnifying-glass text-slate-400 group-focus-within:text-brand-500 transition-colors"></i>
                        </div>
                        <input 
                            type="text" 
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            className="block w-full pl-10 pr-3 py-2 border border-surface-200 dark:border-surface-600 bg-surface-50 dark:bg-surface-900 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all text-slate-700 dark:text-slate-200 shadow-sm" 
                            placeholder="Cari ID, Judul, atau Kategori..." 
                        />
                    </div>
                </div>

                <div className="overflow-x-auto">
                    <table className="w-full text-left border-collapse">
                        <thead>
                            <tr className="bg-surface-50/50 dark:bg-surface-800/50 text-slate-500 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-surface-100 dark:border-surface-700">
                                <th className="px-6 py-4 font-semibold whitespace-nowrap">ID Tiket</th>
                                <th className="px-6 py-4 font-semibold min-w-[200px]">Judul Kendala</th>
                                <th className="px-6 py-4 font-semibold whitespace-nowrap">Kategori</th>
                                <th className="px-6 py-4 font-semibold whitespace-nowrap">Status</th>
                                <th className="px-6 py-4 font-semibold whitespace-nowrap">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-surface-100 dark:divide-surface-700">
                            {filteredItems.map(item => (
                                <tr key={item.id} className="hover:bg-surface-50/50 dark:hover:bg-surface-700/50 transition-colors group">
                                    <td className="px-6 py-4 whitespace-nowrap">
                                        <span className="text-sm font-semibold text-slate-800 dark:text-white">{item.id}</span>
                                    </td>
                                    <td className="px-6 py-4">
                                        <div className="text-sm text-slate-700 dark:text-slate-200 font-medium">{item.judul}</div>
                                        <div className="text-xs text-slate-400 dark:text-slate-400 mt-0.5">{item.pelapor}</div>
                                    </td>
                                    <td className="px-6 py-4 whitespace-nowrap">
                                        <span className="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-surface-100 dark:bg-surface-700 text-slate-600 dark:text-slate-300 border border-surface-200 dark:border-surface-600">{item.kategori}</span>
                                    </td>
                                    <td className="px-6 py-4 whitespace-nowrap">
                                        <span className={`inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border ${
                                            item.status === 'Proses' ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20' :
                                            item.status === 'Selesai' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20' :
                                            'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/20'
                                        }`}>
                                            <span className={`w-1.5 h-1.5 rounded-full mr-1.5 ${
                                                item.status === 'Proses' ? 'bg-amber-500' :
                                                item.status === 'Selesai' ? 'bg-emerald-500' :
                                                'bg-blue-500'
                                            }`}></span>
                                            {item.status}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 whitespace-nowrap">
                                        <span className="text-sm text-slate-500 dark:text-slate-300">{item.tanggal}</span>
                                    </td>
                                </tr>
                            ))}
                            {filteredItems.length === 0 && (
                                <tr>
                                    <td colSpan="5" className="px-6 py-12 text-center text-slate-500 dark:text-slate-300">
                                        <i className="ph ph-magnifying-glass text-4xl mb-3 text-slate-300 dark:text-slate-600"></i>
                                        <p>Data tidak ditemukan untuk "<span className="font-semibold">{searchQuery}</span>"</p>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
