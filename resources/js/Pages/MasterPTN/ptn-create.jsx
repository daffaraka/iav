import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function PtnCreate() {
    const { data, setData, post, processing, errors } = useForm({
        nama_pt: '',
        status_pt: '',
        lokasi: '',
        provinsi: '',
        kota: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/master-ptn');
    };

    return (
        <AuthenticatedLayout>
            <Head title="Tambah Data PTN/PTS" />

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Tambah PTN/PTS</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Tambahkan data perguruan tinggi baru.</p>
                </div>
                <Link
                    href="/master-ptn"
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 dark:bg-surface-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium hover:bg-surface-200 dark:hover:bg-surface-600 focus:outline-none focus:ring-2 focus:ring-surface-500 focus:ring-offset-2 transition-all"
                >
                    <i className="ph ph-arrow-left mr-2 text-lg"></i>
                    Kembali
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 overflow-hidden max-w-3xl">
                <div className="p-6">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Perguruan Tinggi <span className="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    value={data.nama_pt}
                                    onChange={e => setData('nama_pt', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.nama_pt ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all`}
                                    placeholder="Masukkan nama PTN/PTS"
                                    required
                                />
                                {errors.nama_pt && <p className="mt-1.5 text-sm text-red-500">{errors.nama_pt}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Status PT <span className="text-red-500">*</span></label>
                                <select
                                    value={data.status_pt}
                                    onChange={e => setData('status_pt', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.status_pt ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all`}
                                    required
                                >
                                    <option value="">-- Pilih Status --</option>
                                    <option value="PTN">PTN (Negeri)</option>
                                    <option value="PTS">PTS (Swasta)</option>
                                </select>
                                {errors.status_pt && <p className="mt-1.5 text-sm text-red-500">{errors.status_pt}</p>}
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Lokasi Lengkap</label>
                            <input
                                type="text"
                                value={data.lokasi}
                                onChange={e => setData('lokasi', e.target.value)}
                                className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20 bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all"
                                placeholder="Masukkan lokasi (opsional)"
                            />
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Provinsi</label>
                                <input
                                    type="text"
                                    value={data.provinsi}
                                    onChange={e => setData('provinsi', e.target.value)}
                                    className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20 bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all"
                                    placeholder="Masukkan provinsi (opsional)"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kota</label>
                                <input
                                    type="text"
                                    value={data.kota}
                                    onChange={e => setData('kota', e.target.value)}
                                    className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20 bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all"
                                    placeholder="Masukkan kota (opsional)"
                                />
                            </div>
                        </div>

                        <div className="flex items-center justify-end gap-3 pt-6 border-t border-surface-100 dark:border-surface-700">
                            <Link
                                href="/master-ptn"
                                className="px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="px-5 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 disabled:opacity-70 disabled:cursor-not-allowed transition-all flex items-center"
                            >
                                {processing && <i className="ph ph-spinner animate-spin mr-2"></i>}
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
