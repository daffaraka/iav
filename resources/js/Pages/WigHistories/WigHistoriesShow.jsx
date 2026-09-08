import { useForm, usePage } from "@inertiajs/react"
import React from "react"

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';


export default function WigHistoriesIndex({ }) {

    const { auth } = usePage.props;

    const { data, setData, post, processing, errors } = useForm({
        _method: 'put',
        riwayat_wig: history.riwayat_wig || '',
        realisasi: history.realisasi || '',
        tanggal: history.tanggal || '',
        lampiran: null, // File baru jika ingin mengganti
    })

    const handleSubmit = (e) => {
        e.preventDefault();
        post(`/wig/${wig.id}/history/${history.id}`, {
            preserveScroll: true,
        });
    }

    return (
        <AuthenticatedLayout user={auth?.user}>
            <Head title={`Edit Riwayat - ${wig.judul_wig}`} />
            <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {/* Tombol Kembali */}
                <div className="mb-6">
                    <Link
                        href={`/wig/${wig.id}/history`}
                        className="inline-flex items-center gap-2 text-slate-500 hover:text-brand-500 transition-colors text-sm font-medium"
                    >
                        <ArrowLeft className="w-4 h-4" />
                        <span>Kembali ke Riwayat WIG</span>
                    </Link>
                </div>
                <div className="bg-white dark:bg-surface-800 rounded-3xl border border-surface-100 dark:border-surface-700 shadow-xl overflow-hidden p-8">
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white mb-1">
                        Edit Riwayat Progress
                    </h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mb-6">
                        WIG: <span className="font-semibold text-slate-700 dark:text-slate-300">{wig.judul_wig}</span>
                    </p>
                    <form onSubmit={handleSubmit} className="space-y-5">
                        {/* Keterangan Riwayat */}
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Keterangan Riwayat <span className="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                placeholder="Contoh: Penyelesaian milestone fase 1..."
                                value={data.riwayat_wig}
                                onChange={(e) => setData("riwayat_wig", e.target.value)}
                                className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                required
                            />
                            {errors.riwayat_wig && <p className="mt-1 text-xs text-red-500">{errors.riwayat_wig}</p>}
                        </div>
                        {/* Realisasi & Tanggal */}
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Penambahan Realisasi (Delta) <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    step="0.01"
                                    placeholder="Contoh: 10 atau 0.5"
                                    value={data.realisasi}
                                    onChange={(e) => setData("realisasi", e.target.value)}
                                    className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                    required
                                />
                                {errors.realisasi && <p className="mt-1 text-xs text-red-500">{errors.realisasi}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Tanggal <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    value={data.tanggal}
                                    onChange={(e) => setData("tanggal", e.target.value)}
                                    className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                    required
                                />
                                {errors.tanggal && <p className="mt-1 text-xs text-red-500">{errors.tanggal}</p>}
                            </div>
                        </div>
                        {/* Lampiran File */}
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Lampiran Dokumen (Opsional)
                            </label>

                            {/* Preview jika sudah ada file sebelumnya */}
                            {history.lampiran && (
                                <div className="mb-2 p-3 bg-surface-50 dark:bg-surface-900 rounded-xl border border-surface-200 dark:border-surface-700 flex items-center justify-between">
                                    <div className="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300">
                                        <FileText className="w-4 h-4 text-brand-500" />
                                        <span>File saat ini terlampir</span>
                                    </div>
                                    <a
                                        href={`/storage/${history.lampiran}`}
                                        target="_blank"
                                        rel="noreferrer"
                                        className="text-xs text-brand-600 hover:underline font-semibold"
                                    >
                                        Lihat File
                                    </a>
                                </div>
                            )}
                            <input
                                type="file"
                                onChange={(e) => setData("lampiran", e.target.files[0])}
                                className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                            />
                            <span className="text-xs text-slate-400 mt-1 block">
                                Biarkan kosong jika tidak ingin mengubah file lampiran.
                            </span>
                            {errors.lampiran && <p className="mt-1 text-xs text-red-500">{errors.lampiran}</p>}
                        </div>
                        {/* Tombol Aksi */}
                        <div className="pt-4 flex justify-end gap-3 border-t border-surface-100 dark:border-surface-700">
                            <Link
                                href={`/wig/${wig.id}/history`}
                                className="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 dark:bg-surface-700 dark:border-surface-600 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl transition-all font-semibold text-sm shadow-md disabled:opacity-50"
                            >
                                <Save className="w-4 h-4" />
                                <span>{processing ? "Menyimpan..." : "Perbarui Riwayat"}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );

}