import React, { useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';

export default function RoleIndex({ roles, title }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Yakin ingin menghapus role ini?')) {
            destroy(`/role/${id}`);
        }
    };

    const columns = useMemo(() => [
        {
            accessorKey: 'name',
            header: 'Nama Role',
            cell: info => (
                <div className="inline-flex items-center px-3 py-1.5 rounded-lg bg-surface-100 dark:bg-surface-700/50 text-slate-800 dark:text-slate-200 text-sm font-semibold tracking-wide shadow-sm border border-surface-200 dark:border-surface-600">
                    <i className="ph ph-shield-check text-brand-500 mr-2 text-lg"></i>
                    {info.getValue()}
                </div>
            )
        },
        {
            id: 'aksi',
            header: 'Aksi',
            cell: info => {
                const role = info.row.original;
                return (
                    <div className="flex items-center gap-2">
                        <Link 
                            href={`/role/${role.id}/edit`}
                            className="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg transition-colors"
                            title="Edit"
                        >
                            <i className="ph ph-pencil-simple text-lg"></i>
                        </Link>
                        <button 
                            onClick={() => handleDelete(role.id)}
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
            <Head title={title || "Manajemen Roles"} />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">{title || "Manajemen Roles"}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Kelola daftar role dan hak akses sistem</p>
                </div>
                <Link 
                    href="/role/create" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-plus mr-2"></i>
                    Tambah Role
                </Link>
            </div>

            <DataTable columns={columns} data={roles || []} />

        </AuthenticatedLayout>
    );
}
