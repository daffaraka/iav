import React from 'react';

export default function TaskModal({
    isOpen,
    onClose,
    taskData,
    setTaskData,
    submitTask,
    taskErrors,
    taskProcessing
}) {
    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
            <div className="bg-white dark:bg-surface-800 rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-center bg-surface-50/50 dark:bg-surface-800/50">
                    <h2 className="text-lg font-bold text-slate-800 dark:text-white flex items-center">
                        <i className="ph ph-list-plus text-brand-500 mr-2 text-xl"></i>
                        Tambah Task Baru
                    </h2>
                    <button
                        onClick={onClose}
                        className="w-8 h-8 flex items-center justify-center rounded-full bg-surface-100 text-surface-500 hover:bg-surface-200 dark:bg-surface-700 dark:text-surface-400 dark:hover:bg-surface-600 transition-colors"
                    >
                        <i className="ph ph-x"></i>
                    </button>
                </div>
                <div className="p-6 overflow-y-auto custom-scrollbar flex-1">
                    <form onSubmit={submitTask} className="space-y-4">
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Tugas/Task <span className="text-red-500">*</span></label>
                            <input
                                type="text"
                                value={taskData.nama_tugas}
                                onChange={e => setTaskData('nama_tugas', e.target.value)}
                                className={`w-full px-4 py-2.5 rounded-xl border ${taskErrors.nama_tugas ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500`}
                                required
                            />
                            {taskErrors.nama_tugas && <p className="mt-1 text-sm text-red-500">{taskErrors.nama_tugas}</p>}
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi</label>
                            <textarea
                                value={taskData.deskripsi}
                                onChange={e => setTaskData('deskripsi', e.target.value)}
                                rows="3"
                                className={`w-full px-4 py-2.5 rounded-xl border ${taskErrors.deskripsi ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 resize-none`}
                            ></textarea>
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Jumlah Realisasi</label>
                                <input
                                    type="number"
                                    value={taskData.jumlah_realisasi}
                                    onChange={e => setTaskData('jumlah_realisasi', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${taskErrors.jumlah_realisasi ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500`}
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Realisasi <span className="text-red-500">*</span></label>
                                <input
                                    type="date"
                                    value={taskData.tanggal_realisasi}
                                    onChange={e => setTaskData('tanggal_realisasi', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${taskErrors.tanggal_realisasi ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500`}
                                    required
                                />
                            </div>
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status Tugas</label>
                            <select
                                value={taskData.status_tugas}
                                onChange={e => setTaskData('status_tugas', e.target.value)}
                                className={`w-full px-4 py-2.5 rounded-xl border ${taskErrors.status_tugas ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500`}
                            >
                                <option value="0">Belum Selesai</option>
                                <option value="1">Selesai</option>
                            </select>
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
                        onClick={submitTask}
                        disabled={taskProcessing}
                        className="px-6 py-2 text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 rounded-xl transition-colors disabled:opacity-50"
                    >
                        {taskProcessing ? 'Menyimpan...' : 'Submit Task'}
                    </button>
                </div>
            </div>
        </div>
    );
}
