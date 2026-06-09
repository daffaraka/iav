import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function Index({ featuredQuestions, title }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Yakin ingin menghapus featured question ini?')) {
            destroy(`/featured-question/${id}`);
        }
    };

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

            <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden transition-colors duration-300">
                <div className="overflow-x-auto custom-scrollbar">
                    <table className="w-full text-left border-collapse min-w-max">
                        <thead>
                            <tr className="bg-surface-50/50 dark:bg-surface-800/50 text-slate-500 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-surface-100 dark:border-surface-700">
                                <th className="px-6 py-4 font-semibold">No</th>
                                <th className="px-6 py-4 font-semibold">Judul</th>
                                <th className="px-6 py-4 font-semibold">Kategori</th>
                                <th className="px-6 py-4 font-semibold">Status</th>
                                <th className="px-6 py-4 font-semibold">Pinned</th>
                                <th className="px-6 py-4 font-semibold text-center">Klik Unik</th>
                                <th className="px-6 py-4 font-semibold text-center">Sundul</th>
                                <th className="px-6 py-4 font-semibold">Sumber</th>
                                <th className="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-surface-100 dark:divide-surface-700">
                            {featuredQuestions && featuredQuestions.length > 0 ? (
                                featuredQuestions.map((fq, index) => (
                                    <tr key={fq.id} className="hover:bg-surface-50/50 dark:hover:bg-surface-700/50 transition-colors group">
                                        <td className="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                            {index + 1}
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="text-sm font-semibold text-slate-800 dark:text-white max-w-xs truncate" title={fq.judul}>
                                                {fq.judul}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className={`inline-flex px-2.5 py-1 rounded-lg text-xs font-medium border ${
                                                fq.kategori === 'Akademik' ? 'border-primary-200 bg-primary-50 text-primary-700 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-400' :
                                                fq.kategori === 'Keuangan' ? 'border-success-200 bg-success-50 text-success-700 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400' :
                                                fq.kategori === 'Fasilitas Sarpras' ? 'border-warning-200 bg-warning-50 text-warning-700 dark:border-warning-500/20 dark:bg-warning-500/10 dark:text-warning-400' :
                                                fq.kategori === 'PPDB' ? 'border-info-200 bg-info-50 text-info-700 dark:border-info-500/20 dark:bg-info-500/10 dark:text-info-400' :
                                                fq.kategori === 'SDM' ? 'border-danger-200 bg-danger-50 text-danger-700 dark:border-danger-500/20 dark:bg-danger-500/10 dark:text-danger-400' :
                                                'border-surface-200 bg-surface-50 text-surface-700 dark:border-surface-500/20 dark:bg-surface-500/10 dark:text-surface-400'
                                            }`}>
                                                {fq.kategori}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4">
                                            {fq.is_published ? (
                                                <span className="inline-flex px-2 py-1 rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 text-xs font-semibold">Published</span>
                                            ) : (
                                                <span className="inline-flex px-2 py-1 rounded bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300 text-xs font-semibold">Draft</span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            {fq.is_pinned ? (
                                                <i className="ph-fill ph-push-pin text-amber-500 text-lg"></i>
                                            ) : (
                                                <span className="text-slate-400 text-xs">-</span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-center text-sm text-slate-700 dark:text-slate-300">
                                            {fq.view_count || 0}
                                        </td>
                                        <td className="px-6 py-4 text-center text-sm text-slate-700 dark:text-slate-300">
                                            {fq.vote_count || 0}
                                        </td>
                                        <td className="px-6 py-4">
                                            {fq.tiket_id ? (
                                                <Link href={`/dashboard/aqr/tiket/${fq.tiket_id}`} className="inline-flex px-2 py-1 rounded bg-blue-50 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400 text-xs font-semibold hover:underline">
                                                    Tiket #{fq.tiket_id}
                                                </Link>
                                            ) : (
                                                <span className="inline-flex px-2 py-1 rounded bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300 text-xs font-semibold">Manual</span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="flex items-center justify-center gap-2">
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
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="9" className="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                                        <div className="flex flex-col items-center justify-center">
                                            <i className="ph ph-list-dashes text-4xl mb-2 text-slate-300 dark:text-slate-600"></i>
                                            <p>Tidak ada data Featured Question</p>
                                        </div>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
