import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function Edit({ aqrOption }) {
    const { data, setData, put, processing, errors } = useForm({
        nama_option: aqrOption.nama_option || '',
        kategori_pic: aqrOption.kategori_pic || '',
        is_aktif: aqrOption.is_aktif === 1 || aqrOption.is_aktif === true
    });

    const submit = (e) => {
        e.preventDefault();
        put(`/aqr-option/${aqrOption.id}`);
    };

    return (
        <AuthenticatedLayout>
            <Head title="Edit AQR Option" />

            <div className="mb-6 flex items-center justify-between">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">Edit AQR Option</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Ubah opsi {aqrOption.nama_option}</p>
                </div>
                <Link 
                    href="/aqr-option" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-arrow-left mr-2"></i>
                    Kembali
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 transition-colors duration-300">
                <form onSubmit={submit} className="space-y-6 max-w-2xl">
                    <div>
                        <label htmlFor="nama_option" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Nama Option <span className="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama_option"
                            value={data.nama_option}
                            onChange={(e) => setData('nama_option', e.target.value)}
                            className={`w-full px-4 py-2.5 rounded-xl border ${errors.nama_option ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                            placeholder="Contoh: IT Support"
                        />
                        {errors.nama_option && <p className="mt-1 text-sm text-red-500">{errors.nama_option}</p>}
                    </div>

                    <div>
                        <label htmlFor="kategori_pic" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Kategori PIC <span className="text-red-500">*</span>
                        </label>
                        <select
                            id="kategori_pic"
                            value={data.kategori_pic}
                            onChange={(e) => setData('kategori_pic', e.target.value)}
                            className={`w-full px-4 py-2.5 rounded-xl border ${errors.kategori_pic ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                        >
                            <option value="">Pilih Kategori PIC</option>
                            <option value="IT">IT</option>
                            <option value="HRD">HRD</option>
                            <option value="Finance">Finance</option>
                            <option value="Sarpras">Sarpras</option>
                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                            <option value="Kepala TU">Kepala TU</option>
                            <option value="Psikolog">Psikolog</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        {errors.kategori_pic && <p className="mt-1 text-sm text-red-500">{errors.kategori_pic}</p>}
                    </div>

                    <div className="flex items-center">
                        <input
                            type="checkbox"
                            id="is_aktif"
                            checked={data.is_aktif}
                            onChange={(e) => setData('is_aktif', e.target.checked)}
                            className="w-5 h-5 rounded border-surface-300 dark:border-surface-600 text-brand-600 focus:ring-brand-500 dark:bg-surface-900"
                        />
                        <label htmlFor="is_aktif" className="ml-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Status Aktif
                        </label>
                    </div>
                    {errors.is_aktif && <p className="mt-1 text-sm text-red-500">{errors.is_aktif}</p>}

                    <div className="pt-4 flex items-center justify-end">
                        <button
                            type="submit"
                            disabled={processing}
                            className="inline-flex items-center justify-center px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors disabled:opacity-50"
                        >
                            {processing ? 'Menyimpan...' : 'Simpan Perubahan'}
                        </button>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
