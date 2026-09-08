import React from 'react';
import { Head, router } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import Chart from 'react-apexcharts';

export default function Analytics({ startDate, endDate, habitsCount, valuesCount, topStars, departemen }) {
    const handleDateChange = (type, value) => {
        router.get('/avicenna-way/analytics', {
            start_date: type === 'start' ? value : startDate,
            end_date: type === 'end' ? value : endDate,
        }, { preserveState: true });
    };

    // Helper for donut charts
    const createDonutOptions = (dataObj) => {
        const labels = Object.keys(dataObj);
        const series = Object.values(dataObj);
        return {
            series,
            options: {
                chart: { type: 'donut', fontFamily: 'Inter, sans-serif' },
                labels,
                colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6'],
                stroke: { colors: ['transparent'] },
                legend: { position: 'bottom' },
                dataLabels: { enabled: false },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: { show: true, name: { fontSize: '12px' }, value: { fontSize: '20px', fontWeight: 700 } }
                        }
                    }
                }
            }
        };
    };

    const habitsChart = createDonutOptions(habitsCount);
    const valuesChart = createDonutOptions(valuesCount);

    return (
        <AuthenticatedLayout>
            <Head title="Analitik Avicenna Way" />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white uppercase">Analitik Avicenna Way</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Departemen {departemen}</p>
                </div>
                <div className="flex items-center gap-3">
                    <a href="/avicenna-way" className="px-4 py-2 bg-slate-200 dark:bg-surface-700 text-slate-700 dark:text-slate-300 rounded-lg text-sm font-medium hover:bg-slate-300 dark:hover:bg-surface-600 transition-colors">
                        Kembali ke Form
                    </a>
                    <input 
                        type="date" 
                        value={startDate} 
                        onChange={(e) => handleDateChange('start', e.target.value)}
                        className="rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-surface-800 dark:border-surface-600 dark:text-white"
                        title="Start Date"
                    />
                    <span className="text-slate-500">s/d</span>
                    <input 
                        type="date" 
                        value={endDate} 
                        onChange={(e) => handleDateChange('end', e.target.value)}
                        className="rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-surface-800 dark:border-surface-600 dark:text-white"
                        title="End Date"
                    />
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {/* Nilai Avicenna Way Chart */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full flex flex-col">
                    <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                        <h3 className="font-bold text-slate-800 dark:text-white flex items-center">
                            <i className="ph ph-heart text-brand-500 mr-2 text-xl"></i>
                            Implementasi Nilai Avicenna
                        </h3>
                    </div>
                    <div className="p-6 flex-1 flex items-center justify-center">
                        {Object.keys(valuesCount).length > 0 ? (
                            <Chart options={valuesChart.options} series={valuesChart.series} type="donut" height={320} />
                        ) : (
                            <div className="text-center text-slate-400 py-10">Belum ada data</div>
                        )}
                    </div>
                </div>

                {/* 7 Habits Chart */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full flex flex-col">
                    <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                        <h3 className="font-bold text-slate-800 dark:text-white flex items-center">
                            <i className="ph ph-list-numbers text-green-500 mr-2 text-xl"></i>
                            Implementasi 7 Habits
                        </h3>
                    </div>
                    <div className="p-6 flex-1 flex items-center justify-center">
                        {Object.keys(habitsCount).length > 0 ? (
                            <Chart options={habitsChart.options} series={habitsChart.series} type="donut" height={320} />
                        ) : (
                            <div className="text-center text-slate-400 py-10">Belum ada data</div>
                        )}
                    </div>
                </div>

                {/* Top Stars / Favorites */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full flex flex-col">
                    <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                        <h3 className="font-bold text-slate-800 dark:text-white flex items-center">
                            <i className="ph ph-star text-amber-500 mr-2 text-xl"></i>
                            Top Favorites (Bintang)
                        </h3>
                    </div>
                    <div className="p-6 flex-1">
                        {Object.keys(topStars).length > 0 ? (
                            <div className="space-y-4">
                                {Object.entries(topStars).map(([name, count], index) => (
                                    <div key={name} className="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-surface-700/50 border border-surface-100 dark:border-surface-600">
                                        <div className="flex items-center gap-3">
                                            <div className="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">
                                                #{index + 1}
                                            </div>
                                            <span className="font-medium text-slate-800 dark:text-white">{name}</span>
                                        </div>
                                        <div className="flex items-center gap-1 text-amber-500 font-bold">
                                            <i className="ph-fill ph-star"></i> {count}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="text-center text-slate-400 py-10 flex flex-col items-center">
                                <i className="ph ph-star text-4xl mb-2 opacity-50"></i>
                                Belum ada data
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
