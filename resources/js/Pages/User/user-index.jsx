import React, { useState, useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';
import ConfirmModal from '../../Components/ConfirmModal';

export default function UserIndex({ users, title }) {
    const { delete: destroy } = useForm();
    const [confirmModal, setConfirmModal] = useState({ isOpen: false, id: null });

    const handleDelete = (id) => {
        setConfirmModal({ isOpen: true, id });
    };

    const confirmDelete = () => {
        destroy(`/user/${confirmModal.id}`);
        setConfirmModal({ isOpen: false, id: null });
    };

    const columns = useMemo(() => [
        {
            accessorKey: 'kode_karyawan',
            header: 'Kode Karyawan',
            cell: info => info.getValue() || '-'
        },
        {
            accessorKey: 'name',
            header: 'Nama',
            cell: info => <div className="text-sm font-semibold text-slate-800 dark:text-white">{info.getValue()}</div>
        },
        {
            accessorKey: 'email',
            header: 'Email',
        },
        {
            accessorKey: 'jabatan',
            header: 'Jabatan',
            cell: info => info.getValue() || '-'
        },
        {
            accessorKey: 'departemen',
            header: 'Departemen',
            cell: info => info.getValue() || '-'
        },
        {
            accessorKey: 'unit',
            header: 'Unit',
            cell: info => {
                const val = info.getValue();
                if (!val) return '-';
                let colorClass = 'border-surface-200 bg-surface-50 text-surface-700 dark:border-surface-500/20 dark:bg-surface-500/10 dark:text-surface-400';
                if(val === 'Jagakarsa') colorClass = 'border-primary-200 bg-primary-50 text-primary-700 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-400';
                if(val === 'Pamulang') colorClass = 'border-success-200 bg-success-50 text-success-700 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400';
                if(val === 'Cinere') colorClass = 'border-info-200 bg-info-50 text-info-700 dark:border-info-500/20 dark:bg-info-500/10 dark:text-info-400';
                
                return <span className={`inline-flex px-2.5 py-1 rounded-lg text-xs font-medium border ${colorClass}`}>{val}</span>;
            }
        },
        {
            accessorKey: 'jenjang',
            header: 'Jenjang',
            cell: info => {
                const val = info.getValue();
                if (!val) return '-';
                let colorClass = 'border-surface-200 bg-surface-50 text-surface-700 dark:border-surface-500/20 dark:bg-surface-500/10 dark:text-surface-400';
                if(val === 'KB') colorClass = 'border-warning-200 bg-warning-50 text-warning-700 dark:border-warning-500/20 dark:bg-warning-500/10 dark:text-warning-400';
                else if(val === 'TK') colorClass = 'border-surface-300 bg-surface-100 text-surface-800 dark:border-surface-500/30 dark:bg-surface-500/20 dark:text-surface-300';
                else if(val === 'SD') colorClass = 'border-primary-200 bg-primary-50 text-primary-700 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-400';
                else if(val === 'SMP') colorClass = 'border-success-200 bg-success-50 text-success-700 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400';
                else if(val === 'SMA') colorClass = 'border-danger-200 bg-danger-50 text-danger-700 dark:border-danger-500/20 dark:bg-danger-500/10 dark:text-danger-400';
                
                return <span className={`inline-flex px-2.5 py-1 rounded-lg text-xs font-medium border ${colorClass}`}>{val}</span>;
            }
        },
        {
            accessorKey: 'roles',
            header: 'Role',
            cell: info => {
                const roles = info.getValue() || [];
                return (
                    <div className="flex flex-wrap gap-1">
                        {roles.map(role => (
                            <span key={role.id} className="inline-flex px-2 py-0.5 rounded bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300 text-xs font-semibold">
                                {role.name}
                            </span>
                        ))}
                    </div>
                )
            }
        },
        {
            id: 'wali_kelas',
            header: 'Wali Kelas',
            cell: info => {
                const user = info.row.original;
                const isGuru = user.roles && user.roles.some(r => r.name === 'guru' || r.name === 'wali-kelas');
                if (isGuru) {
                    return (
                        <span className="inline-flex px-2 py-1 rounded border border-danger-200 text-danger-700 dark:border-danger-500/30 dark:text-danger-400 text-xs font-semibold">
                            {(user.kelas || '') + (user.sub_kelas || '')}
                        </span>
                    );
                }
                return '-';
            }
        },
        {
            id: 'aksi',
            header: 'Aksi',
            cell: info => {
                const user = info.row.original;
                return (
                    <div className="flex items-center gap-2">
                        <Link href={`/user/${user.id}`} className="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-colors" title="Detail">
                            <i className="ph ph-eye text-lg"></i>
                        </Link>
                        <Link href={`/user/${user.id}/edit`} className="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg transition-colors" title="Edit">
                            <i className="ph ph-pencil-simple text-lg"></i>
                        </Link>
                        <button onClick={() => handleDelete(user.id)} className="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors" title="Hapus">
                            <i className="ph ph-trash text-lg"></i>
                        </button>
                    </div>
                );
            }
        }
    ], []);

    return (
        <AuthenticatedLayout>
            <Head title={title || "Manajemen User"} />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">{title || "Manajemen User"}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Kelola pengguna dan hak akses sistem</p>
                </div>
                <Link 
                    href="/user/create" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-plus mr-2"></i>
                    Tambah User
                </Link>
            </div>

            <DataTable columns={columns} data={users || []} />
            
            <ConfirmModal
                isOpen={confirmModal.isOpen}
                onClose={() => setConfirmModal({ isOpen: false, id: null })}
                onConfirm={confirmDelete}
                title="Hapus User?"
                message="Data user yang dihapus tidak dapat dikembalikan."
            />
        </AuthenticatedLayout>
    );
}
