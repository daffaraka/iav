import React from 'react';

export default function ViewTasksModal({
    isOpen,
    onClose,
    activeMonth,
    viewTasksData,
    toggleTaskStatus
}) {
    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
            <div className="bg-white dark:bg-surface-800 rounded-3xl w-full max-w-3xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-center bg-surface-50/50 dark:bg-surface-800/50">
                    <div>
                        <h2 className="text-lg font-bold text-slate-800 dark:text-white">Daftar Task</h2>
                        <p className="text-sm text-slate-500">Bulan: {activeMonth}</p>
                    </div>
                    <button
                        onClick={onClose}
                        className="w-8 h-8 flex items-center justify-center rounded-full bg-surface-100 text-surface-500 hover:bg-surface-200 dark:bg-surface-700 dark:text-surface-400 dark:hover:bg-surface-600 transition-colors"
                    >
                        <i className="ph ph-x"></i>
                    </button>
                </div>
                <div className="p-0 overflow-y-auto custom-scrollbar flex-1">
                    {viewTasksData.length > 0 ? (
                        <table className="w-full text-left text-sm">
                            <thead className="bg-surface-50 dark:bg-surface-900 border-b border-surface-100 dark:border-surface-700 sticky top-0 z-10">
                                <tr>
                                    <th className="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300 w-16">Done</th>
                                    <th className="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Nama Tugas</th>
                                    <th className="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300 text-center">Status</th>
                                    <th className="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300 text-right">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-surface-100 dark:divide-surface-700">
                                {viewTasksData.map(task => (
                                    <tr key={task.id} className={`transition-colors ${task.status_tugas === 1 ? 'bg-green-50/50 dark:bg-green-900/10' : 'hover:bg-surface-50 dark:hover:bg-surface-800/50'}`}>
                                        <td className="px-6 py-4 text-center">
                                            <input
                                                type="checkbox"
                                                checked={task.status_tugas === 1}
                                                onChange={() => toggleTaskStatus(task.id, task.status_tugas)}
                                                className="rounded border-surface-300 text-green-500 focus:ring-green-500 w-5 h-5 cursor-pointer"
                                            />
                                        </td>
                                        <td className="px-6 py-4 font-medium text-slate-800 dark:text-slate-200">
                                            {task.nama_tugas}
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            {task.status_tugas === 1 ? (
                                                <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800/50">
                                                    Selesai
                                                </span>
                                            ) : (
                                                <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                                                    Belum
                                                </span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-right text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                            {task.tanggal_realisasi}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    ) : (
                        <div className="p-10 text-center">
                            <i className="ph ph-empty text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                            <p className="text-slate-500">Tidak ada task pada bulan ini.</p>
                        </div>
                    )}
                </div>
                <div className="px-6 py-4 border-t border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50 flex justify-end">
                    <button
                        onClick={onClose}
                        className="px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 dark:bg-surface-700 dark:border-surface-600 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    );
}
