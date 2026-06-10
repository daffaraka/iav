import React, { useMemo } from 'react';
import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';

export default function PrestasiSekolah({ prestasi, sekolah }) {

    const columns = useMemo(() => [
        {
            accessorKey: 'siswa.nama',
            header: 'Nama Siswa',
            cell: info => <span className="font-semibold text-slate-800 dark:text-slate-200">{info.getValue() || '-'}</span>
        },
        {
            accessorKey: 'nama_lomba',
            header: 'Nama Lomba'
        },
        {
            accessorKey: 'tingkat_lomba',
            header: 'Tingkat'
        },
        {
            accessorKey: 'status_lomba',
            header: 'Status',
            cell: info => {
                const val = info.getValue();
                return <span className={`px-2 py-1 rounded text-xs font-medium ${val === 'Terkurasi' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400'}`}>{val}</span>;
            }
        },
        {
            accessorKey: 'tahun_pelajaran',
            header: 'Tahun'
        },
        {
            id: 'actions',
            header: 'Aksi',
            cell: info => (
                <div className="flex items-center gap-1.5 flex-wrap">
                    <Link
                        href={route('data-prestasi.show', info.row.original.id)}
                        className="px-2.5 py-1.5 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-medium hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors"
                    >
                        Lihat
                    </Link>
                </div>
            )
        }
    ], []);

    return (
        <AuthenticatedLayout>
            <Head title={`Data Prestasi - ${sekolah}`} />

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Data Prestasi {sekolah}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar semua prestasi untuk unit sekolah ini.</p>
                </div>
                <Link
                    href={route('data-prestasi.index')}
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 dark:bg-surface-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium hover:bg-surface-200 dark:hover:bg-surface-600 transition-all"
                >
                    <i className="ph ph-arrow-left mr-2 text-lg"></i>
                    Kembali
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 overflow-hidden">
                <DataTable columns={columns} data={prestasi} searchable={true} />
            </div>
        </AuthenticatedLayout>
    );
}
