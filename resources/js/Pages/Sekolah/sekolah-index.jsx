import React, { useState, useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import Chart from 'react-apexcharts';
import DataTable from '../../Components/DataTable';
import Alert from '../../Components/Alert';
import { useTheme } from '../../Contexts/ThemeContext';
import ConfirmModal from '../../Components/ConfirmModal';
import { UnitBadge, JenjangBadge } from '../../Components/TableBadges';

export default function SekolahIndex({
    jagakarsa, cinere, pamulang,
    prestasiJagakarsa, prestasiCinere, prestasiPamulang,
    tingkatJagakarsa, tingkatCinere, tingkatPamulang,
    tahunJagakarsa, tahunCinere, tahunPamulang, tahunLabels,
    sekolahs, flash
}) {
    const { isDarkMode } = useTheme();
    const { delete: destroy } = useForm();
    const [confirmModal, setConfirmModal] = useState({ isOpen: false, id: null });

    const handleDelete = (id) => {
        setConfirmModal({ isOpen: true, id });
    };

    const confirmDelete = () => {
        destroy('/sekolah/' + confirmModal.id);
        setConfirmModal({ isOpen: false, id: null });
    };

    const getPieOptions = (data) => ({
        series: data.map(d => d.y),
        options: {
            chart: {
                type: 'donut',
                fontFamily: '"Plus Jakarta Sans", sans-serif',
                background: 'transparent',
                foreColor: isDarkMode ? '#cbd5e1' : '#64748b'
            },
            theme: { mode: isDarkMode ? 'dark' : 'light' },
            labels: data.map(d => d.name),
            colors: ['#696cff', '#8592a3', '#71dd37', '#ffab00', '#ff3e1d'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: { fontSize: '12px' },
                            value: { fontSize: '20px', fontWeight: 700, color: isDarkMode ? '#f8fafc' : '#1e293b' },
                            total: { show: true, showAlways: true, label: 'Total', fontSize: '14px' }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            stroke: { show: false },
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                itemMargin: { horizontal: 10, vertical: 5 }
            }
        }
    });

    const prestasiTahunOptions = {
        chart: {
            type: 'line',
            toolbar: { show: false },
            fontFamily: '"Plus Jakarta Sans", sans-serif',
            background: 'transparent',
            foreColor: isDarkMode ? '#cbd5e1' : '#64748b'
        },
        theme: { mode: isDarkMode ? 'dark' : 'light' },
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 5, hover: { size: 7 } },
        colors: ['#696cff', '#71dd37', '#ffab00'],
        xaxis: {
            categories: tahunLabels,
            title: { text: 'Tahun Pelajaran' },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            min: 0,
            title: { text: 'Jumlah Prestasi' },
            decimalsInFloat: 0,
            forceNiceScale: true
        },
        grid: {
            borderColor: isDarkMode ? '#334155' : '#f1f5f9',
            strokeDashArray: 4
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right'
        }
    };

    const prestasiTahunSeries = [
        { name: 'Jagakarsa', data: tahunJagakarsa },
        { name: 'Cinere', data: tahunCinere },
        { name: 'Pamulang', data: tahunPamulang }
    ];

    const columns = useMemo(() => [
        {
            accessorKey: 'nama_sekolah',
            header: 'Nama Sekolah',
            cell: info => <span className="font-semibold text-slate-800 dark:text-slate-200">{info.getValue()}</span>
        },
        {
            accessorKey: 'unit',
            header: 'Unit',
            cell: info => <UnitBadge unit={info.getValue()} />
        },
        {
            accessorKey: 'jenjang',
            header: 'Jenjang',
            cell: info => <JenjangBadge jenjang={info.getValue()} />
        },
        {
            accessorKey: 'alamat',
            header: 'Alamat',
            cell: info => info.getValue() || '-'
        },
        {
            id: 'actions',
            header: 'Aksi',
            cell: info => (
                <div className="flex items-center gap-2">
                    <Link
                        href={`/sekolah/${info.row.original.id}/edit`}
                        className="px-3 py-1.5 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg text-sm font-medium hover:bg-amber-100 dark:hover:bg-amber-500/20 transition-colors flex items-center gap-1.5"
                    >
                        <i className="ph ph-pencil-simple"></i> Edit
                    </Link>
                    <button
                        onClick={() => handleDelete(info.row.original.id)}
                        className="px-3 py-1.5 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors flex items-center gap-1.5"
                    >
                        <i className="ph ph-trash"></i> Hapus
                    </button>
                </div>
            )
        }
    ], []);

    return (
        <AuthenticatedLayout>
            <Head title="Master Sekolah & Prestasi" />

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Master Sekolah & Grafik Prestasi</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Laporan prestasi dan kelola data master unit sekolah.</p>
                </div>
            </div>

            <Alert type="success" message={flash?.success} />

            {/* Charts Prestasi */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 flex flex-col">
                    <h6 className="text-base font-bold text-slate-800 dark:text-white mb-4">Tingkat Lomba - Jagakarsa</h6>
                    <div className="flex-1 flex items-center justify-center min-h-[300px]">
                        {tingkatJagakarsa && tingkatJagakarsa.length > 0 ? (
                            <Chart className="w-full" options={getPieOptions(tingkatJagakarsa).options} series={getPieOptions(tingkatJagakarsa).series} type="donut" height={320} />
                        ) : (
                            <div className="text-center text-slate-400 flex flex-col items-center">
                                <i className="ph ph-chart-donut text-5xl mb-3 text-slate-300 dark:text-slate-600"></i>
                                <p className="text-sm font-medium">Belum ada data prestasi</p>
                            </div>
                        )}
                    </div>
                </div>
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 flex flex-col">
                    <h6 className="text-base font-bold text-slate-800 dark:text-white mb-4">Tingkat Lomba - Cinere</h6>
                    <div className="flex-1 flex items-center justify-center min-h-[300px]">
                        {tingkatCinere && tingkatCinere.length > 0 ? (
                            <Chart className="w-full" options={getPieOptions(tingkatCinere).options} series={getPieOptions(tingkatCinere).series} type="donut" height={320} />
                        ) : (
                            <div className="text-center text-slate-400 flex flex-col items-center">
                                <i className="ph ph-chart-donut text-5xl mb-3 text-slate-300 dark:text-slate-600"></i>
                                <p className="text-sm font-medium">Belum ada data prestasi</p>
                            </div>
                        )}
                    </div>
                </div>
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 flex flex-col">
                    <h6 className="text-base font-bold text-slate-800 dark:text-white mb-4">Tingkat Lomba - Pamulang</h6>
                    <div className="flex-1 flex items-center justify-center min-h-[300px]">
                        {tingkatPamulang && tingkatPamulang.length > 0 ? (
                            <Chart className="w-full" options={getPieOptions(tingkatPamulang).options} series={getPieOptions(tingkatPamulang).series} type="donut" height={320} />
                        ) : (
                            <div className="text-center text-slate-400 flex flex-col items-center">
                                <i className="ph ph-chart-donut text-5xl mb-3 text-slate-300 dark:text-slate-600"></i>
                                <p className="text-sm font-medium">Belum ada data prestasi</p>
                            </div>
                        )}
                    </div>
                </div>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 mb-8">
                <h6 className="text-base font-bold text-slate-800 dark:text-white mb-4">Prestasi per Tahun</h6>
                <div className="w-full">
                    <Chart className="w-full" options={prestasiTahunOptions} series={prestasiTahunSeries} type="line" height={350} />
                </div>
            </div>

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h2 className="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <i className="ph ph-buildings text-brand-500"></i> Data Master Sekolah
                    </h2>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola data seluruh unit sekolah di bawah naungan yayasan.</p>
                </div>
                <Link
                    href="/sekolah/create"
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 transition-all"
                >
                    <i className="ph ph-plus mr-2 text-lg"></i>
                    Tambah Sekolah
                </Link>
            </div>

            <DataTable columns={columns} data={sekolahs} searchable={true} />
            
            <ConfirmModal
                isOpen={confirmModal.isOpen}
                onClose={() => setConfirmModal({ isOpen: false, id: null })}
                onConfirm={confirmDelete}
                title="Hapus Master Sekolah?"
                message="Data sekolah yang dihapus tidak dapat dikembalikan."
            />
        </AuthenticatedLayout>
    );
}
