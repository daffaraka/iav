import React from 'react';

export default function HistoryEditModal({
    isOpen,
    onClose,
    histData,
    setHistData,
    submitHistory,
    histProcessing
}) {
    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
            <div className="bg-white dark:bg-surface-800 rounded-3xl w-full max-w-md shadow-2xl overflow-hidden flex flex-col">
                <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-center bg-surface-50/50 dark:bg-surface-800/50">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white">Edit Riwayat WIG</h2>
                    <button
                        onClick={onClose}
                        className="w-8 h-8 flex items-center justify-center rounded-full bg-surface-100 text-surface-500 hover:bg-surface-200 dark:bg-surface-700 dark:text-surface-400 dark:hover:bg-surface-600 transition-colors"
                    >
                        <i className="ph ph-x"></i>
                    </button>
                </div>
                <div className="p-6">
                    <form onSubmit={submitHistory} className="space-y-4">
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Riwayat WIG (Keterangan) <span className="text-red-500">*</span></label>
                            <input
                                type="text"
                                placeholder="Contoh: Penyelesaian milestone fase 1..."
                                value={histData.riwayat_wig}
                                onChange={e => setHistData('riwayat_wig', e.target.value)}
                                className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                required
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Penambahan Realisasi (Delta) <span className="text-red-500">*</span></label>
                            <input
                                type="number"
                                step="0.01"
                                placeholder="Contoh: 10 atau 0.5"
                                value={histData.realisasi}
                                onChange={e => setHistData('realisasi', e.target.value)}
                                className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                required
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal <span className="text-red-500">*</span></label>
                            <input
                                type="date"
                                value={histData.tanggal}
                                onChange={e => setHistData('tanggal', e.target.value)}
                                className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                required
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Lampiran (Opsional)</label>
                            <input
                                type="file"
                                onChange={e => setHistData('lampiran', e.target.files[0])}
                                className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                            />
                        </div>
                    </form>
                </div>
                <div className="px-6 py-4 border-t border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50 flex justify-end gap-3">
                    <button
                        onClick={onClose}
                        className="px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 dark:bg-surface-700 dark:border-surface-600 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        onClick={submitHistory}
                        disabled={histProcessing}
                        className="px-6 py-2 text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 rounded-xl transition-colors disabled:opacity-50"
                    >
                        {histProcessing ? 'Menyimpan...' : 'Simpan'}
                    </button>
                </div>
            </div>
        </div>
    );
}
