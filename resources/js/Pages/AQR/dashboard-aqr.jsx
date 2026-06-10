import React, { useState, useMemo, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import Chart from 'react-apexcharts';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import { useTheme } from '../../Contexts/ThemeContext';
import DataTable from '../../Components/DataTable';

export default function Dashboard({ 
    stats, 
    latestTiket, 
    latestProses, 
    latestSelesai, 
    pieChartData, 
    barChartData, 
    weekLabels, 
    lokasiChartData, 
    typePengirimChart,
    listPsikolog,
    userRoles
}) {
    const { isDarkMode } = useTheme();

    // Check if user has roles that can see new tickets
    const canSeeNewTickets = useMemo(() => {
        if (!userRoles) return false;
        return userRoles.some(role => ['super-admin', 'kepala-tata-usaha', 'kepala-psikolog', 'humas', 'kepala-sekolah'].includes(role));
    }, [userRoles]);

    // Trend Chart (Bar/Area Chart based on Weeks)
    const mainChartOptions = {
        chart: {
            fontFamily: '"Plus Jakarta Sans", sans-serif',
            toolbar: { show: false },
            zoom: { enabled: false },
            background: 'transparent',
            foreColor: isDarkMode ? '#cbd5e1' : '#64748b'
        },
        theme: { mode: isDarkMode ? 'dark' : 'light' },
        colors: [
            '#3b82f6', '#10b981', '#f59e0b', '#ef4444', 
            '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6', 
            '#f97316', '#6366f1', '#64748b', '#84cc16'
        ],
        fill: {
            type: 'solid',
            opacity: 0.8
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            categories: weekLabels.map(w => `Minggu ke-${w}`),
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
        yaxis: {
            decimalsInFloat: 0,
            forceNiceScale: true,
            labels: {
                formatter: (val) => Math.round(val)
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            markers: { radius: 12 },
            itemMargin: { horizontal: 10, vertical: 8 }
        }
    };

    // Mapping Status Distribution (Pie Chart)
    const statusLabels = pieChartData.map(item => item.name);
    const statusSeries = pieChartData.map(item => item.y);

    const donutChartOptions = {
        labels: statusLabels,
        chart: { 
            fontFamily: '"Plus Jakarta Sans", sans-serif',
            background: 'transparent',
            foreColor: isDarkMode ? '#cbd5e1' : '#64748b'
        },
        theme: { mode: isDarkMode ? 'dark' : 'light' },
        colors: ['#3b82f6', '#f59e0b', '#10b981'], // Biru(Baru), Kuning/Oranye(Proses), Hijau(Selesai)
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    labels: {
                        show: true,
                        name: { fontSize: '12px' },
                        value: { fontSize: '24px', fontWeight: 700, color: isDarkMode ? '#f8fafc' : '#1e293b' },
                        total: { show: true, showAlways: true, label: 'Total Tiket', fontSize: '14px' }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        stroke: { show: false },
        legend: { show: false }
    };

    // Lokasi Chart
    const lokasiDonutOptions = {
        ...donutChartOptions,
        labels: lokasiChartData ? lokasiChartData.map(d => d.name) : [],
        colors: [
            '#3b82f6', '#10b981', '#f59e0b', '#ef4444', 
            '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6', 
            '#f97316', '#6366f1', '#64748b', '#84cc16'
        ],
        legend: { 
            show: true, 
            position: 'bottom',
            horizontalAlign: 'center',
            itemMargin: { horizontal: 15, vertical: 8 }
        },
        plotOptions: { pie: { donut: { ...donutChartOptions.plotOptions.pie.donut, labels: { ...donutChartOptions.plotOptions.pie.donut.labels, total: { ...donutChartOptions.plotOptions.pie.donut.labels.total, label: 'Total' } } } } }
    };

    // Pengirim Chart
    const pengirimDonutOptions = {
        ...donutChartOptions,
        labels: typePengirimChart ? typePengirimChart.map(d => d.name) : [],
        colors: [
            '#3b82f6', '#10b981', '#f59e0b', '#ef4444', 
            '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6'
        ],
        legend: { 
            show: true, 
            position: 'bottom',
            horizontalAlign: 'center',
            itemMargin: { horizontal: 15, vertical: 8 }
        },
        plotOptions: { pie: { donut: { ...donutChartOptions.plotOptions.pie.donut, labels: { ...donutChartOptions.plotOptions.pie.donut.labels, total: { ...donutChartOptions.plotOptions.pie.donut.labels.total, label: 'Total' } } } } }
    };

    const formatDate = (dateString) => {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(date);
    };

    // Data table columns for listPsikolog
    const psikologColumns = useMemo(() => [
        {
            id: 'nama_email',
            header: 'Nama & Email',
            cell: info => {
                const p = info.row.original;
                return (
                    <div>
                        <div className="text-sm font-semibold text-slate-800 dark:text-white">{p.name}</div>
                        <div className="text-xs text-slate-500 mt-0.5">{p.email}</div>
                    </div>
                );
            }
        },
        {
            accessorKey: 'unit',
            header: 'Unit',
            cell: info => {
                const val = info.getValue();
                let colorClass = 'bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300';
                if(val === 'Jagakarsa') colorClass = 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400';
                if(val === 'Pamulang') colorClass = 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400';
                if(val === 'Cinere') colorClass = 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400';
                return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-medium ${colorClass}`}>{val || '-'}</span>;
            }
        },
        {
            accessorKey: 'jenjang',
            header: 'Jenjang',
            cell: info => {
                const val = info.getValue();
                if (!val) return '-';
                let colorClass = 'border-indigo-200 bg-indigo-50 text-indigo-700 dark:border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-400';
                if(val === 'TK') colorClass = 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-400';
                if(val === 'SD') colorClass = 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400';
                if(val === 'SMP') colorClass = 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400';
                if(val === 'SMA') colorClass = 'border-red-200 bg-red-50 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400';
                return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-medium border ${colorClass}`}>{val}</span>;
            }
        },
        {
            accessorKey: 'roles',
            header: 'Roles',
            cell: info => {
                const roles = info.getValue() || [];
                return (
                    <div className="flex flex-wrap gap-1">
                        {roles.map(role => {
                            let colorClass = 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400';
                            if(role.name === 'kepala-psikolog') colorClass = 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400';
                            if(role.name === 'psikolog') colorClass = 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400';
                            return (
                                <span key={role.id} className={`inline-flex px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wider ${colorClass}`}>
                                    {role.name}
                                </span>
                            );
                        })}
                    </div>
                );
            }
        }
    ], []);

    return (
        <AuthenticatedLayout>
            <Head title="AQR Dashboard" />
            
            {/* Page Header */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Dashboard AQR</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-300 mt-1">Ringkasan tiket keluhan dan permintaan secara real-time.</p>
                </div>
                <div className="flex items-center gap-3">
                    <Link href="/dashboard/aqr/tiket/create" className="px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 transition-colors flex items-center">
                        <i className="ph ph-plus mr-2 text-lg"></i>
                        Buat Tiket Baru
                    </Link>
                </div>
            </div>

            {/* Summary Cards */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mt-6">
                <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-sm relative overflow-hidden group">
                    <div className="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/4 w-32 h-32 bg-emerald-400 dark:bg-emerald-400/80 rounded-full opacity-80"></div>
                    <div className="flex justify-between items-center relative z-10 h-full">
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Tiket</p>
                            <h3 className="text-3xl font-bold text-slate-800 dark:text-white">{stats.total}</h3>
                        </div>
                        <div className="w-12 h-12 rounded-2xl bg-emerald-100/50 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center relative z-10 backdrop-blur-sm">
                            <i className="ph ph-ticket text-2xl"></i>
                        </div>
                    </div>
                </div>
                {canSeeNewTickets && (
                    <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-sm relative overflow-hidden group">
                        <div className="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/4 w-32 h-32 bg-blue-400 dark:bg-blue-400/80 rounded-full opacity-80"></div>
                        <div className="flex justify-between items-center relative z-10 h-full">
                            <div>
                                <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Tiket Baru</p>
                                <h3 className="text-3xl font-bold text-slate-800 dark:text-white">{stats.new}</h3>
                            </div>
                            <div className="w-12 h-12 rounded-2xl bg-blue-100/50 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center relative z-10 backdrop-blur-sm">
                                <i className="ph ph-envelope-open text-2xl"></i>
                            </div>
                        </div>
                    </div>
                )}
                <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-sm relative overflow-hidden group">
                    <div className="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/4 w-32 h-32 bg-amber-400 dark:bg-amber-400/80 rounded-full opacity-80"></div>
                    <div className="flex justify-between items-center relative z-10 h-full">
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Sedang Diproses</p>
                            <h3 className="text-3xl font-bold text-slate-800 dark:text-white">{stats.proses}</h3>
                        </div>
                        <div className="w-12 h-12 rounded-2xl bg-amber-100/50 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center relative z-10 backdrop-blur-sm">
                            <i className="ph ph-clock text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-sm relative overflow-hidden group">
                    <div className="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/4 w-32 h-32 bg-emerald-400 dark:bg-emerald-400/80 rounded-full opacity-80"></div>
                    <div className="flex justify-between items-center relative z-10 h-full">
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Tiket Selesai</p>
                            <h3 className="text-3xl font-bold text-slate-800 dark:text-white">{stats.closed}</h3>
                        </div>
                        <div className="w-12 h-12 rounded-2xl bg-emerald-100/50 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center relative z-10 backdrop-blur-sm">
                            <i className="ph ph-check-circle text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {/* 3 Columns Ticket Lists */}
            <div className={`grid grid-cols-1 ${canSeeNewTickets ? 'lg:grid-cols-3' : 'lg:grid-cols-2'} gap-6 mt-6`}>
                
                {/* Tiket Baru Column */}
                {canSeeNewTickets && (
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden flex flex-col h-[500px]">
                        <div className="p-4 border-b border-surface-100 dark:border-surface-700 bg-blue-400 dark:bg-blue-600 flex items-center justify-between sticky top-0 z-10">
                            <h2 className="text-base font-bold text-white flex items-center">
                                <span className="w-2 h-2 rounded-full bg-white mr-2"></span>
                                Tiket Baru
                            </h2>
                            <Link href="/dashboard/aqr/tiket?status=New" className="text-xs text-blue-100 hover:text-white font-medium">Lihat Semua</Link>
                        </div>
                        <div className="p-4 overflow-y-auto flex-1 custom-scrollbar">
                            <div className="space-y-3">
                                {latestTiket && latestTiket.length > 0 ? (
                                    latestTiket.map(tiket => (
                                        <div key={tiket.id} className="p-3 rounded-xl border border-surface-100 dark:border-surface-700 hover:border-brand-300 dark:hover:border-brand-700 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors group">
                                            <div className="flex justify-between items-start mb-2">
                                                <span className="text-xs font-bold text-slate-700 dark:text-slate-300">{tiket.kode_tiket}</span>
                                                <span className="text-[10px] text-slate-500">{formatDate(tiket.created_at)}</span>
                                            </div>
                                            <Link href={`/dashboard/aqr/tiket/${tiket.id}`} className="block">
                                                <h4 className="text-sm font-semibold text-brand-600 dark:text-brand-400 hover:underline line-clamp-2 mb-1">{tiket.judul_kendala}</h4>
                                                <p className="text-xs text-slate-500 dark:text-slate-400 line-clamp-1">{tiket.nama || tiket.pengirim}</p>
                                            </Link>
                                            <div className="mt-2 pt-2 border-t border-surface-100 dark:border-surface-700 flex justify-between items-center">
                                                <span className="text-[10px] font-medium bg-surface-100 dark:bg-surface-700 text-slate-600 dark:text-slate-300 px-1.5 py-0.5 rounded">{tiket.lokasi_kendala}</span>
                                                <span className="text-[10px] font-medium bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400 px-1.5 py-0.5 rounded">Baru</span>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div className="text-center py-8 text-slate-500 dark:text-slate-400">
                                        <i className="ph ph-envelope-open text-3xl mb-2 text-slate-300 dark:text-slate-600"></i>
                                        <p className="text-sm">Tidak ada tiket baru.</p>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                )}

                {/* Tiket Proses Column */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden flex flex-col h-[500px]">
                    <div className="p-4 border-b border-surface-100 dark:border-surface-700 bg-amber-400 dark:bg-amber-600 flex items-center justify-between sticky top-0 z-10">
                        <h2 className="text-base font-bold text-white flex items-center">
                            <span className="w-2 h-2 rounded-full bg-white mr-2"></span>
                            Sedang Diproses
                        </h2>
                        <Link href="/dashboard/aqr/tiket?status=Proses" className="text-xs text-amber-100 hover:text-white font-medium">Lihat Semua</Link>
                    </div>
                    <div className="p-4 overflow-y-auto flex-1 custom-scrollbar">
                        <div className="space-y-3">
                            {latestProses && latestProses.length > 0 ? (
                                latestProses.map(tiket => (
                                    <div key={tiket.id} className="p-3 rounded-xl border border-surface-100 dark:border-surface-700 hover:border-brand-300 dark:hover:border-brand-700 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors group">
                                        <div className="flex justify-between items-start mb-2">
                                            <span className="text-xs font-bold text-slate-700 dark:text-slate-300">{tiket.kode_tiket}</span>
                                            <span className="text-[10px] text-slate-500">{formatDate(tiket.created_at)}</span>
                                        </div>
                                        <Link href={`/dashboard/aqr/tiket/${tiket.id}`} className="block">
                                            <h4 className="text-sm font-semibold text-brand-600 dark:text-brand-400 hover:underline line-clamp-2 mb-1">{tiket.judul_kendala}</h4>
                                            <p className="text-xs text-slate-500 dark:text-slate-400 line-clamp-1">{tiket.nama || tiket.pengirim}</p>
                                        </Link>
                                        <div className="mt-2 pt-2 border-t border-surface-100 dark:border-surface-700 flex justify-between items-center">
                                            <span className="text-[10px] font-medium bg-surface-100 dark:bg-surface-700 text-slate-600 dark:text-slate-300 px-1.5 py-0.5 rounded">{tiket.lokasi_kendala}</span>
                                            <span className="text-[10px] font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 px-1.5 py-0.5 rounded">Proses</span>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-slate-500 dark:text-slate-400">
                                    <i className="ph ph-clock text-3xl mb-2 text-slate-300 dark:text-slate-600"></i>
                                    <p className="text-sm">Tidak ada tiket diproses.</p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* Tiket Selesai Column */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden flex flex-col h-[500px]">
                    <div className="p-4 border-b border-surface-100 dark:border-surface-700 bg-emerald-400 dark:bg-emerald-600 flex items-center justify-between sticky top-0 z-10">
                        <h2 className="text-base font-bold text-white flex items-center">
                            <span className="w-2 h-2 rounded-full bg-white mr-2"></span>
                            Tiket Selesai
                        </h2>
                        <Link href="/dashboard/aqr/tiket?status=Selesai" className="text-xs text-emerald-100 hover:text-white font-medium">Lihat Semua</Link>
                    </div>
                    <div className="p-4 overflow-y-auto flex-1 custom-scrollbar">
                        <div className="space-y-3">
                            {latestSelesai && latestSelesai.length > 0 ? (
                                latestSelesai.map(tiket => (
                                    <div key={tiket.id} className="p-3 rounded-xl border border-surface-100 dark:border-surface-700 hover:border-brand-300 dark:hover:border-brand-700 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors group">
                                        <div className="flex justify-between items-start mb-2">
                                            <span className="text-xs font-bold text-slate-700 dark:text-slate-300">{tiket.kode_tiket}</span>
                                            <span className="text-[10px] text-slate-500">{formatDate(tiket.created_at)}</span>
                                        </div>
                                        <Link href={`/dashboard/aqr/tiket/${tiket.id}`} className="block">
                                            <h4 className="text-sm font-semibold text-brand-600 dark:text-brand-400 hover:underline line-clamp-2 mb-1">{tiket.judul_kendala}</h4>
                                            <p className="text-xs text-slate-500 dark:text-slate-400 line-clamp-1">{tiket.nama || tiket.pengirim}</p>
                                        </Link>
                                        <div className="mt-2 pt-2 border-t border-surface-100 dark:border-surface-700 flex justify-between items-center">
                                            <span className="text-[10px] font-medium bg-surface-100 dark:bg-surface-700 text-slate-600 dark:text-slate-300 px-1.5 py-0.5 rounded">{tiket.lokasi_kendala}</span>
                                            <span className="text-[10px] font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 px-1.5 py-0.5 rounded">Selesai</span>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-slate-500 dark:text-slate-400">
                                    <i className="ph ph-check-circle text-3xl mb-2 text-slate-300 dark:text-slate-600"></i>
                                    <p className="text-sm">Tidak ada tiket selesai.</p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>

            {/* Chart Section */}
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <div className="lg:col-span-2 bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 transition-colors duration-300">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4">Tren Tiket Berdasarkan Lokasi (4 Minggu Terakhir)</h2>
                    <div className="flex-1 flex items-center justify-center mt-2">
                        <Chart className="w-full" options={mainChartOptions} series={barChartData} type="bar" height={380} />
                    </div>
                </div>
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 flex flex-col transition-colors duration-300">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4">Status Keseluruhan</h2>
                    <div className="flex-1 flex items-center justify-center">
                        <Chart options={donutChartOptions} series={statusSeries} type="donut" height={280} />
                    </div>
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 flex flex-col transition-colors duration-300">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4">Tiket per Lokasi</h2>
                    <div className="flex-1 flex items-center justify-center">
                        <Chart className="w-full" options={lokasiDonutOptions} series={lokasiChartData ? lokasiChartData.map(d => d.y) : []} type="donut" height={450} />
                    </div>
                </div>
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 flex flex-col transition-colors duration-300">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4">Statistik Pengirim</h2>
                    <div className="flex-1 flex items-center justify-center">
                        <Chart className="w-full" options={pengirimDonutOptions} series={typePengirimChart ? typePengirimChart.map(d => d.y) : []} type="donut" height={450} />
                    </div>
                </div>
            </div>

            {/* List Psikolog */}
            {listPsikolog && listPsikolog.length > 0 && (
                <div className="mt-6">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                        <i className="ph ph-users-three mr-2 text-brand-500"></i>
                        Daftar PIC Psikolog
                    </h2>
                    <DataTable columns={psikologColumns} data={listPsikolog} searchable={true} />
                </div>
            )}
        </AuthenticatedLayout>
    );
}
