import React, { useState, useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';
import ConfirmModal from '../../Components/ConfirmModal';

export default function MasterGuruIndex({ guru }) {
    const { delete: destroy } = useForm();
    const [confirmModal, setConfirmModal] = useState({ isOpen: false, id: null });

    const handleDelete = (id) => {
        setConfirmModal({ isOpen: true, id });
    };

    const confirmDelete = () => {
        destroy(`/master-guru/${confirmModal.id}`);
        setConfirmModal({ isOpen: false, id: null });
    };

    const columns = useMemo(() => [
        {
            accessorKey: 'name',
            header: 'Nama Guru',
            cell: info => <span className="font-medium text-slate-800 dark:text-slate-200">{info.getValue()}</span>
        },
        {
            accessorKey: 'email',
            header: 'Email',
            cell: info => <span className="text-slate-600 dark:text-slate-400">{info.getValue()}</span>
        },
        {
            accessorKey: 'kelas',
            header: 'Kelas',
            cell: info => info.getValue() ? (
                <span className="px-2 py-1 bg-surface-100 dark:bg-surface-700 text-slate-600 dark:text-slate-300 rounded-md text-xs font-semibold border border-surface-200 dark:border-surface-600">
                    {info.getValue()}
                </span>
            ) : <span className="text-slate-400 italic">-</span>
        },
        {
            id: 'aksi',
            header: 'Aksi',
            cell: info => {
                const g = info.row.original;
                return (
                    <div className="flex items-center gap-2">
                        <Link 
                            href={`/master-guru/${g.id}/edit`}
                            className="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg transition-colors"
                            title="Edit"
                        >
                            <i className="ph ph-pencil-simple text-lg"></i>
                        </Link>
                        <button 
                            onClick={() => handleDelete(g.id)}
                            className="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors"
                            title="Hapus"
                        >
                            <i className="ph ph-trash text-lg"></i>
                        </button>
                    </div>
                );
            }
        }
    ], []);

    return (
        <AuthenticatedLayout>
            <Head title="Manajemen Master Guru" />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">Master Guru</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Kelola daftar guru dan wali kelas</p>
                </div>
                <Link 
                    href="/master-guru/create" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-user-plus mr-2"></i>
                    Tambah Guru
                </Link>
            </div>

            <DataTable columns={columns} data={guru || []} />

            <ConfirmModal
                isOpen={confirmModal.isOpen}
                onClose={() => setConfirmModal({ isOpen: false, id: null })}
                onConfirm={confirmDelete}
                title="Hapus Master Guru?"
                message="Data guru yang dihapus tidak dapat dikembalikan."
            />
        </AuthenticatedLayout>
    );
}
