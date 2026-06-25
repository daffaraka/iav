import React, { useState, useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';
import Alert from '../../Components/Alert';
import ConfirmModal from '../../Components/ConfirmModal';

export default function PrestasiGuruIndex({ prestasi, flash }) {
    const { delete: destroy } = useForm();
    const [confirmModal, setConfirmModal] = useState({ isOpen: false, id: null });

    const handleDelete = (id) => {
        setConfirmModal({ isOpen: true, id });
    };

    const confirmDelete = () => {
        destroy('/prestasi-guru/' + confirmModal.id);
        setConfirmModal({ isOpen: false, id: null });
    };

    const columns = useMemo(() => [
        {
            accessorKey: 'user.name',
            header: 'Nama Guru',
            cell: info => <span className="font-semibold text-slate-800 dark:text-slate-200">{info.getValue() || '-'}</span>
        },
        {
            accessorKey: 'nama_lomba',
            header: 'Nama Lomba'
        },
        {
            accessorKey: 'mata_bidang_lomba',
            header: 'Bidang Lomba'
        },
        {
            accessorKey: 'raihan_prestasi',
            header: 'Juara',
            cell: info => <span className="font-bold text-amber-600 dark:text-amber-400">{info.getValue()}</span>
        },
        {
            accessorKey: 'level_lomba',
            header: 'Tingkat'
        },
        {
            accessorKey: 'status_kurasi',
            header: 'Status',
            cell: info => {
                const val = info.getValue();
                return <span className={`px-2 py-1 rounded text-xs font-medium ${val === 'Terkurasi' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400'}`}>{val}</span>;
            }
        },
        {
            id: 'actions',
            header: 'Aksi',
            cell: info => (
                <div className="flex items-center gap-1.5 flex-wrap">
                    <Link
                        href={`/prestasi-guru/${info.row.original.id}/edit`}
                        className="px-2.5 py-1.5 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg text-xs font-medium hover:bg-amber-100 dark:hover:bg-amber-500/20 transition-colors"
                    >
                        Edit
                    </Link>
                    <button
                        onClick={() => handleDelete(info.row.original.id)}
                        className="px-2.5 py-1.5 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 rounded-lg text-xs font-medium hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors"
                    >
                        Hapus
                    </button>
                </div>
            )
        }
    ], []);

    return (
        <AuthenticatedLayout>
            <Head title="Data Prestasi Guru" />

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Data Prestasi Guru</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola dan pantau data prestasi seluruh guru / staf.</p>
                </div>
                <div className="flex gap-3">
                    <Link
                        href="/prestasi-guru/create"
                        className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 transition-all"
                    >
                        <i className="ph ph-plus mr-2 text-lg"></i>
                        Tambah Data
                    </Link>
                </div>
            </div>

            <Alert type="success" message={flash?.success} />

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-soft border border-surface-200 dark:border-surface-700 overflow-hidden mb-8 p-4 lg:p-6">
                <DataTable columns={columns} data={prestasi} searchable={true} />
            </div>
            
            <ConfirmModal
                isOpen={confirmModal.isOpen}
                onClose={() => setConfirmModal({ isOpen: false, id: null })}
                onConfirm={confirmDelete}
                title="Hapus Data Prestasi Guru?"
                message="Data prestasi guru yang dihapus tidak dapat dikembalikan."
            />
        </AuthenticatedLayout>
    );
}
