import React, { useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import DataTable from '../../Components/DataTable';
import Alert from '../../Components/Alert';

export default function PrestasiIndex({ jagakarsa, cinere, pamulang, allPrestasi, flash }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Yakin ingin menghapus data ini?')) {
            destroy('/data-prestasi/' + id);
        }
    };

    const renderSchoolCard = (title, data) => (
        <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-soft border border-surface-200 dark:border-surface-700 overflow-hidden flex flex-col h-full">
            <div className="p-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50 dark:bg-surface-800/50 flex justify-between items-center">
                <div>
                    <h5 className="font-bold text-slate-800 dark:text-white">{title}</h5>
                    <p className="text-xs text-slate-500 mt-0.5">5 Prestasi Terbaru</p>
                </div>
            </div>
            <div className="p-0 overflow-y-auto max-h-[320px] custom-scrollbar">
                {data.length > 0 ? (
                    data.map((item, idx) => (
                        <div key={idx} className="p-4 border-b border-surface-100 dark:border-surface-700 last:border-0 hover:bg-surface-50 dark:hover:bg-surface-700/30 transition-colors">
                            <span className="text-xs font-semibold text-brand-600 dark:text-brand-400 block mb-1">{item.siswa?.nama || '-'}</span>
                            <h6 className="text-sm font-bold text-slate-800 dark:text-slate-200 mb-2 leading-tight">{item.nama_lomba}</h6>
                            <div className="flex items-center justify-between">
                                <span className={`px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider ${item.status_lomba === 'Terkurasi' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400'}`}>
                                    {item.status_lomba}
                                </span>
                                <span className="text-xs text-slate-500">{item.tingkat_lomba}</span>
                            </div>
                        </div>
                    ))
                ) : (
                    <div className="p-8 text-center text-slate-500">
                        <p className="text-sm">Tidak ada data</p>
                    </div>
                )}
            </div>
        </div>
    );

    const columns = useMemo(() => [
        {
            accessorKey: 'siswa.nama',
            header: 'Nama Siswa',
            cell: info => <span className="font-semibold text-slate-800 dark:text-slate-200">{info.getValue() || '-'}</span>
        },
        {
            accessorKey: 'siswa.sekolah.unit',
            header: 'Sekolah',
            cell: info => info.getValue() || '-'
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
                        href={`/data-prestasi/${info.row.original.id}`}
                        className="px-2.5 py-1.5 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-medium hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors"
                    >
                        Lihat
                    </Link>
                    <Link
                        href={`/data-prestasi/${info.row.original.id}/edit`}
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
            <Head title="Data Prestasi" />

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Data Prestasi Siswa</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola dan pantau data prestasi seluruh unit sekolah.</p>
                </div>
            </div>

            <Alert type="success" message={flash?.success} />

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {renderSchoolCard('Sekolah Jagakarsa', jagakarsa)}
                {renderSchoolCard('Sekolah Cinere', cinere)}
                {renderSchoolCard('Sekolah Pamulang', pamulang)}
            </div>

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h3 className="text-xl font-bold text-slate-800 dark:text-white">Semua Data Prestasi</h3>
                <Link
                    href="/data-prestasi/create"
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 transition-all"
                >
                    <i className="ph ph-plus mr-2 text-lg"></i>
                    Tambah Data
                </Link>
            </div>
            
            <DataTable columns={columns} data={allPrestasi} searchable={true} />
        </AuthenticatedLayout>
    );
}
