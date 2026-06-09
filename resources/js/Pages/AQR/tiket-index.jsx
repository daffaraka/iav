import React, { useState, useMemo } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import {
    useReactTable,
    getCoreRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    flexRender,
} from '@tanstack/react-table';

export default function TiketIndex({ tikets, userRoles }) {
    const [globalFilter, setGlobalFilter] = useState('');
    const [showDeleteModal, setShowDeleteModal] = useState(false);
    const [isDeletingAll, setIsDeletingAll] = useState(false);
    const [confirmText, setConfirmText] = useState('');

    const isSuperAdmin = userRoles.includes('super-admin');

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus tiket ini?')) {
            router.delete(`/dashboard/aqr/tiket/${id}`);
        }
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
                accessorKey: 'no_tiket',
                cell: info => <span className="font-semibold text-slate-800 dark:text-white">{info.getValue()}</span>,
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

    const table = useReactTable({
        data: tikets,
        columns,
        state: {
            globalFilter,
        },
        onGlobalFilterChange: setGlobalFilter,
        getCoreRowModel: getCoreRowModel(),
        getFilteredRowModel: getFilteredRowModel(),
        getSortedRowModel: getSortedRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        initialState: {
            pagination: {
                pageSize: 10,
            },
            sorting: [
                { id: 'created_at', desc: true }
            ]
        }
    });

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

            <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-200 dark:border-surface-700 shadow-sm overflow-hidden">
                {/* Toolbar */}
                <div className="p-4 border-b border-surface-200 dark:border-surface-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-surface-50/50 dark:bg-surface-800/50">
                    <div className="relative w-full sm:w-80 group">
                        <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i className="ph ph-magnifying-glass text-slate-400 group-focus-within:text-brand-500 transition-colors text-lg"></i>
                        </div>
                        <input
                            value={globalFilter ?? ''}
                            onChange={e => setGlobalFilter(e.target.value)}
                            placeholder="Cari di semua kolom..."
                            className="block w-full pl-10 pr-4 py-2.5 bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all text-slate-700 dark:text-slate-200 shadow-sm"
                        />
                    </div>
                </div>

                {/* Table */}
                <div className="overflow-x-auto">
                    <table className="w-full text-left border-collapse">
                        <thead>
                            {table.getHeaderGroups().map(headerGroup => (
                                <tr key={headerGroup.id} className="bg-surface-50 dark:bg-surface-900/50 border-b border-surface-200 dark:border-surface-700">
                                    {headerGroup.headers.map(header => (
                                        <th 
                                            key={header.id} 
                                            className="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider whitespace-nowrap cursor-pointer select-none hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors"
                                            onClick={header.column.getToggleSortingHandler()}
                                        >
                                            <div className={`flex items-center gap-2 ${header.id === 'actions' ? 'justify-end' : ''}`}>
                                                {flexRender(
                                                    header.column.columnDef.header,
                                                    header.getContext()
                                                )}
                                                {{
                                                    asc: <i className="ph ph-caret-up text-brand-500"></i>,
                                                    desc: <i className="ph ph-caret-down text-brand-500"></i>,
                                                }[header.column.getIsSorted()] ?? null}
                                            </div>
                                        </th>
                                    ))}
                                </tr>
                            ))}
                        </thead>
                        <tbody className="divide-y divide-surface-100 dark:divide-surface-700">
                            {table.getRowModel().rows.length > 0 ? (
                                table.getRowModel().rows.map(row => (
                                    <tr key={row.id} className="hover:bg-surface-50/50 dark:hover:bg-surface-700/30 transition-colors">
                                        {row.getVisibleCells().map(cell => (
                                            <td key={cell.id} className="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                                {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                            </td>
                                        ))}
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan={columns.length} className="px-6 py-12 text-center">
                                        <div className="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                                            <i className="ph ph-ticket text-5xl mb-3 opacity-20"></i>
                                            <p className="text-base font-medium">Tidak ada data tiket ditemukan</p>
                                            <p className="text-sm mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                                        </div>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                {/* Pagination */}
                <div className="p-4 border-t border-surface-200 dark:border-surface-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-surface-800">
                    <div className="text-sm text-slate-500 dark:text-slate-400">
                        Menampilkan <span className="font-semibold text-slate-700 dark:text-slate-200">{table.getState().pagination.pageIndex * table.getState().pagination.pageSize + 1}</span> hingga <span className="font-semibold text-slate-700 dark:text-slate-200">{Math.min((table.getState().pagination.pageIndex + 1) * table.getState().pagination.pageSize, table.getFilteredRowModel().rows.length)}</span> dari <span className="font-semibold text-slate-700 dark:text-slate-200">{table.getFilteredRowModel().rows.length}</span> entri
                    </div>
                    <div className="flex items-center gap-2">
                        <button
                            onClick={() => table.setPageIndex(0)}
                            disabled={!table.getCanPreviousPage()}
                            className="p-2 rounded-lg border border-surface-200 dark:border-surface-700 text-slate-500 hover:bg-surface-50 dark:hover:bg-surface-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        >
                            <i className="ph ph-caret-double-left"></i>
                        </button>
                        <button
                            onClick={() => table.previousPage()}
                            disabled={!table.getCanPreviousPage()}
                            className="p-2 rounded-lg border border-surface-200 dark:border-surface-700 text-slate-500 hover:bg-surface-50 dark:hover:bg-surface-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        >
                            <i className="ph ph-caret-left"></i>
                        </button>
                        <span className="text-sm text-slate-600 dark:text-slate-300 font-medium px-4">
                            Halaman {table.getState().pagination.pageIndex + 1} dari {table.getPageCount()}
                        </span>
                        <button
                            onClick={() => table.nextPage()}
                            disabled={!table.getCanNextPage()}
                            className="p-2 rounded-lg border border-surface-200 dark:border-surface-700 text-slate-500 hover:bg-surface-50 dark:hover:bg-surface-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        >
                            <i className="ph ph-caret-right"></i>
                        </button>
                        <button
                            onClick={() => table.setPageIndex(table.getPageCount() - 1)}
                            disabled={!table.getCanNextPage()}
                            className="p-2 rounded-lg border border-surface-200 dark:border-surface-700 text-slate-500 hover:bg-surface-50 dark:hover:bg-surface-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        >
                            <i className="ph ph-caret-double-right"></i>
                        </button>
                    </div>
                </div>
            </div>

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
        </AuthenticatedLayout>
    );
}
