import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function WigHistoriesAll({ wig, histories, filters }) {
    const [search, setSearch] = useState(filters?.search || '');

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(`/wig/${wig.id}/history`, { search }, { preserveState: true });
    };

    return (
        <AuthenticatedLayout>
            <Head title={`Riwayat WIG - ${wig.judul_wig}`} />
            
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div className="flex items-center gap-3 mb-2">
                            <Link href={`/wig/${wig.id}`} className="w-8 h-8 flex items-center justify-center rounded-xl bg-surface-100 text-surface-600 hover:bg-surface-200 dark:bg-surface-800 dark:text-surface-300 dark:hover:bg-surface-700 transition-colors">
                                <i className="ph ph-arrow-left text-lg"></i>
                            </Link>
                            <h1 className="text-2xl font-bold text-slate-800 dark:text-white">
                                Riwayat Keseluruhan WIG
                            </h1>
                        </div>
                        <p className="text-sm text-slate-500 dark:text-slate-400 ml-11">
                            {wig.judul_wig}
                        </p>
                    </div>

                    <form onSubmit={handleSearch} className="flex gap-2 w-full md:w-auto">
                        <input 
                            type="text" 
                            placeholder="Cari riwayat atau penginput..." 
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="px-4 py-2 border border-surface-200 dark:border-surface-700 rounded-xl bg-white dark:bg-surface-900 text-sm focus:ring-brand-500 w-full md:w-64"
                        />
                        <button type="submit" className="px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors">
                            Cari
                        </button>
                    </form>
                </div>

                <div className="bg-white dark:bg-surface-800 rounded-3xl shadow-sm border border-surface-100 dark:border-surface-700 overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-surface-50 dark:bg-surface-900 border-b border-surface-100 dark:border-surface-700">
                                <tr>
                                    <th className="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300">Tanggal</th>
                                    <th className="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300">Keterangan Riwayat</th>
                                    <th className="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300 text-center">Penambahan (Delta)</th>
                                    <th className="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300">Dibuat Oleh</th>
                                    <th className="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300 text-center">Lampiran</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-surface-100 dark:divide-surface-700">
                                {histories.data.length > 0 ? (
                                    histories.data.map(hist => (
                                        <tr key={hist.id} className="hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                                            <td className="px-6 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300">
                                                {new Date(hist.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
                                            </td>
                                            <td className="px-6 py-4 font-medium text-slate-800 dark:text-slate-200">
                                                {hist.riwayat_wig}
                                            </td>
                                            <td className="px-6 py-4 text-center">
                                                <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border ${parseFloat(hist.realisasi) >= 0 ? 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800/50' : 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800/50'}`}>
                                                    {parseFloat(hist.realisasi) > 0 ? '+' : ''}{hist.realisasi}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300">
                                                {hist.user?.name || '-'}
                                            </td>
                                            <td className="px-6 py-4 text-center">
                                                {hist.lampiran ? (
                                                    <a href={`/storage/${hist.lampiran}`} target="_blank" rel="noreferrer" className="inline-flex items-center justify-center w-8 h-8 rounded-full bg-brand-50 text-brand-600 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 transition-colors" title="Lihat Lampiran">
                                                        <i className="ph ph-file-text text-lg"></i>
                                                    </a>
                                                ) : (
                                                    <span className="text-slate-400">-</span>
                                                )}
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="5" className="px-6 py-12 text-center">
                                            <div className="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                                                <i className="ph ph-empty text-4xl mb-3"></i>
                                                <p>Belum ada riwayat WIG.</p>
                                            </div>
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                    
                    {/* Pagination */}
                    {histories.links && histories.links.length > 3 && (
                        <div className="px-6 py-4 border-t border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-900/50 flex justify-center">
                            <div className="flex gap-1">
                                {histories.links.map((link, i) => (
                                    <Link
                                        key={i}
                                        href={link.url || '#'}
                                        className={`px-3 py-1.5 text-sm rounded-lg transition-colors ${link.active ? 'bg-brand-600 text-white font-semibold' : link.url ? 'bg-white border border-surface-200 text-slate-600 hover:bg-surface-50 dark:bg-surface-800 dark:border-surface-700 dark:text-slate-300 dark:hover:bg-surface-700' : 'bg-surface-50 border border-surface-100 text-slate-400 cursor-not-allowed dark:bg-surface-900 dark:border-surface-800 dark:text-surface-600'}`}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                        preserveScroll
                                    />
                                ))}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
