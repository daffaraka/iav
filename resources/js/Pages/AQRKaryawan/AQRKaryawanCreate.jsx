import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
    Ticket as TicketIcon,
    ArrowLeft as ArrowLeftIcon,
    FileText as DocumentTextIcon,
    Paperclip as PaperClipIcon
} from 'lucide-react';

export default function Create({ auth }) {
    const { data, setData, post, processing, errors } = useForm({
        judul_kendala: '',
        departemen: '',
        masalah_dept: '',
        lokasi_kendala: '',
        detail_kendala: '',
        filename: null
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/dashboard/aqr/tiket-karyawan');
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-slate-800 dark:text-white leading-tight">Buat Tiket Karyawan</h2>}
        >
            <Head title="Buat Tiket Karyawan" />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    
                    <div className="mb-6">
                        <Link 
                            href="/dashboard/aqr/tiket-karyawan" 
                            className="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition-colors"
                        >
                            <ArrowLeftIcon className="w-4 h-4" />
                            Kembali ke Daftar Tiket
                        </Link>
                    </div>

                    <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-800 overflow-hidden">
                        <div className="p-6 sm:p-8 border-b border-surface-200 dark:border-surface-800">
                            <h3 className="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <DocumentTextIcon className="w-6 h-6 text-brand-500" />
                                Form Pengaduan / Request
                            </h3>
                            <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                Silakan lengkapi detail masalah atau permintaan Anda di bawah ini.
                            </p>
                        </div>

                        <div className="p-6 sm:p-8">
                            <form onSubmit={handleSubmit} className="space-y-6">
                                
                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Judul Kendala / Permintaan</label>
                                    <input
                                        type="text"
                                        value={data.judul_kendala}
                                        onChange={e => setData('judul_kendala', e.target.value)}
                                        className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-brand-500 transition-colors"
                                        placeholder="Contoh: AC Ruang Guru Rusak"
                                        required
                                    />
                                    {errors.judul_kendala && <p className="mt-1 text-sm text-red-500">{errors.judul_kendala}</p>}
                                </div>

                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Departemen Tujuan</label>
                                        <select
                                            value={data.departemen}
                                            onChange={e => setData('departemen', e.target.value)}
                                            className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-brand-500 transition-colors"
                                            required
                                        >
                                            <option value="">Pilih Departemen</option>
                                            <option value="IT">IT Support</option>
                                            <option value="GA">General Affair (GA)</option>
                                            <option value="HR">Human Resources (HRD)</option>
                                            <option value="Finance">Keuangan</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        {errors.departemen && <p className="mt-1 text-sm text-red-500">{errors.departemen}</p>}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Lokasi</label>
                                        <select
                                            value={data.lokasi_kendala}
                                            onChange={e => setData('lokasi_kendala', e.target.value)}
                                            className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-brand-500 transition-colors"
                                            required
                                        >
                                            <option value="">Pilih Lokasi</option>
                                            <option value="Cinere">Cinere</option>
                                            <option value="Jagakarsa">Jagakarsa</option>
                                            <option value="Pamulang">Pamulang</option>
                                            <option value="BPS">BPS</option>
                                        </select>
                                        {errors.lokasi_kendala && <p className="mt-1 text-sm text-red-500">{errors.lokasi_kendala}</p>}
                                    </div>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori Masalah</label>
                                    <input
                                        type="text"
                                        value={data.masalah_dept}
                                        onChange={e => setData('masalah_dept', e.target.value)}
                                        className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-brand-500 transition-colors"
                                        placeholder="Contoh: Hardware, Software, Fasilitas"
                                        required
                                    />
                                    {errors.masalah_dept && <p className="mt-1 text-sm text-red-500">{errors.masalah_dept}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Detail Kendala</label>
                                    <textarea
                                        value={data.detail_kendala}
                                        onChange={e => setData('detail_kendala', e.target.value)}
                                        rows="4"
                                        className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-brand-500 transition-colors"
                                        placeholder="Jelaskan secara detail mengenai masalah atau permintaan Anda..."
                                        required
                                    ></textarea>
                                    {errors.detail_kendala && <p className="mt-1 text-sm text-red-500">{errors.detail_kendala}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Lampiran (Opsional)</label>
                                    <div className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-surface-300 dark:border-surface-700 border-dashed rounded-xl bg-surface-50 dark:bg-surface-800/50 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                                        <div className="space-y-1 text-center">
                                            <PaperClipIcon className="mx-auto h-12 w-12 text-slate-400" />
                                            <div className="flex text-sm text-slate-600 dark:text-slate-400">
                                                <label htmlFor="file-upload" className="relative cursor-pointer rounded-md font-medium text-brand-600 hover:text-brand-500 focus-within:outline-none">
                                                    <span>Upload file</span>
                                                    <input 
                                                        id="file-upload" 
                                                        name="file-upload" 
                                                        type="file" 
                                                        className="sr-only"
                                                        onChange={e => setData('filename', e.target.files[0])}
                                                    />
                                                </label>
                                                <p className="pl-1">atau drag and drop</p>
                                            </div>
                                            <p className="text-xs text-slate-500">PNG, JPG, PDF up to 10MB</p>
                                        </div>
                                    </div>
                                    {data.filename && (
                                        <div className="mt-2 text-sm text-brand-600">
                                            File terpilih: {data.filename.name}
                                        </div>
                                    )}
                                    {errors.filename && <p className="mt-1 text-sm text-red-500">{errors.filename}</p>}
                                </div>

                                <div className="pt-4 flex justify-end">
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="inline-flex justify-center items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-medium rounded-xl transition-all shadow-sm shadow-brand-500/20 disabled:opacity-50"
                                    >
                                        Kirim Tiket
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
