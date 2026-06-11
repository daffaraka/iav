import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function MasterKelasEdit({ kelas, guru }) {
    const { data, setData, put, processing, errors } = useForm({
        nama_kelas: kelas.nama_kelas || '',
        deskripsi: kelas.deskripsi || '',
        wali_kelas_id: kelas.wali_kelas_id || ''
    });

    const submit = (e) => {
        e.preventDefault();
        put(`/master-kelas/${kelas.id}`);
    };

    return (
        <AuthenticatedLayout>
            <Head title="Edit Master Kelas" />

            <div className="mb-6 flex items-center justify-between">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">Edit Master Kelas</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Perbarui informasi kelas</p>
                </div>
                <Link 
                    href="/master-kelas" 
                    className="px-4 py-2 text-sm font-semibold text-slate-600 bg-surface-200 hover:bg-surface-300 dark:bg-surface-700 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors"
                >
                    Kembali
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 p-6">
                <form onSubmit={submit} className="max-w-2xl space-y-6">
                    <div>
                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Nama Kelas <span className="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            value={data.nama_kelas}
                            onChange={e => setData('nama_kelas', e.target.value)}
                            className={`w-full rounded-xl border ${errors.nama_kelas ? 'border-red-500' : 'border-surface-200 dark:border-surface-700'} bg-surface-50 dark:bg-surface-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none transition-all`}
                        />
                        {errors.nama_kelas && <p className="mt-1 text-sm text-red-500">{errors.nama_kelas}</p>}
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Wali Kelas
                        </label>
                        <select
                            value={data.wali_kelas_id}
                            onChange={e => setData('wali_kelas_id', e.target.value)}
                            className={`w-full rounded-xl border ${errors.wali_kelas_id ? 'border-red-500' : 'border-surface-200 dark:border-surface-700'} bg-surface-50 dark:bg-surface-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none transition-all`}
                        >
                            <option value="">-- Pilih Wali Kelas (Opsional) --</option>
                            {guru && guru.map(g => (
                                <option key={g.id} value={g.id}>{g.name}</option>
                            ))}
                        </select>
                        {errors.wali_kelas_id && <p className="mt-1 text-sm text-red-500">{errors.wali_kelas_id}</p>}
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Deskripsi
                        </label>
                        <textarea
                            value={data.deskripsi}
                            onChange={e => setData('deskripsi', e.target.value)}
                            className={`w-full rounded-xl border ${errors.deskripsi ? 'border-red-500' : 'border-surface-200 dark:border-surface-700'} bg-surface-50 dark:bg-surface-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none transition-all`}
                            rows="3"
                        ></textarea>
                        {errors.deskripsi && <p className="mt-1 text-sm text-red-500">{errors.deskripsi}</p>}
                    </div>

                    <div className="flex justify-end gap-3 pt-4 border-t border-surface-200 dark:border-surface-700">
                        <button
                            type="button"
                            onClick={() => window.history.back()}
                            className="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            disabled={processing}
                            className="px-5 py-2.5 text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-colors inline-flex items-center"
                        >
                            {processing && <i className="ph ph-spinner animate-spin mr-2"></i>}
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
