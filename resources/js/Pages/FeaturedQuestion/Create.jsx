import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function Create({ title }) {
    const { data, setData, post, processing, errors } = useForm({
        judul: '',
        jawaban: '',
        kategori: '',
        is_pinned: false,
        is_published: false,
        order: 0,
        tiket_id: ''
    });

    const submit = (e) => {
        e.preventDefault();
        post('/featured-question');
    };

    return (
        <AuthenticatedLayout>
            <Head title={title || "Tambah Featured Question"} />

            <div className="mb-6 flex items-center justify-between">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">{title || "Tambah Featured Question"}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Buat FAQ baru untuk pengguna</p>
                </div>
                <Link 
                    href="/featured-question" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-arrow-left mr-2"></i>
                    Kembali
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 transition-colors duration-300">
                <form onSubmit={submit} className="space-y-6 max-w-3xl">
                    <div>
                        <label htmlFor="judul" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Judul (Pertanyaan) <span className="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="judul"
                            value={data.judul}
                            onChange={(e) => setData('judul', e.target.value)}
                            className={`w-full px-4 py-2.5 rounded-xl border ${errors.judul ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                            placeholder="Contoh: Bagaimana cara reset password?"
                        />
                        {errors.judul && <p className="mt-1 text-sm text-red-500">{errors.judul}</p>}
                    </div>

                    <div>
                        <label htmlFor="kategori" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Kategori <span className="text-red-500">*</span>
                        </label>
                        <select
                            id="kategori"
                            value={data.kategori}
                            onChange={(e) => setData('kategori', e.target.value)}
                            className={`w-full px-4 py-2.5 rounded-xl border ${errors.kategori ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                        >
                            <option value="">Pilih Kategori</option>
                            <option value="Akademik">Akademik</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="Fasilitas Sarpras">Fasilitas Sarpras</option>
                            <option value="PPDB">PPDB</option>
                            <option value="SDM">SDM</option>
                            <option value="IT">IT</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        {errors.kategori && <p className="mt-1 text-sm text-red-500">{errors.kategori}</p>}
                    </div>

                    <div>
                        <label htmlFor="jawaban" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Jawaban <span className="text-red-500">*</span>
                        </label>
                        <textarea
                            id="jawaban"
                            value={data.jawaban}
                            onChange={(e) => setData('jawaban', e.target.value)}
                            rows={6}
                            className={`w-full px-4 py-2.5 rounded-xl border ${errors.jawaban ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                            placeholder="Tuliskan jawaban yang lengkap..."
                        ></textarea>
                        {errors.jawaban && <p className="mt-1 text-sm text-red-500">{errors.jawaban}</p>}
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label htmlFor="order" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Urutan (Order)
                            </label>
                            <input
                                type="number"
                                id="order"
                                value={data.order}
                                onChange={(e) => setData('order', e.target.value)}
                                className={`w-full px-4 py-2.5 rounded-xl border ${errors.order ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                            />
                            {errors.order && <p className="mt-1 text-sm text-red-500">{errors.order}</p>}
                        </div>

                        <div>
                            <label htmlFor="tiket_id" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Referensi ID Tiket (Opsional)
                            </label>
                            <input
                                type="text"
                                id="tiket_id"
                                value={data.tiket_id}
                                onChange={(e) => setData('tiket_id', e.target.value)}
                                className={`w-full px-4 py-2.5 rounded-xl border ${errors.tiket_id ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                placeholder="Contoh: 123"
                            />
                            {errors.tiket_id && <p className="mt-1 text-sm text-red-500">{errors.tiket_id}</p>}
                        </div>
                    </div>

                    <div className="flex flex-col sm:flex-row gap-6 p-4 bg-surface-50 dark:bg-surface-800/50 rounded-xl border border-surface-100 dark:border-surface-700">
                        <label className="flex items-center cursor-pointer">
                            <div className="relative">
                                <input
                                    type="checkbox"
                                    className="sr-only"
                                    checked={data.is_published}
                                    onChange={(e) => setData('is_published', e.target.checked)}
                                />
                                <div className={`block w-10 h-6 rounded-full transition-colors ${data.is_published ? 'bg-emerald-500' : 'bg-surface-300 dark:bg-surface-600'}`}></div>
                                <div className={`dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform ${data.is_published ? 'transform translate-x-4' : ''}`}></div>
                            </div>
                            <div className="ml-3">
                                <span className="text-sm font-medium text-slate-700 dark:text-slate-300">Published (Tampil ke publik)</span>
                            </div>
                        </label>

                        <label className="flex items-center cursor-pointer">
                            <div className="relative">
                                <input
                                    type="checkbox"
                                    className="sr-only"
                                    checked={data.is_pinned}
                                    onChange={(e) => setData('is_pinned', e.target.checked)}
                                />
                                <div className={`block w-10 h-6 rounded-full transition-colors ${data.is_pinned ? 'bg-amber-500' : 'bg-surface-300 dark:bg-surface-600'}`}></div>
                                <div className={`dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform ${data.is_pinned ? 'transform translate-x-4' : ''}`}></div>
                            </div>
                            <div className="ml-3">
                                <span className="text-sm font-medium text-slate-700 dark:text-slate-300">Pinned (Sematkan di atas)</span>
                            </div>
                        </label>
                    </div>

                    <div className="pt-4 flex items-center justify-end">
                        <button
                            type="submit"
                            disabled={processing}
                            className="inline-flex items-center justify-center px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors disabled:opacity-50"
                        >
                            {processing ? 'Menyimpan...' : 'Simpan FAQ'}
                        </button>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
