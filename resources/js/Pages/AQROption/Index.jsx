import React, { useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';

export default function Index({ aqrOptions }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Yakin ingin menghapus AQR Option ini?')) {
            destroy(`/aqr-option/${id}`);
        }
    };

    const columns = useMemo(() => [
        {
            accessorKey: 'nama_option',
            header: 'Nama Option',
            cell: info => <div className="text-sm font-semibold text-slate-800 dark:text-white">{info.getValue()}</div>
        },
        {
            accessorKey: 'kategori_pic',
            header: 'Kategori PIC',
            cell: info => {
                const val = info.getValue();
                let colorClass = 'border-surface-200 bg-surface-50 text-surface-700 dark:border-surface-500/20 dark:bg-surface-500/10 dark:text-surface-400';
                if(val === 'Kepala Sekolah') colorClass = 'border-primary-200 bg-primary-50 text-primary-700 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-400';
                if(val === 'Kepala TU') colorClass = 'border-success-200 bg-success-50 text-success-700 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400';
                if(val === 'Psikolog') colorClass = 'border-info-200 bg-info-50 text-info-700 dark:border-info-500/20 dark:bg-info-500/10 dark:text-info-400';
                
                return <span className={`inline-flex px-2.5 py-1 rounded-lg text-xs font-medium border ${colorClass}`}>{val}</span>;
            }
        },
        {
            accessorKey: 'is_aktif',
            header: 'Aktif',
            cell: info => {
                return info.getValue() ? (
                    <span className="inline-flex px-2 py-1 rounded bg-slate-800 text-white dark:bg-white dark:text-slate-800 text-xs font-semibold">Aktif</span>
                ) : (
                    <span className="inline-flex px-2 py-1 rounded bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400 text-xs font-semibold">Tidak Aktif</span>
                );
            }
        },
        {
            id: 'aksi',
            header: 'Aksi',
            cell: info => {
                const option = info.row.original;
                return (
                    <div className="flex items-center gap-2">
                        <Link 
                            href={`/aqr-option/${option.id}/edit`}
                            className="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg transition-colors"
                            title="Edit"
                        >
                            <i className="ph ph-pencil-simple text-lg"></i>
                        </Link>
                        <button 
                            onClick={() => handleDelete(option.id)}
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
            <Head title="AQR Option" />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">Data AQR Option</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Kelola opsi pertanyaan dan kendala</p>
                </div>
                <Link 
                    href="/aqr-option/create" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-plus mr-2"></i>
                    Tambah Option
                </Link>
            </div>

            <DataTable columns={columns} data={aqrOptions || []} />
            
        </AuthenticatedLayout>
    );
}
