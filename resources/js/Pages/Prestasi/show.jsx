import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function PrestasiShow({ prestasi }) {
    return (
        <AuthenticatedLayout>
            <Head title="Detail Data Prestasi" />

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Detail Prestasi</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Lihat rincian data prestasi lomba siswa.</p>
                </div>
                <Link
                    href="/data-prestasi"
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 dark:bg-surface-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium hover:bg-surface-200 dark:hover:bg-surface-600 transition-all"
                >
                    <i className="ph ph-arrow-left mr-2 text-lg"></i>
                    Kembali
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 overflow-hidden max-w-3xl">
                <div className="p-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Nama Siswa</p>
                            <p className="text-base font-semibold text-slate-800 dark:text-slate-200">{prestasi.siswa?.nama || '-'}</p>
                        </div>
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Asal Sekolah</p>
                            <p className="text-base font-semibold text-slate-800 dark:text-slate-200">{prestasi.siswa?.sekolah?.unit || '-'}</p>
                        </div>
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Nama Lomba</p>
                            <p className="text-base font-semibold text-slate-800 dark:text-slate-200">{prestasi.nama_lomba}</p>
                        </div>
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Kategori Lomba</p>
                            <p className="text-base font-semibold text-slate-800 dark:text-slate-200">{prestasi.kategori_lomba || '-'}</p>
                        </div>
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Tingkat Lomba</p>
                            <p className="text-base font-semibold text-slate-800 dark:text-slate-200">{prestasi.tingkat_lomba}</p>
                        </div>
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Tahun Pelajaran</p>
                            <p className="text-base font-semibold text-slate-800 dark:text-slate-200">{prestasi.tahun_pelajaran || '-'}</p>
                        </div>
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Guru Eskul</p>
                            <p className="text-base font-semibold text-slate-800 dark:text-slate-200">{prestasi.guru_eskul || '-'}</p>
                        </div>
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Guru Pendamping</p>
                            <p className="text-base font-semibold text-slate-800 dark:text-slate-200">{prestasi.guru_pendamping || '-'}</p>
                        </div>
                        <div>
                            <p className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Status Lomba</p>
                            <span className={`inline-flex px-3 py-1 rounded-md text-sm font-semibold mt-1 ${prestasi.status_lomba === 'Terkurasi' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400'}`}>
                                {prestasi.status_lomba}
                            </span>
                        </div>
                    </div>
                </div>
                <div className="p-4 border-t border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800/50 flex justify-end gap-3">
                    <Link
                        href={`/data-prestasi/${prestasi.id}/edit`}
                        className="px-4 py-2 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg text-sm font-medium hover:bg-amber-100 dark:hover:bg-amber-500/20 transition-colors"
                    >
                        Edit Data
                    </Link>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
