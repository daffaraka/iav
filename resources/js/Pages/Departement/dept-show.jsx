import React, { useState } from 'react';
import { Head, Link, useForm, router } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import Chart from 'react-apexcharts';

export default function DepartementShow({ title, departement, wig_total, wig_aktif, wig_selesai, wig_tidak_aktif, chartPerWig }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    
    const { data, setData, post, processing, errors, reset } = useForm({
        departement_id: departement.id,
        nama_wig: '',
        deskripsi_wig: '',
        tanggal_mulai_wig: '',
        tanggal_berakhir_wig: '',
        from_x: '',
        to_y: '',
        satuan: '%'
    });

    const submitWig = (e) => {
        e.preventDefault();
        post('/wig/storeByDept', {
            onSuccess: () => {
                setIsModalOpen(false);
                reset();
            }
        });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah anda yakin data WIG akan dihapus permanen?')) {
            router.delete(`/wig/${id}`);
        }
    };

    // Prepare chart configs
    const getChartOptions = (chartData) => {
        if (!chartData) return { options: {}, series: [] };
        
        const progressData = chartData.map(item => item.progress);
        const bulanData = chartData.map(item => item.bulan);

        return {
            series: [{
                name: 'Progress',
                data: progressData
            }],
            options: {
                chart: {
                    type: 'bar',
                    toolbar: { show: false },
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
                    labels: { style: { colors: '#64748b' } }
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

    return (
        <AuthenticatedLayout>
            <Head title={title || "Detail Departemen"} />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white uppercase">{title}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Monitoring Wildly Important Goals (WIG)</p>
                </div>
                <div className="flex gap-2">
                    <button 
                        onClick={() => setIsModalOpen(true)}
                        className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm shadow-brand-500/20"
                    >
                        <i className="ph ph-plus mr-2 text-lg"></i>
                        Tambah WIG Baru
                    </button>
                    <Link 
                        href="/departement" 
                        className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                    >
                        <i className="ph ph-arrow-left mr-2"></i>
                        Kembali
                    </Link>
                </div>
            </div>

            {/* Summary Stats */}
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 p-5 shadow-soft flex items-center relative overflow-hidden group">
                    <div className="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-slate-100 to-transparent dark:from-slate-700/30 opacity-50"></div>
                    <div className="flex-1 z-10">
                        <p className="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Total WIG</p>
                        <h3 className="text-3xl font-bold text-slate-800 dark:text-white">{wig_total}</h3>
                    </div>
                    <div className="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 z-10 group-hover:scale-110 transition-transform">
                        <i className="ph ph-target text-2xl"></i>
                    </div>
                </div>

                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-brand-100 dark:border-brand-900/50 p-5 shadow-soft flex items-center relative overflow-hidden group">
                    <div className="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-brand-50 to-transparent dark:from-brand-900/20 opacity-50"></div>
                    <div className="flex-1 z-10">
                        <p className="text-xs font-semibold text-brand-600 dark:text-brand-400 uppercase tracking-wider mb-1">Aktif</p>
                        <h3 className="text-3xl font-bold text-brand-600 dark:text-brand-400">{wig_aktif}</h3>
                    </div>
                    <div className="w-12 h-12 rounded-xl bg-brand-50 dark:bg-brand-900/30 flex items-center justify-center text-brand-600 dark:text-brand-400 z-10 group-hover:scale-110 transition-transform">
                        <i className="ph ph-trend-up text-2xl"></i>
                    </div>
                </div>

                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-green-100 dark:border-green-900/50 p-5 shadow-soft flex items-center relative overflow-hidden group">
                    <div className="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-green-50 to-transparent dark:from-green-900/20 opacity-50"></div>
                    <div className="flex-1 z-10">
                        <p className="text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wider mb-1">Selesai</p>
                        <h3 className="text-3xl font-bold text-green-600 dark:text-green-400">{wig_selesai}</h3>
                    </div>
                    <div className="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 z-10 group-hover:scale-110 transition-transform">
                        <i className="ph ph-check-circle text-2xl"></i>
                    </div>
                </div>

                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-red-100 dark:border-red-900/50 p-5 shadow-soft flex items-center relative overflow-hidden group">
                    <div className="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-red-50 to-transparent dark:from-red-900/20 opacity-50"></div>
                    <div className="flex-1 z-10">
                        <p className="text-xs font-semibold text-red-600 dark:text-red-400 uppercase tracking-wider mb-1">Tidak Aktif</p>
                        <h3 className="text-3xl font-bold text-red-600 dark:text-red-400">{wig_tidak_aktif}</h3>
                    </div>
                    <div className="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 z-10 group-hover:scale-110 transition-transform">
                        <i className="ph ph-x-circle text-2xl"></i>
                    </div>
                </div>
            </div>

            {/* WIG List */}
            <div className="space-y-6">
                {departement.wigs && departement.wigs.map((wig, index) => {
                    const chartConfig = getChartOptions(chartPerWig && chartPerWig[index] ? chartPerWig[index] : []);
                    return (
                        <div key={wig.id} className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div className="lg:col-span-2">
                                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full">
                                    <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-start bg-surface-50/50 dark:bg-surface-800/50">
                                        <div>
                                            <h3 className="font-bold text-brand-600 dark:text-brand-400 text-lg mb-1">{wig.judul_wig || wig.nama_wig}</h3>
                                            <p className="text-sm text-slate-600 dark:text-slate-300">{wig.deskripsi_wig}</p>
                                        </div>
                                        <div className="ml-4 flex gap-1">
                                            <Link 
                                                href={`/departement/${departement.id}/wig/${wig.id}/edit`}
                                                className="p-2 text-slate-500 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors"
                                                title="Edit WIG"
                                            >
                                                <i className="ph ph-pencil-simple text-lg"></i>
                                            </Link>
                                            <Link 
                                                href={`/departement/${departement.id}/wig/${wig.id}`}
                                                className="p-2 text-slate-500 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-500/10 rounded-lg transition-colors"
                                                title="Lihat Lead Measures"
                                            >
                                                <i className="ph ph-eye text-lg"></i>
                                            </Link>
                                            <button 
                                                onClick={() => handleDelete(wig.id)}
                                                className="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors"
                                                title="Hapus WIG"
                                            >
                                                <i className="ph ph-trash text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div className="p-4">
                                        {chartConfig.series[0].data.length > 0 ? (
                                            <Chart 
                                                options={chartConfig.options} 
                                                series={chartConfig.series} 
                                                type="bar" 
                                                height={300} 
                                            />
                                        ) : (
                                            <div className="h-[300px] flex items-center justify-center text-slate-400 bg-surface-50 dark:bg-surface-900/30 rounded-xl border border-dashed border-surface-200 dark:border-surface-700">
                                                <p>Belum ada data progress untuk chart ini</p>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                            <div className="lg:col-span-1">
                                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full">
                                    <div className="px-5 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                                        <h4 className="font-semibold text-slate-800 dark:text-white flex items-center">
                                            <i className="ph ph-info mr-2 text-brand-500"></i> Detail WIG
                                        </h4>
                                    </div>
                                    <div className="p-5 space-y-4">
                                        <div>
                                            <span className="block text-xs font-semibold text-slate-500 uppercase mb-1">Periode</span>
                                            <span className="text-sm font-medium text-slate-800 dark:text-slate-200 bg-surface-100 dark:bg-surface-700 px-3 py-1 rounded-lg">
                                                {wig.tanggal_mulai_wig} <i className="ph ph-arrow-right mx-1 inline-block align-middle text-slate-400"></i> {wig.tanggal_berakhir_wig}
                                            </span>
                                        </div>
                                        <div className="grid grid-cols-2 gap-4">
                                            <div>
                                                <span className="block text-xs font-semibold text-slate-500 uppercase mb-1">Target X</span>
                                                <span className="text-lg font-bold text-brand-600 dark:text-brand-400">{wig.from_x || 0}</span>
                                            </div>
                                            <div>
                                                <span className="block text-xs font-semibold text-slate-500 uppercase mb-1">Target Y</span>
                                                <span className="text-lg font-bold text-brand-600 dark:text-brand-400">{wig.to_y || 0} <span className="text-xs font-normal text-slate-500">{wig.satuan}</span></span>
                                            </div>
                                        </div>
                                        <div className="pt-4 border-t border-surface-100 dark:border-surface-700">
                                            <span className="block text-xs font-semibold text-slate-500 uppercase mb-2">Deskripsi Lengkap</span>
                                            <p className="text-sm text-slate-700 dark:text-slate-300 leading-relaxed bg-surface-50 dark:bg-surface-900/50 p-3 rounded-xl border border-surface-100 dark:border-surface-700">
                                                {wig.deskripsi_wig || 'Tidak ada deskripsi.'}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    );
                })}

                {departement.wigs && departement.wigs.length === 0 && (
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 p-10 text-center shadow-soft flex flex-col items-center justify-center">
                        <div className="w-20 h-20 bg-surface-100 dark:bg-surface-700 rounded-full flex items-center justify-center text-slate-400 mb-4">
                            <i className="ph ph-target text-4xl"></i>
                        </div>
                        <h3 className="text-lg font-bold text-slate-800 dark:text-white mb-2">Belum ada WIG</h3>
                        <p className="text-slate-500 dark:text-slate-400 mb-6 max-w-md mx-auto">Departemen ini belum memiliki Wildly Important Goals. Silakan tambah WIG baru untuk mulai melacak progress.</p>
                        <button 
                            onClick={() => setIsModalOpen(true)}
                            className="inline-flex items-center justify-center px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors"
                        >
                            <i className="ph ph-plus mr-2"></i>
                            Tambah WIG Pertama
                        </button>
                    </div>
                )}
            </div>

            {/* Modal Tambah WIG */}
            {isModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                    <div className="bg-white dark:bg-surface-800 rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-center bg-surface-50/50 dark:bg-surface-800/50">
                            <h2 className="text-lg font-bold text-slate-800 dark:text-white flex items-center">
                                <i className="ph ph-target text-brand-500 mr-2 text-xl"></i>
                                Tambah WIG Baru
                            </h2>
                            <button 
                                onClick={() => { setIsModalOpen(false); reset(); }}
                                className="w-8 h-8 flex items-center justify-center rounded-full bg-surface-100 text-surface-500 hover:bg-surface-200 dark:bg-surface-700 dark:text-surface-400 dark:hover:bg-surface-600 transition-colors"
                            >
                                <i className="ph ph-x"></i>
                            </button>
                        </div>
                        <div className="p-6 overflow-y-auto custom-scrollbar flex-1">
                            <form id="formWig" onSubmit={submitWig} className="space-y-5">
                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Nama WIG <span className="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        value={data.nama_wig}
                                        onChange={e => setData('nama_wig', e.target.value)}
                                        className={`w-full px-4 py-2.5 rounded-xl border ${errors.nama_wig ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all`}
                                        required
                                    />
                                    {errors.nama_wig && <p className="mt-1 text-sm text-red-500">{errors.nama_wig}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Deskripsi WIG <span className="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        value={data.deskripsi_wig}
                                        onChange={e => setData('deskripsi_wig', e.target.value)}
                                        rows="3"
                                        className={`w-full px-4 py-2.5 rounded-xl border ${errors.deskripsi_wig ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all resize-none`}
                                        required
                                    ></textarea>
                                    {errors.deskripsi_wig && <p className="mt-1 text-sm text-red-500">{errors.deskripsi_wig}</p>}
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                            Tanggal Mulai <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="date"
                                            value={data.tanggal_mulai_wig}
                                            onChange={e => setData('tanggal_mulai_wig', e.target.value)}
                                            className={`w-full px-4 py-2.5 rounded-xl border ${errors.tanggal_mulai_wig ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all`}
                                            required
                                        />
                                        {errors.tanggal_mulai_wig && <p className="mt-1 text-sm text-red-500">{errors.tanggal_mulai_wig}</p>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                            Tanggal Berakhir <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="date"
                                            value={data.tanggal_berakhir_wig}
                                            onChange={e => setData('tanggal_berakhir_wig', e.target.value)}
                                            className={`w-full px-4 py-2.5 rounded-xl border ${errors.tanggal_berakhir_wig ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all`}
                                            required
                                        />
                                        {errors.tanggal_berakhir_wig && <p className="mt-1 text-sm text-red-500">{errors.tanggal_berakhir_wig}</p>}
                                    </div>
                                </div>

                                <div className="grid grid-cols-3 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">From X</label>
                                        <input
                                            type="number"
                                            value={data.from_x}
                                            onChange={e => setData('from_x', e.target.value)}
                                            className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all"
                                        />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">To Y</label>
                                        <input
                                            type="number"
                                            value={data.to_y}
                                            onChange={e => setData('to_y', e.target.value)}
                                            className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all"
                                        />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Satuan</label>
                                        <select
                                            value={data.satuan}
                                            onChange={e => setData('satuan', e.target.value)}
                                            className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all"
                                        >
                                            <option value="%">Persen (%)</option>
                                            <option value="Angka">Unit (Angka)</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div className="px-6 py-4 border-t border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50 flex justify-end gap-3">
                            <button 
                                type="button"
                                onClick={() => { setIsModalOpen(false); reset(); }}
                                className="px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 dark:bg-surface-700 dark:border-surface-600 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors shadow-sm"
                            >
                                Batal
                            </button>
                            <button 
                                type="button"
                                onClick={submitWig}
                                disabled={processing}
                                className="px-6 py-2 text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 rounded-xl transition-colors shadow-sm disabled:opacity-50"
                            >
                                {processing ? 'Menyimpan...' : 'Simpan WIG'}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AuthenticatedLayout>
    );
}
