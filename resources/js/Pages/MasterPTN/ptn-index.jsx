import React, { useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';

export default function PtnIndex({ ptns, flash }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Yakin ingin menghapus data ini?')) {
            destroy(route('master-ptn.destroy', id));
        }
    };

    const columns = useMemo(() => [
        {
            accessorKey: 'nama_pt',
            header: 'Nama PT',
            cell: info => <span className="font-medium text-slate-800 dark:text-slate-200">{info.getValue()}</span>
        },
        {
            accessorKey: 'status_pt',
            header: 'Status',
            cell: info => {
                const status = info.getValue();
                let bg = 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
                if (status === 'PTN') bg = 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400';
                if (status === 'PTS') bg = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400';
                return <span className={`px-2.5 py-1 rounded-md text-xs font-semibold ${bg}`}>{status}</span>;
            }
        },
        {
            accessorKey: 'lokasi',
            header: 'Lokasi'
        },
        {
            accessorKey: 'provinsi',
            header: 'Provinsi'
        },
        {
            accessorKey: 'kota',
            header: 'Kota'
        },
        {
            id: 'actions',
            header: 'Aksi',
            cell: info => (
                <div className="flex items-center gap-2">
                    <Link
                        href={route('master-ptn.edit', info.row.original.id)}
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
            <Head title="Master PTN/PTS" />

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Master PTN/PTS</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola data perguruan tinggi negeri dan swasta.</p>
                </div>
                <Link
                    href={route('master-ptn.create')}
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all"
                >
                    <i className="ph ph-plus mr-2 text-lg"></i>
                    Tambah Data
                </Link>
            </div>

            {flash?.success && (
                <div className="mb-6 p-4 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl flex items-start gap-3">
                    <i className="ph ph-check-circle text-xl text-emerald-600 dark:text-emerald-400 mt-0.5"></i>
                    <div>
                        <h4 className="text-sm font-semibold text-emerald-800 dark:text-emerald-300">Berhasil</h4>
                        <p className="text-sm text-emerald-600 dark:text-emerald-400 mt-0.5">{flash.success}</p>
                    </div>
                </div>
            )}

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 overflow-hidden">
                <DataTable columns={columns} data={ptns} searchable={true} />
            </div>
        </AuthenticatedLayout>
    );
}
