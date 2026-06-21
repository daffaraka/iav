import React, { useState, useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';
import ConfirmModal from '../../Components/ConfirmModal';

export default function Index({ featuredQuestions, title }) {
    const { delete: destroy } = useForm();
    const [confirmModal, setConfirmModal] = useState({ isOpen: false, id: null });

    const handleDelete = (id) => {
        setConfirmModal({ isOpen: true, id });
    };

    const confirmDelete = () => {
        destroy(`/featured-question/${confirmModal.id}`);
        setConfirmModal({ isOpen: false, id: null });
    };

    const columns = useMemo(() => [
        {
            accessorKey: 'judul',
            header: 'Judul',
            cell: info => <div className="text-sm font-semibold text-slate-800 dark:text-white max-w-xs truncate" title={info.getValue()}>{info.getValue()}</div>
        },
        {
            accessorKey: 'kategori',
            header: 'Kategori',
            cell: info => {
                const val = info.getValue();
                let colorClass = 'border-surface-200 bg-surface-50 text-surface-700 dark:border-surface-500/20 dark:bg-surface-500/10 dark:text-surface-400';
                if(val === 'Akademik') colorClass = 'border-primary-200 bg-primary-50 text-primary-700 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-400';
                if(val === 'Keuangan') colorClass = 'border-success-200 bg-success-50 text-success-700 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400';
                if(val === 'Fasilitas Sarpras') colorClass = 'border-warning-200 bg-warning-50 text-warning-700 dark:border-warning-500/20 dark:bg-warning-500/10 dark:text-warning-400';
                if(val === 'PPDB') colorClass = 'border-info-200 bg-info-50 text-info-700 dark:border-info-500/20 dark:bg-info-500/10 dark:text-info-400';
                if(val === 'SDM') colorClass = 'border-danger-200 bg-danger-50 text-danger-700 dark:border-danger-500/20 dark:bg-danger-500/10 dark:text-danger-400';
                
                return <span className={`inline-flex px-2.5 py-1 rounded-lg text-xs font-medium border ${colorClass}`}>{val}</span>;
            }
        },
        {
            accessorKey: 'is_published',
            header: 'Status',
            cell: info => {
                return info.getValue() ? (
                    <span className="inline-flex px-2 py-1 rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 text-xs font-semibold">Published</span>
                ) : (
                    <span className="inline-flex px-2 py-1 rounded bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300 text-xs font-semibold">Draft</span>
                );
            }
        },
        {
            accessorKey: 'is_pinned',
            header: 'Pinned',
            cell: info => {
                return info.getValue() ? (
                    <div className="flex justify-center"><i className="ph-fill ph-push-pin text-amber-500 text-lg"></i></div>
                ) : (
                    <div className="flex justify-center"><span className="text-slate-400 text-xs">-</span></div>
                );
            }
        },
        {
            accessorKey: 'view_count',
            header: 'Klik Unik',
            cell: info => <div className="text-center text-sm text-slate-700 dark:text-slate-300">{info.getValue() || 0}</div>
        },
        {
            accessorKey: 'vote_count',
            header: 'Sundul',
            cell: info => <div className="text-center text-sm text-slate-700 dark:text-slate-300">{info.getValue() || 0}</div>
        },
        {
            accessorKey: 'tiket_id',
            header: 'Sumber',
            cell: info => {
                const val = info.getValue();
                return val ? (
                    <Link href={`/dashboard/aqr/tiket/${val}`} className="inline-flex px-2 py-1 rounded bg-blue-50 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400 text-xs font-semibold hover:underline">
                        Tiket #{val}
                    </Link>
                ) : (
                    <span className="inline-flex px-2 py-1 rounded bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300 text-xs font-semibold">Manual</span>
                );
            }
        },
        {
            id: 'aksi',
            header: 'Aksi',
            cell: info => {
                const fq = info.row.original;
                return (
                    <div className="flex items-center gap-2">
                        <Link 
                            href={`/featured-question/${fq.id}/edit`}
                            className="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg transition-colors"
                            title="Edit"
                        >
                            <i className="ph ph-pencil-simple text-lg"></i>
                        </Link>
                        <button 
                            onClick={() => handleDelete(fq.id)}
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
            <Head title={title || 'Featured Question'} />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">{title || 'Featured Question'}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Kelola daftar pertanyaan yang sering ditanyakan (FAQ)</p>
                </div>
                <Link 
                    href="/featured-question/create" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-plus mr-2"></i>
                    Tambah Baru
                </Link>
            </div>

            <DataTable columns={columns} data={featuredQuestions || []} searchable={true} />
            
            <ConfirmModal
                isOpen={confirmModal.isOpen}
                onClose={() => setConfirmModal({ isOpen: false, id: null })}
                onConfirm={confirmDelete}
                title="Hapus Featured Question?"
                message="Featured Question yang dihapus tidak dapat dikembalikan."
            />
        </AuthenticatedLayout>
    );
}
