import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import toast, { Toaster } from 'react-hot-toast';

export default function WigEdit({ title, dept, wig }) {
    const { data, setData, put, processing, errors } = useForm({
        nama_wig: wig.judul_wig || '',
        deskripsi_wig: wig.deskripsi_wig || '',
        tanggal_mulai_wig: wig.tanggal_mulai_wig || '',
        tanggal_berakhir_wig: wig.tanggal_berakhir_wig || '',
        from_x: wig.from_x || '',
        to_y: wig.to_y || '',
        satuan: wig.satuan || '%',
    });

    const submit = (e) => {
        e.preventDefault();
        put(`/wig/${wig.id}`, {
            onSuccess: () => {
                toast.success('WIG berhasil diupdate');
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title={title || "Edit WIG"} />
            <Toaster />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white uppercase">{title}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Edit data WIG untuk Departemen {dept.nama_dept}</p>
                </div>
                <div className="flex gap-2">
                    <Link 
                        href={`/departement/${dept.id}`} 
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
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama WIG</label>
                                <input
                                    type="text"
                                    required
                                    value={data.nama_wig}
                                    onChange={e => setData('nama_wig', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.nama_wig ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                />
                                {errors.nama_wig && <p className="mt-1 text-sm text-red-500">{errors.nama_wig}</p>}
                            </div>

                            <div className="md:col-span-2">
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi WIG</label>
                                <textarea
                                    required
                                    value={data.deskripsi_wig}
                                    onChange={e => setData('deskripsi_wig', e.target.value)}
                                    rows="3"
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.deskripsi_wig ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors resize-none`}
                                />
                                {errors.deskripsi_wig && <p className="mt-1 text-sm text-red-500">{errors.deskripsi_wig}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Mulai</label>
                                <input
                                    type="date"
                                    required
                                    value={data.tanggal_mulai_wig}
                                    onChange={e => setData('tanggal_mulai_wig', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.tanggal_mulai_wig ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                />
                                {errors.tanggal_mulai_wig && <p className="mt-1 text-sm text-red-500">{errors.tanggal_mulai_wig}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Berakhir</label>
                                <input
                                    type="date"
                                    required
                                    value={data.tanggal_berakhir_wig}
                                    onChange={e => setData('tanggal_berakhir_wig', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.tanggal_berakhir_wig ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                />
                                {errors.tanggal_berakhir_wig && <p className="mt-1 text-sm text-red-500">{errors.tanggal_berakhir_wig}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">From X (Angka)</label>
                                <input
                                    type="number"
                                    required
                                    value={data.from_x}
                                    onChange={e => setData('from_x', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.from_x ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                />
                                {errors.from_x && <p className="mt-1 text-sm text-red-500">{errors.from_x}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">To Y (Angka)</label>
                                <input
                                    type="number"
                                    required
                                    value={data.to_y}
                                    onChange={e => setData('to_y', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.to_y ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                />
                                {errors.to_y && <p className="mt-1 text-sm text-red-500">{errors.to_y}</p>}
                            </div>

                            <div className="md:col-span-2">
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Satuan</label>
                                <select
                                    value={data.satuan}
                                    onChange={e => setData('satuan', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.satuan ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 focus:border-brand-500 transition-colors`}
                                >
                                    <option value="%">Persen (%)</option>
                                    <option value="Angka">Angka</option>
                                </select>
                                {errors.satuan && <p className="mt-1 text-sm text-red-500">{errors.satuan}</p>}
                            </div>
                        </div>

                        <div className="pt-4 border-t border-surface-100 dark:border-surface-700 flex justify-end gap-3">
                            <Link 
                                href={`/departement/${dept.id}`}
                                className="px-5 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-200 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 rounded-xl transition-colors"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="px-5 py-2.5 text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 disabled:opacity-50 rounded-xl shadow-sm transition-colors"
                            >
                                {processing ? 'Menyimpan...' : 'Simpan Perubahan'}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
