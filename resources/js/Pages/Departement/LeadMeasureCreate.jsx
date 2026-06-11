import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import toast, { Toaster } from 'react-hot-toast';

export default function LeadMeasureCreate({ title, wig }) {
    const { data, setData, post, processing, errors } = useForm({
        judul_lead: '',
        deskripsi_lead: '',
        target: '',
        satuan: '%',
        tanggal_mulai: '',
        tanggal_selesai: '',
        status: 'active'
    });

    const submit = (e) => {
        e.preventDefault();
        post(`/wig/${wig.id}/lead-measure`, {
            onSuccess: () => {
                // Success redirect happens on backend
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title={title || "Tambah Lead Measure"} />
            <Toaster />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white uppercase">{title}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Tambah Lead Measure baru untuk WIG: {wig.judul_wig}</p>
                </div>
                <div className="flex gap-2">
                    <Link 
                        href={`/departement/${wig.departement_id}/wig/${wig.id}`} 
                        className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                    >
                        <i className="ph ph-arrow-left mr-2"></i>
                        Kembali
                    </Link>
                </div>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-soft border border-surface-100 dark:border-surface-700 overflow-hidden">
                <div className="p-6">
                    <form onSubmit={submit} className="space-y-6">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div className="md:col-span-2">
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Judul Lead</label>
                                <input
                                    type="text"
                                    required
                                    value={data.judul_lead}
                                    onChange={e => setData('judul_lead', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.judul_lead ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                />
                                {errors.judul_lead && <p className="mt-1 text-sm text-red-500">{errors.judul_lead}</p>}
                            </div>

                            <div className="md:col-span-2">
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi Lead</label>
                                <textarea
                                    required
                                    value={data.deskripsi_lead}
                                    onChange={e => setData('deskripsi_lead', e.target.value)}
                                    rows="3"
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.deskripsi_lead ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors resize-none`}
                                />
                                {errors.deskripsi_lead && <p className="mt-1 text-sm text-red-500">{errors.deskripsi_lead}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target</label>
                                <input
                                    type="number"
                                    required
                                    value={data.target}
                                    onChange={e => setData('target', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.target ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                />
                                {errors.target && <p className="mt-1 text-sm text-red-500">{errors.target}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Satuan</label>
                                <select
                                    required
                                    value={data.satuan}
                                    onChange={e => setData('satuan', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.satuan ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                >
                                    <option value="%">Persen (%)</option>
                                    <option value="Angka">Angka</option>
                                </select>
                                {errors.satuan && <p className="mt-1 text-sm text-red-500">{errors.satuan}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Mulai</label>
                                <input
                                    type="date"
                                    required
                                    value={data.tanggal_mulai}
                                    onChange={e => setData('tanggal_mulai', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.tanggal_mulai ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                />
                                {errors.tanggal_mulai && <p className="mt-1 text-sm text-red-500">{errors.tanggal_mulai}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Selesai</label>
                                <input
                                    type="date"
                                    required
                                    value={data.tanggal_selesai}
                                    onChange={e => setData('tanggal_selesai', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.tanggal_selesai ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                />
                                {errors.tanggal_selesai && <p className="mt-1 text-sm text-red-500">{errors.tanggal_selesai}</p>}
                            </div>

                            <div className="md:col-span-2">
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status</label>
                                <select
                                    required
                                    value={data.status}
                                    onChange={e => setData('status', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.status ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                >
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                {errors.status && <p className="mt-1 text-sm text-red-500">{errors.status}</p>}
                            </div>
                        </div>

                        <div className="pt-4 border-t border-surface-100 dark:border-surface-700 flex justify-end gap-3">
                            <Link 
                                href={`/departement/${wig.departement_id}/wig/${wig.id}`}
                                className="px-5 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-200 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 rounded-xl transition-colors"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="px-5 py-2.5 text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 disabled:opacity-50 rounded-xl shadow-sm transition-colors"
                            >
                                {processing ? 'Menyimpan...' : 'Simpan'}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
