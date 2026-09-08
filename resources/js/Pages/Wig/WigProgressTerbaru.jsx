import React from "react";



export default function WigProgressTerbaru({ progressTerbaru = [], formatDate, onEditClick, onDeleteClick }) {


    return (
        <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full flex flex-col">
            {/* Header Komponen */}
            <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                <h3 className="font-bold text-slate-800 dark:text-white flex items-center">
                    <i className="ph ph-clock-counter-clockwise text-brand-500 mr-2 text-xl"></i>
                    Progress WIG Terbaru
                </h3>
            </div>
            {/* List Konten */}
            <div className="p-0 flex-1 overflow-y-auto">
                <ul className="divide-y divide-surface-100 dark:divide-surface-700">
                    {progressTerbaru && progressTerbaru.length > 0 ? (
                        progressTerbaru.map((progress, idx) => {
                            const realisasiNum = parseFloat(progress.realisasi || 0);
                            return (
                                <li key={progress.id || idx} className="p-5 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors">
                                    <div className="flex justify-between gap-4">
                                        <div>
                                            <span className="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 mb-2">
                                                {formatDate ? formatDate(progress.tanggal) : progress.tanggal}
                                            </span>
                                            <h6 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">
                                                {progress.riwayat_wig || '-'}
                                            </h6>
                                        </div>
                                        <div className="text-right whitespace-nowrap flex flex-col justify-center">
                                            <span className={`block text-xl font-bold leading-none ${realisasiNum >= 0 ? 'text-green-500' : 'text-red-500'}`}>
                                                {realisasiNum > 0 ? '+' : ''}{progress.realisasi}
                                            </span>
                                            <span className="text-[10px] text-slate-500 uppercase tracking-wider font-semibold mt-1 mb-2">
                                                Delta
                                            </span>
                                            <div className="flex gap-1 justify-end">
                                                <button onClick={() => onEditClick && onEditClick(progress)} className="text-brand-500 text-xs hover:text-white transition-colors border-2 border-brand-500/50 hover:bg-brand-500 py-1 px-3 rounded-lg" title="Edit">
                                                    <i className="ph ph-pencil-simple text-sm"></i> Edit
                                                </button>
                                                <button onClick={() => onDeleteClick && onDeleteClick(progress)} className="text-red-500 text-xs hover:text-white transition-colors border-2 border-red-500/50 hover:bg-red-500 py-1 px-3 rounded-lg" title="Hapus">
                                                    <i className="ph ph-trash text-sm"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            );
                        })
                    ) : (
                        <li className="p-8 text-center text-slate-500">
                            <i className="ph ph-empty text-3xl mb-2 text-slate-300 dark:text-slate-600"></i>
                            <p className="text-sm">Belum ada progress terbaru</p>
                        </li>
                    )}
                </ul>
            </div>
        </div>

    );
}