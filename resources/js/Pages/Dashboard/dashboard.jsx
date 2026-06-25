import React, { useEffect, useState } from 'react';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import Chart from 'react-apexcharts';

export default function Dashboard({ title, totalDepartemen, totalWig, totalLeadMeasure, totalTask, wigPerDepartment }) {
    
    // Prepare Data for Donut Chart
    const wigChartOptions = {
        series: Object.keys(wigPerDepartment || {}).length > 0 ? Object.values(wigPerDepartment).map(v => Number(v)) : [],
        options: {
            chart: {
                type: 'donut',
                fontFamily: 'Inter, sans-serif'
            },
            labels: Object.keys(wigPerDepartment),
            colors: [
                '#3b82f6', '#10b981', '#f59e0b', '#ef4444', 
                '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6', 
                '#f97316', '#6366f1', '#64748b', '#84cc16'
            ],
            stroke: {
                colors: ['transparent']
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: {
                                fontSize: '14px',
                                fontFamily: 'Inter, sans-serif',
                                color: '#64748b'
                            },
                            value: {
                                fontSize: '24px',
                                fontFamily: 'Inter, sans-serif',
                                fontWeight: 700,
                                color: '#1e293b'
                            },
                            total: {
                                show: true,
                                label: 'Total WIG',
                                color: '#64748b',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => {
                                        return a + b
                                    }, 0)
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'right',
                labels: {
                    colors: '#64748b'
                }
            },
            tooltip: {
                theme: 'light'
            }
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title={title || "Dashboard Master"} />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white uppercase">{title}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Ikhtisar data master sistem Anda.</p>
                </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {/* Departemen Card */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden group">
                    <div className="p-6">
                        <div className="flex justify-between items-start">
                            <div>
                                <p className="text-sm font-semibold text-slate-500 dark:text-slate-400 mb-1">Total Departemen</p>
                                <h3 className="text-3xl font-bold text-slate-800 dark:text-white">{totalDepartemen}</h3>
                            </div>
                            <div className="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform duration-300">
                                <i className="ph ph-buildings text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div className="h-1 w-full bg-blue-500/20">
                        <div className="h-full bg-blue-500 w-full rounded-r-full"></div>
                    </div>
                </div>

                {/* WIG Card */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden group">
                    <div className="p-6">
                        <div className="flex justify-between items-start">
                            <div>
                                <p className="text-sm font-semibold text-slate-500 dark:text-slate-400 mb-1">Total WIG</p>
                                <h3 className="text-3xl font-bold text-slate-800 dark:text-white">{totalWig}</h3>
                            </div>
                            <div className="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform duration-300">
                                <i className="ph ph-target text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div className="h-1 w-full bg-green-500/20">
                        <div className="h-full bg-green-500 w-full rounded-r-full"></div>
                    </div>
                </div>

                {/* Lead Measure Card */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden group">
                    <div className="p-6">
                        <div className="flex justify-between items-start">
                            <div>
                                <p className="text-sm font-semibold text-slate-500 dark:text-slate-400 mb-1">Total Lead Measure</p>
                                <h3 className="text-3xl font-bold text-slate-800 dark:text-white">{totalLeadMeasure}</h3>
                            </div>
                            <div className="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform duration-300">
                                <i className="ph ph-list-dashes text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div className="h-1 w-full bg-purple-500/20">
                        <div className="h-full bg-purple-500 w-full rounded-r-full"></div>
                    </div>
                </div>

                {/* Task Card */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden group">
                    <div className="p-6">
                        <div className="flex justify-between items-start">
                            <div>
                                <p className="text-sm font-semibold text-slate-500 dark:text-slate-400 mb-1">Total Task</p>
                                <h3 className="text-3xl font-bold text-slate-800 dark:text-white">{totalTask}</h3>
                            </div>
                            <div className="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-500/10 flex items-center justify-center text-orange-600 dark:text-orange-400 group-hover:scale-110 transition-transform duration-300">
                                <i className="ph ph-check-square-offset text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div className="h-1 w-full bg-orange-500/20">
                        <div className="h-full bg-orange-500 w-full rounded-r-full"></div>
                    </div>
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full flex flex-col">
                    <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 flex justify-between items-center bg-surface-50/50 dark:bg-surface-800/50">
                        <h3 className="font-bold text-slate-800 dark:text-white flex items-center">
                            <i className="ph ph-chart-pie-slice text-brand-500 mr-2 text-xl"></i>
                            WIG per Departemen
                        </h3>
                    </div>
                    <div className="p-6 flex-1 flex items-center justify-center">
                        {Object.keys(wigPerDepartment).length > 0 ? (
                            <div className="w-full">
                                <Chart 
                                    options={wigChartOptions.options} 
                                    series={wigChartOptions.series} 
                                    type="donut" 
                                    height={350} 
                                />
                            </div>
                        ) : (
                            <div className="text-center text-slate-400">
                                <i className="ph ph-chart-pie-slice text-4xl mb-2"></i>
                                <p>Belum ada data WIG Departemen</p>
                            </div>
                        )}
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
