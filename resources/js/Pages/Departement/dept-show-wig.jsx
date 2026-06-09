import React, { useState } from 'react';
import { Head, Link, useForm, router } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import Chart from 'react-apexcharts';

export default function DepartementShowWig({ title, wig, departement, progressTerbaru, data_lm, chartWig }) {
    const [isProgressModalOpen, setIsProgressModalOpen] = useState(false);
    const [isTaskModalOpen, setIsTaskModalOpen] = useState(false);
    const [isViewTasksModalOpen, setIsViewTasksModalOpen] = useState(false);
    
    const [activeLmId, setActiveLmId] = useState(null);
    const [activeMonth, setActiveMonth] = useState(null);
    const [viewTasksData, setViewTasksData] = useState([]);

    const { data: progData, setData: setProgData, post: postProg, processing: progProcessing, reset: progReset, errors: progErrors } = useForm({
        wig_id: wig.id,
        progress_wig: '',
        bulan_wig: '1'
    });

    const { data: taskData, setData: setTaskData, post: postTask, processing: taskProcessing, reset: taskReset, errors: taskErrors } = useForm({
        lm_id: '',
        nama_tugas: '',
        deskripsi: '',
        jumlah_realisasi: '',
        tanggal_realisasi: '',
        status_tugas: '0'
    });

    const submitProgress = (e) => {
        e.preventDefault();
        postProg(`/departement/${departement.id}/wig/${wig.id}/progress-wig/store`, {
            onSuccess: () => {
                setIsProgressModalOpen(false);
                progReset();
            }
        });
    };

    const submitTask = (e) => {
        e.preventDefault();
        taskData.lm_id = activeLmId; // Ensure LM ID is set
        postTask(`/lead-measure/${activeLmId}/task`, {
            onSuccess: () => {
                setIsTaskModalOpen(false);
                taskReset();
            }
        });
    };

    const toggleTaskStatus = (taskId, currentStatus) => {
        const newStatus = currentStatus === 1 ? 0 : 1;
        router.post('/tasks/toggle-status', { id: taskId, status_tugas: newStatus }, {
            preserveScroll: true,
            onSuccess: () => {
                // If view modal is open, update its local state too for immediate feedback
                if (isViewTasksModalOpen) {
                    setViewTasksData(viewTasksData.map(t => t.id === taskId ? { ...t, status_tugas: newStatus } : t));
                }
            }
        });
    };

    const openViewTasksModal = (lmId, bulan) => {
        setActiveLmId(lmId);
        setActiveMonth(bulan);
        
        // Find tasks in data_lm
        const lmData = data_lm[lmId] || {};
        const tasks = lmData[bulan] || [];
        
        setViewTasksData(tasks);
        setIsViewTasksModalOpen(true);
    };

    // Chart Configuration
    const getChartOptions = () => {
        if (!chartWig) return { options: {}, series: [] };
        
        // Convert object to array if necessary, or just map if it's already an array
        const chartDataArray = Object.values(chartWig);
        const progressData = chartDataArray.map(item => item.progress);
        const bulanData = chartDataArray.map(item => item.bulan);

        return {
            series: [{
                name: 'Progress',
                data: progressData
            }],
            options: {
                chart: {
                    type: 'bar',
                    toolbar: { show: true },
                    fontFamily: 'Inter, sans-serif'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '50%',
                    }
                },
                colors: ['#3b82f6'],
                dataLabels: {
                    enabled: true,
                    style: { colors: ['#fff'] }
                },
                xaxis: {
                    categories: bulanData,
                    labels: { style: { colors: '#64748b' } }
                },
                yaxis: {
                    labels: { style: { colors: '#64748b' } },
                    title: { text: 'Jumlah', style: { color: '#64748b', fontWeight: 600 } }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        inverseColors: true,
                        stops: [0, 90, 100]
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                }
            }
        };
    };

    const chartConfig = getChartOptions();

    return (
        <AuthenticatedLayout>
            <Head title={title || "Detail WIG"} />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white uppercase">{title}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Monitoring detail progress WIG dan Lead Measure</p>
                </div>
                <div className="flex gap-2">
                    <Link 
                        href={`/departement/${departement.id}`} 
                        className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                    >
                        <i className="ph ph-arrow-left mr-2"></i>
                        Kembali
                    </Link>
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div className="lg:col-span-2">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-center bg-surface-50/50 dark:bg-surface-800/50">
                            <h3 className="font-bold text-slate-800 dark:text-white flex items-center">
                                <i className="ph ph-chart-bar text-brand-500 mr-2 text-xl"></i>
                                Grafik Progress WIG
                            </h3>
                            <div className="flex gap-2">
                                <Link 
                                    href={`/wig/${wig.id}/riwayat`}
                                    className="px-3 py-1.5 text-xs font-semibold bg-surface-100 text-surface-600 hover:bg-surface-200 dark:bg-surface-700 dark:text-surface-300 dark:hover:bg-surface-600 rounded-lg transition-colors inline-flex items-center"
                                >
                                    <i className="ph ph-list-dashes mr-1 text-base"></i> Riwayat
                                </Link>
                                <button 
                                    onClick={() => setIsProgressModalOpen(true)}
                                    className="px-3 py-1.5 text-xs font-semibold bg-brand-50 text-brand-600 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 rounded-lg transition-colors inline-flex items-center"
                                >
                                    <i className="ph ph-plus-circle mr-1 text-base"></i> Progress
                                </button>
                            </div>
                        </div>
                        <div className="p-4">
                            {chartConfig.series[0].data.length > 0 ? (
                                <Chart 
                                    options={chartConfig.options} 
                                    series={chartConfig.series} 
                                    type="bar" 
                                    height={400} 
                                />
                            ) : (
                                <div className="h-[400px] flex items-center justify-center text-slate-400 bg-surface-50 dark:bg-surface-900/30 rounded-xl border border-dashed border-surface-200 dark:border-surface-700">
                                    <div className="text-center">
                                        <i className="ph ph-chart-bar text-4xl mb-2"></i>
                                        <p>Belum ada progress WIG yang dicatat.</p>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                <div className="lg:col-span-1">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full flex flex-col">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                            <h3 className="font-bold text-slate-800 dark:text-white flex items-center">
                                <i className="ph ph-clock-counter-clockwise text-brand-500 mr-2 text-xl"></i>
                                Progress Terbaru
                            </h3>
                        </div>
                        <div className="p-0 flex-1 overflow-y-auto">
                            <ul className="divide-y divide-surface-100 dark:divide-surface-700">
                                {progressTerbaru && progressTerbaru.length > 0 ? (
                                    progressTerbaru.map((progress, idx) => (
                                        <li key={idx} className="p-5 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors">
                                            <div className="flex justify-between gap-4">
                                                <div>
                                                    <span className="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 mb-2">
                                                        {progress.lead_measure?.judul_lead || 'Lead Measure'}
                                                    </span>
                                                    <h6 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">{progress.nama_tugas}</h6>
                                                </div>
                                                <div className="text-right whitespace-nowrap">
                                                    <span className="block text-xl font-bold text-green-500 leading-none">{progress.jumlah_realisasi || 0}</span>
                                                    <span className="text-[10px] text-slate-500 uppercase tracking-wider font-semibold">Realisasi</span>
                                                </div>
                                            </div>
                                        </li>
                                    ))
                                ) : (
                                    <li className="p-8 text-center text-slate-500">
                                        <i className="ph ph-empty text-3xl mb-2 text-slate-300 dark:text-slate-600"></i>
                                        <p className="text-sm">Belum ada progress terbaru</p>
                                    </li>
                                )}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div className="mb-6 flex justify-between items-center">
                <h2 className="text-xl font-bold text-slate-800 dark:text-white">Daftar Lead Measure</h2>
                <Link 
                    href={`/wig/${wig.id}/lead-measure/create`} 
                    className="inline-flex items-center justify-center px-4 py-2 bg-slate-800 hover:bg-slate-900 dark:bg-slate-100 dark:hover:bg-white text-white dark:text-slate-800 rounded-xl text-sm font-semibold transition-colors shadow-sm"
                >
                    <i className="ph ph-plus mr-2"></i>
                    Tambah Lead Measure
                </Link>
            </div>

            {wig.lead_measures && wig.lead_measures.map((lm) => (
                <div key={lm.id} className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden mb-6">
                    <div className="p-6 border-b border-surface-100 dark:border-surface-700 flex flex-col md:flex-row justify-between md:items-center gap-4">
                        <div>
                            <h4 className="text-lg font-bold text-slate-800 dark:text-white mb-1">{lm.judul_lead}</h4>
                            <p className="text-sm text-slate-600 dark:text-slate-400">{lm.deskripsi_lead}</p>
                        </div>
                        <button 
                            onClick={() => { setActiveLmId(lm.id); setIsTaskModalOpen(true); }}
                            className="inline-flex items-center justify-center px-4 py-2 bg-brand-50 text-brand-600 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 border border-brand-200 dark:border-brand-800 rounded-xl text-sm font-semibold transition-colors whitespace-nowrap"
                        >
                            <i className="ph ph-list-plus mr-2 text-lg"></i>
                            Tambah Task Baru
                        </button>
                    </div>
                    <div className="overflow-x-auto custom-scrollbar">
                        {data_lm && data_lm[lm.id] ? (
                            <table className="w-full text-left text-sm whitespace-nowrap">
                                <thead>
                                    <tr className="bg-slate-800 dark:bg-surface-900 text-white">
                                        <th className="px-4 py-3 font-semibold text-center border-r border-slate-700 w-48">Lead Measure</th>
                                        {Object.keys(data_lm[lm.id] || {}).map(bulan => (
                                            <th key={bulan} className="px-4 py-3 font-semibold text-center border-r border-slate-700 min-w-[120px]">{bulan}</th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-surface-100 dark:divide-surface-700 bg-white dark:bg-surface-800">
                                    <tr>
                                        <td className="px-4 py-4 font-bold text-center border-r border-surface-100 dark:border-surface-700 text-slate-700 dark:text-slate-300">
                                            Done / Total
                                        </td>
                                        {Object.entries(data_lm[lm.id] || {}).map(([bulan, items]) => {
                                            const done = items.filter(t => t.status_tugas === 1).length;
                                            const total = items.length;
                                            return (
                                                <td key={bulan} className="px-4 py-4 text-center border-r border-surface-100 dark:border-surface-700">
                                                    <div className="font-bold text-lg text-slate-800 dark:text-white mb-2">
                                                        <span className={done === total && total > 0 ? 'text-green-500' : ''}>{done}</span>
                                                        <span className="text-slate-400 mx-1">/</span>
                                                        <span className="text-slate-500">{total}</span>
                                                    </div>
                                                    <button 
                                                        onClick={() => openViewTasksModal(lm.id, bulan)}
                                                        className="px-3 py-1.5 text-xs font-semibold bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors shadow-sm"
                                                    >
                                                        Lihat Task
                                                    </button>
                                                </td>
                                            );
                                        })}
                                    </tr>
                                </tbody>
                            </table>
                        ) : (
                            <div className="p-8 text-center text-slate-500">
                                <p>Belum ada data task untuk Lead Measure ini.</p>
                            </div>
                        )}
                    </div>
                </div>
            ))}

            {/* Modal Tambah Progress WIG */}
            {isProgressModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                    <div className="bg-white dark:bg-surface-800 rounded-3xl w-full max-w-md shadow-2xl overflow-hidden flex flex-col">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-center bg-surface-50/50 dark:bg-surface-800/50">
                            <h2 className="text-lg font-bold text-slate-800 dark:text-white">Tambah Progress WIG</h2>
                            <button 
                                onClick={() => { setIsProgressModalOpen(false); progReset(); }}
                                className="w-8 h-8 flex items-center justify-center rounded-full bg-surface-100 text-surface-500 hover:bg-surface-200 dark:bg-surface-700 dark:text-surface-400 dark:hover:bg-surface-600 transition-colors"
                            >
                                <i className="ph ph-x"></i>
                            </button>
                        </div>
                        <div className="p-6">
                            <form onSubmit={submitProgress} className="space-y-4">
                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Progress WIG</label>
                                    <input
                                        type="number"
                                        value={progData.progress_wig}
                                        onChange={e => setProgData('progress_wig', e.target.value)}
                                        className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                        required
                                    />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Bulan</label>
                                    <select
                                        value={progData.bulan_wig}
                                        onChange={e => setProgData('bulan_wig', e.target.value)}
                                        className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                    >
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div className="px-6 py-4 border-t border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50 flex justify-end gap-3">
                            <button 
                                onClick={() => { setIsProgressModalOpen(false); progReset(); }}
                                className="px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 dark:bg-surface-700 dark:border-surface-600 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors"
                            >
                                Batal
                            </button>
                            <button 
                                onClick={submitProgress}
                                disabled={progProcessing}
                                className="px-6 py-2 text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 rounded-xl transition-colors disabled:opacity-50"
                            >
                                {progProcessing ? 'Menyimpan...' : 'Simpan'}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Modal Tambah Task Baru */}
            {isTaskModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                    <div className="bg-white dark:bg-surface-800 rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-center bg-surface-50/50 dark:bg-surface-800/50">
                            <h2 className="text-lg font-bold text-slate-800 dark:text-white flex items-center">
                                <i className="ph ph-list-plus text-brand-500 mr-2 text-xl"></i>
                                Tambah Task Baru
                            </h2>
                            <button 
                                onClick={() => { setIsTaskModalOpen(false); taskReset(); }}
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
                                onClick={() => { setIsTaskModalOpen(false); taskReset(); }}
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
            )}

            {/* Modal List Tasks (View Tasks per Bulan) */}
            {isViewTasksModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                    <div className="bg-white dark:bg-surface-800 rounded-3xl w-full max-w-3xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-center bg-surface-50/50 dark:bg-surface-800/50">
                            <div>
                                <h2 className="text-lg font-bold text-slate-800 dark:text-white">Daftar Task</h2>
                                <p className="text-sm text-slate-500">Bulan: {activeMonth}</p>
                            </div>
                            <button 
                                onClick={() => setIsViewTasksModalOpen(false)}
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
                                onClick={() => setIsViewTasksModalOpen(false)}
                                className="px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 dark:bg-surface-700 dark:border-surface-600 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            )}
            
        </AuthenticatedLayout>
    );
}
