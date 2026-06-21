import React, { useState, useMemo } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';
import ConfirmModal from '../../Components/ConfirmModal';

export default function TiketIndex({ tikets, userRoles }) {
    const [confirmModal, setConfirmModal] = useState({ isOpen: false, id: null });
    const [showDeleteModal, setShowDeleteModal] = useState(false);
    const [isDeletingAll, setIsDeletingAll] = useState(false);
    const [confirmText, setConfirmText] = useState('');

    const isSuperAdmin = userRoles.includes('super-admin');

    const handleDelete = (id) => {
        setConfirmModal({ isOpen: true, id });
    };

    const confirmDelete = () => {
        router.delete(`/dashboard/aqr/tiket/${confirmModal.id}`);
        setConfirmModal({ isOpen: false, id: null });
    };

    const handleDeleteAll = () => {
        if (confirmText === 'HAPUS SEMUA') {
            setIsDeletingAll(true);
            router.delete('/dashboard/aqr/tiket/delete-all', {
                onFinish: () => {
                    setIsDeletingAll(false);
                    setShowDeleteModal(false);
                    setConfirmText('');
                }
            });
        }
    };

    const columns = useMemo(
        () => [
            {
                header: 'ID Tiket',
                accessorKey: 'kode_tiket',
                cell: info => <span className="font-semibold text-slate-800 dark:text-white">{info.getValue() || info.row.original.no_tiket}</span>,
            },
            {
                header: 'Status',
                accessorKey: 'status',
                cell: info => {
                    const status = info.getValue();
                    const colors = {
                        'New': 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
                        'Proses': 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
                        'Selesai': 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20'
                    };
                    const dots = {
                        'New': 'bg-blue-500',
                        'Proses': 'bg-amber-500',
                        'Selesai': 'bg-emerald-500'
                    };
                    return (
                        <span className={`inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border ${colors[status] || colors['New']}`}>
                            <span className={`w-1.5 h-1.5 rounded-full mr-1.5 ${dots[status] || dots['New']}`}></span>
                            {status === 'New' ? 'Baru' : status}
                        </span>
                    );
                }
            },
            {
                header: 'Kendala & Pengirim',
                accessorFn: row => `${row.judul_kendala} ${row.nama}`,
                id: 'kendala_pengirim',
                cell: info => (
                    <div>
                        <div className="text-sm text-slate-700 dark:text-slate-200 font-medium line-clamp-1">{info.row.original.judul_kendala}</div>
                        <div className="text-xs text-slate-400 mt-0.5">{info.row.original.nama}</div>
                    </div>
                )
            },
            {
                header: 'Lokasi & Kategori',
                accessorFn: row => `${row.lokasi_kendala} ${row.option?.kategori_pic || ''}`,
                id: 'lokasi_kategori',
                cell: info => (
                    <div>
                        <span className="block text-sm text-slate-700 dark:text-slate-300">{info.row.original.lokasi_kendala || '-'}</span>
                        <span className="inline-flex mt-1 items-center px-2 py-0.5 rounded text-[10px] font-medium bg-surface-100 dark:bg-surface-700 text-slate-600 dark:text-slate-300">
                            {info.row.original.option?.kategori_pic || 'Umum'}
                        </span>
                    </div>
                )
            },
            {
                header: 'Penanganan',
                accessorFn: row => `${row.first_pic?.name || ''} ${row.pic?.name || ''}`,
                id: 'penanganan',
                cell: info => (
                    <div>
                        <div className="text-xs text-slate-500 dark:text-slate-400"><span className="font-medium">1st Gate:</span> {info.row.original.first_pic?.name || '-'}</div>
                        <div className="text-xs text-slate-500 dark:text-slate-400 mt-0.5"><span className="font-medium">PIC:</span> {info.row.original.pic?.name || '-'}</div>
                    </div>
                )
            },
            {
                header: 'Tanggal',
                accessorKey: 'created_at',
                cell: info => {
                    const date = new Date(info.getValue());
                    return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(date);
                }
            },
            {
                header: 'Aksi',
                id: 'actions',
                cell: info => (
                    <div className="flex items-center gap-2 justify-end">
                        <Link 
                            href={`/dashboard/aqr/tiket/${info.row.original.id}/edit`} 
                            className="p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 hover:bg-blue-100 dark:bg-blue-500/10 dark:hover:bg-blue-500/20 rounded-lg transition-colors"
                            title="Edit / Detail"
                        >
                            <i className="ph ph-pencil-simple text-lg"></i>
                        </Link>
                        <button 
                            onClick={() => handleDelete(info.row.original.id)}
                            className="p-1.5 text-rose-600 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-300 bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 rounded-lg transition-colors"
                            title="Hapus"
                        >
                            <i className="ph ph-trash text-lg"></i>
                        </button>
                    </div>
                ),
            }
        ],
        []
    );

    return (
        <AuthenticatedLayout>
            <Head title="Manajemen Tiket AQR" />
            
            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Manajemen Tiket</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar seluruh tiket keluhan dan permintaan layanan.</p>
                </div>
                <div className="flex items-center gap-3">
                    {isSuperAdmin && (
                        <button 
                            onClick={() => setShowDeleteModal(true)}
                            className="px-4 py-2 bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 rounded-xl text-sm font-semibold hover:bg-rose-100 dark:hover:bg-rose-500/20 transition-colors flex items-center border border-rose-200 dark:border-rose-500/20"
                        >
                            <i className="ph ph-trash mr-2 text-lg"></i>
                            Hapus Semua
                        </button>
                    )}
                    <Link href="/dashboard/aqr/tiket/create" className="px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/30 hover:bg-brand-700 transition-colors flex items-center">
                        <i className="ph ph-plus mr-2 text-lg"></i>
                        Buat Tiket
                    </Link>
                </div>
            </div>

            <DataTable columns={columns} data={tikets || []} searchable={true} />

            {/* Delete All Modal */}
            {showDeleteModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl w-full max-w-md shadow-xl border border-surface-200 dark:border-surface-700 overflow-hidden transform transition-all">
                        <div className="p-6 border-b border-surface-100 dark:border-surface-700">
                            <div className="flex items-center gap-3 text-rose-600 dark:text-rose-500 mb-2">
                                <i className="ph ph-warning-circle text-3xl"></i>
                                <h3 className="text-lg font-bold text-slate-800 dark:text-white">Konfirmasi Hapus Semua</h3>
                            </div>
                            <p className="text-sm text-slate-600 dark:text-slate-300 mt-3">
                                Anda akan menghapus <strong>SEMUA TIKET</strong> yang ada di sistem. Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
                            </p>
                        </div>
                        <div className="p-6 bg-surface-50 dark:bg-surface-900/50">
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Ketik <strong className="text-rose-600 dark:text-rose-400">"HAPUS SEMUA"</strong> untuk konfirmasi:
                            </label>
                            <input 
                                type="text"
                                value={confirmText}
                                onChange={e => setConfirmText(e.target.value)}
                                placeholder="HAPUS SEMUA"
                                className="w-full px-4 py-2 border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 rounded-xl text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500"
                            />
                        </div>
                        <div className="p-4 border-t border-surface-100 dark:border-surface-700 flex justify-end gap-3 bg-white dark:bg-surface-800">
                            <button 
                                onClick={() => setShowDeleteModal(false)}
                                className="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-xl transition-colors"
                            >
                                Batal
                            </button>
                            <button 
                                onClick={handleDeleteAll}
                                disabled={confirmText !== 'HAPUS SEMUA' || isDeletingAll}
                                className="px-4 py-2 text-sm font-medium bg-rose-600 text-white rounded-xl hover:bg-rose-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center"
                            >
                                {isDeletingAll ? (
                                    <><i className="ph ph-spinner animate-spin mr-2"></i> Menghapus...</>
                                ) : 'Hapus Semua Tiket'}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            <ConfirmModal
                isOpen={confirmModal.isOpen}
                onClose={() => setConfirmModal({ isOpen: false, id: null })}
                onConfirm={confirmDelete}
                title="Hapus Tiket?"
                message="Tiket yang dihapus tidak dapat dikembalikan."
            />
        </AuthenticatedLayout>
    );
}
