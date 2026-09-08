import React, { useState } from 'react';
import { Head, Link, useForm, router } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import Chart from 'react-apexcharts';
import { Target, Calendar } from 'lucide-react';
import HistoryModal from './Components/HistoryModal';
import HistoryEditModal from './Components/HistoryEditModal';
import TaskModal from './Components/TaskModal';
import ViewTasksModal from './Components/ViewTasksModal';
import WigProgressTerbaru from './WigProgressTerbaru';

export default function WigShow({ title, wig, departement, progressTerbaru, data_lm, chartWig, score: propScore }) {
    const [isHistoryModalOpen, setIsHistoryModalOpen] = useState(false);
    const [isHistoryEditModalOpen, setIsHistoryEditModalOpen] = useState(false);
    const [activeHistoryId, setActiveHistoryId] = useState(null);
    const [isTaskModalOpen, setIsTaskModalOpen] = useState(false);
    const [isViewTasksModalOpen, setIsViewTasksModalOpen] = useState(false);
    const [activeLmId, setActiveLmId] = useState(null);
    const [activeMonth, setActiveMonth] = useState(null);
    const [viewTasksData, setViewTasksData] = useState([]);
    const [isWigProgressEditModalOpen, setIsWigProgressEditModalOpen] = useState(false);

    const score = propScore !== undefined ? parseFloat(propScore) : (chartWig && chartWig.length > 0 ? parseFloat(chartWig[chartWig.length - 1]?.progress || 0) : 0);

    const formatDate = (dateString) => {
        if (!dateString) return '-';
        return new Date(dateString).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    };
    const gaugeOptions = {
        chart: { type: 'radialBar', sparkline: { enabled: true } },
        plotOptions: {
            radialBar: {
                startAngle: -90, endAngle: 90,
                track: { background: "rgba(255, 255, 255, 0.2)", strokeWidth: '97%' },
                dataLabels: {
                    name: { show: false },
                    value: { offsetY: -2, fontSize: '32px', fontWeight: 'bold', color: '#fff', formatter: function (val) { return val.toFixed(1) + "%" } }
                }
            }
        },
        fill: { colors: ['#ffffff'] },
        stroke: { lineCap: 'round' }
    };

    const { data: histData, setData: setHistData, post: postHist, processing: histProcessing, reset: histReset, errors: histErrors } = useForm({
        wig_id: wig.id,
        riwayat_wig: '',
        realisasi: '',
        tanggal: new Date().toISOString().split('T')[0],
        lampiran: null
    });

    const { data: editHistData, setData: setEditHistData, post: postEditHist, processing: editHistProcessing, reset: editHistReset, clearErrors: clearEditHistErrors } = useForm({
        _method: 'put',
        riwayat_wig: '',
        realisasi: '',
        tanggal: '',
        lampiran: null
    });

    const { data: taskData, setData: setTaskData, post: postTask, processing: taskProcessing, reset: taskReset, errors: taskErrors } = useForm({
        lm_id: '',
        nama_tugas: '',
        deskripsi: '',
        jumlah_realisasi: '',
        tanggal_realisasi: '',
        status_tugas: '0'
    });

    const submitHistory = (e) => {
        e.preventDefault();
        postHist(`/wig/${wig.id}/history`, {
            forceFormData: true,
            onSuccess: () => {
                setIsHistoryModalOpen(false);
                histReset();
            }
        });
    };

    const openHistoryEditModal = (history) => {
        setActiveHistoryId(history.id);
        setEditHistData({
            _method: 'put',
            riwayat_wig: history.riwayat_wig || '',
            realisasi: history.realisasi || '',
            tanggal: history.tanggal ? history.tanggal.split('T')[0] : '',
            lampiran: null
        });
        setIsHistoryEditModalOpen(true);
    };

    const submitHistoryEdit = (e) => {
        e.preventDefault();
        postEditHist(`/wig/${wig.id}/history/${activeHistoryId}`, {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                setIsHistoryEditModalOpen(false);
                editHistReset();
                setActiveHistoryId(null);
            }
        });
    };

    const handleDeleteHistory = (history) => {
        if (confirm('Apakah Anda yakin ingin menghapus riwayat ini?')) {
            router.delete(`/wig/${wig.id}/history/${history.id}`, {
                preserveScroll: true
            });
        }
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
        const progressData = chartDataArray.map(item => parseFloat(item.progress || 0));
        const monthlyData = chartDataArray.map(item => parseFloat(item.realisasi_bulanan ?? item.monthly ?? 0));
        const bulanData = chartDataArray.map(item => item.bulan);

        return {
            series: [
                {
                    name: 'Progress Akumulatif',
                    data: progressData
                },
                {
                    name: 'Realisasi Bulanan (Bayangan)',
                    data: monthlyData
                }
            ],
            options: {
                chart: {
                    type: 'line',
                    toolbar: { show: true },
                    fontFamily: 'Inter, sans-serif',
                },
                // Konfigurasi stroke (garis): Seri 1 solid tebal, Seri 2 putus-putus/bayangan
                stroke: {
                    curve: 'smooth',
                    width: [3.5, 2.5],
                    dashArray: [0, 6]
                },
                // Titik koordinat (marker/dots)
                markers: {
                    size: [5, 4],
                    colors: ['#2563eb', '#94a3b8'],
                    strokeColors: '#ffffff',
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                colors: ['#2563eb', '#94a3b8'],
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [0], // Tampilkan badge nilai hanya pada garis akumulatif agar grafik tidak bertumpuk
                    offsetY: -8,
                    style: {
                        fontSize: '11px',
                        fontFamily: 'Inter, sans-serif',
                        fontWeight: 600,
                        colors: ['#1e293b'],
                    },
                    background: {
                        enabled: true,
                        foreColor: '#fff',
                        borderRadius: 4,
                        padding: 7,
                        opacity: 0.9,
                        borderWidth: 1,
                        borderColor: '#cbd5e1',
                    }
                },
                xaxis: {
                    categories: bulanData,
                    axisBorder: { show: true },
                    axisTicks: { show: true },
                    labels: { style: { colors: '#64748b' } },
                },
                yaxis: {
                    labels: { style: { colors: '#64748b' } },
                    title: { text: 'Nilai Progress', style: { color: '#64748b', fontWeight: 600 } },
                },
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '12px',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: 500,
                    offsetY: 8,
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 12,
                    },
                    itemMargin: {
                        horizontal: 16,
                        vertical: 8
                    }
                },
                grid: {
                    borderColor: '#e9ecef',
                    strokeDashArray: 4,
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 10,
                    }
                },
                tooltip: {
                    theme: 'dark',
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: (val) => `${val}`,
                    }
                }
            }
        };
    };

    const chartConfig = getChartOptions();

    return (
        <AuthenticatedLayout>
            <Head title={title || "Detail WIG"} />

            <div className="mb-6 flex justify-between items-center">
                <Link
                    href={departement ? `/departement/${departement.id}` : '/wig'}
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-arrow-left mr-2"></i>
                    Kembali
                </Link>
                <Link
                    href={`/wig/${wig.id}/edit`}
                    className="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 hover:bg-surface-50 dark:hover:bg-surface-700 text-surface-700 dark:text-surface-300 rounded-xl transition-all shadow-sm"
                >
                    <i className="ph ph-pencil-simple mr-1"></i> Edit
                </Link>
            </div>

            <div className="bg-gradient-to-br from-brand-500 to-teal-700 rounded-2xl shadow-xl overflow-hidden mb-8 text-white relative">
                <div className="absolute top-0 right-0 p-8 opacity-10">
                    <Target className="w-48 h-48" />
                </div>
                <div className="p-8 relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div className="flex-1">
                        <span className="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider mb-4 inline-block">
                            {departement?.nama_dept || 'Department'}
                        </span>
                        <h1 className="text-3xl font-bold mb-2">{wig.judul_wig}</h1>
                        <p className="text-teal-100 max-w-2xl">{wig.deskripsi_wig}</p>

                        <div className="flex flex-wrap gap-6 mt-6">
                            <div className="flex items-center gap-2 text-teal-100">
                                <Calendar className="w-5 h-5" />
                                <div className="bg-slate-700 text-white border border-200 rounded-md p-1 px-4">
                                    {formatDate(wig.tanggal_mulai_wig)}
                                </div>
                                -
                                <div className="bg-slate-700 text-white border border-200 rounded-md p-1 px-4">
                                    {formatDate(wig.tanggal_berakhir_wig)}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl min-w-[550px] text-center">
                        <div className="text-teal-100 text-sm font-medium mb-4">Overall Progress</div>
                        <div className="flex justify-center -mb-8">
                            <Chart options={gaugeOptions} series={[score]} type="radialBar" height={200} />
                        </div>

                        <div className="mt-2 text-gray-900 text-lg  font-bold">
                            <div className="border border-gray-300 rounded-xl bg-brand-100 p-2">KPI Weight: {wig.bobot_kpi || 0}%</div>

                        </div>
                    </div>
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
                                    href={`/wig/${wig.id}/history`}
                                    className="px-3 py-1.5 text-xs font-semibold bg-surface-100 text-surface-600 hover:bg-surface-200 dark:bg-surface-700 dark:text-surface-300 dark:hover:bg-surface-600 rounded-lg transition-colors inline-flex items-center"
                                >
                                    <i className="ph ph-list-dashes mr-1 text-base"></i> Lihat riwayat wig selengkapnya
                                </Link>
                                <button
                                    onClick={() => setIsHistoryModalOpen(true)}
                                    className="px-3 py-1.5 text-xs font-semibold bg-brand-50 text-brand-600 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 rounded-lg transition-colors inline-flex items-center"
                                >
                                    <i className="ph ph-plus-circle mr-1 text-base"></i> Tambah Riwayat
                                </button>
                            </div>
                        </div>
                        <div className="p-4">
                            {chartConfig.series[0].data.length > 0 ? (
                                <Chart
                                    options={chartConfig.options}
                                    series={chartConfig.series}
                                    type="line"
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

                {/* <div className="lg:col-span-1">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full flex flex-col">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                            <h3 className="font-bold text-slate-800 dark:text-white flex items-center">
                                <i className="ph ph-clock-counter-clockwise text-brand-500 mr-2 text-xl"></i>
                                Progress WIG Terbaru
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
                                                        {new Date(progress.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                                                    </span>
                                                    <h6 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug">{progress.riwayat_wig}</h6>
                                                </div>
                                                <div className="text-right whitespace-nowrap flex flex-col justify-center">
                                                    <span className={`block text-xl font-bold leading-none ${parseFloat(progress.realisasi) >= 0 ? 'text-green-500' : 'text-red-500'}`}>
                                                        {parseFloat(progress.realisasi) > 0 ? '+' : ''}{progress.realisasi}
                                                    </span>
                                                    <span className="text-[10px] text-slate-500 uppercase tracking-wider font-semibold mt-1">Delta</span>
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
                </div> */}

                <div className="lg:col-span-1">
                    <WigProgressTerbaru
                        progressTerbaru={progressTerbaru}
                        formatDate={formatDate}
                        onEditClick={openHistoryEditModal}
                        onDeleteClick={handleDeleteHistory}
                    />
                </div>
            </div>

            <div className="space-y-20 rounded-t-md border-t-2 border-slate-500 hover:bg-gray-200 transition-colors duration-200 ease-in-out p-6">                <div className="mb-6 mt-6 flex justify-between items-center">
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
                    <div key={lm.id} className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-300 dark:border-surface-700 shadow-md overflow-hidden mb-6">
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

                {/* Modal Tambah Riwayat WIG */}
                <HistoryModal
                    isOpen={isHistoryModalOpen}
                    onClose={() => { setIsHistoryModalOpen(false); histReset(); }}
                    histData={histData}
                    setHistData={setHistData}
                    submitHistory={submitHistory}
                    histProcessing={histProcessing}
                />

                <HistoryEditModal
                    isOpen={isHistoryEditModalOpen}
                    onClose={() => { setIsHistoryEditModalOpen(false); editHistReset(); setActiveHistoryId(null); }}
                    histData={editHistData}
                    setHistData={setEditHistData}
                    submitHistory={submitHistoryEdit}
                    histProcessing={editHistProcessing}
                />

                {/* Modal Tambah Task Baru */}
                <TaskModal
                    isOpen={isTaskModalOpen}
                    onClose={() => { setIsTaskModalOpen(false); taskReset(); }}
                    taskData={taskData}
                    setTaskData={setTaskData}
                    submitTask={submitTask}
                    taskErrors={taskErrors}
                    taskProcessing={taskProcessing}
                />

                {/* Modal List Tasks (View Tasks per Bulan) */}
                <ViewTasksModal
                    isOpen={isViewTasksModalOpen}
                    onClose={() => setIsViewTasksModalOpen(false)}
                    activeMonth={activeMonth}
                    viewTasksData={viewTasksData}
                    toggleTaskStatus={toggleTaskStatus}
                />
            </div>


        </AuthenticatedLayout>
    );
}
