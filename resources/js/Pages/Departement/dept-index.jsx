import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function DepartementIndex({ departement }) {
    return (
        <AuthenticatedLayout>
            <Head title="Departemen & WIG" />

            <div className="mb-8">
                <h1 className="text-2xl font-bold text-slate-800 dark:text-white">Departemen & WIG</h1>
                <p className="text-sm text-slate-500 dark:text-slate-400">Pilih departemen untuk melihat dan mengelola Wildly Important Goals (WIG)</p>
            </div>

            {/* Dynamic Departments */}
            <div className="mb-10">
                <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                    <i className="ph ph-buildings text-brand-500 mr-2"></i>
                    Departemen Tersedia
                </h2>
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    {departement && departement.map(dept => (
                        <Link 
                            key={dept.id} 
                            href={`/departement/${dept.id}`}
                            className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 p-5 shadow-soft hover:shadow-hover hover:border-brand-200 dark:hover:border-brand-800 transition-all group flex flex-col items-center text-center relative overflow-hidden"
                        >
                            <div className="absolute -right-4 -top-4 w-16 h-16 bg-brand-500/10 rounded-full blur-xl group-hover:bg-brand-500/20 transition-all"></div>
                            
                            <div className="w-14 h-14 bg-surface-100 dark:bg-surface-700 text-brand-600 dark:text-brand-400 rounded-xl flex items-center justify-center text-2xl mb-3 group-hover:scale-110 group-hover:bg-brand-50 dark:group-hover:bg-brand-500/20 transition-all">
                                <i className="ph ph-users-three"></i>
                            </div>
                            
                            <h3 className="font-bold text-slate-800 dark:text-white mb-1 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                                {dept.nama_dept}
                            </h3>
                            
                            <div className="mt-auto pt-4 flex items-center text-xs font-semibold text-slate-500 dark:text-slate-400">
                                <span className="flex items-center bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 px-2 py-1 rounded-md mr-1">
                                    <i className="ph ph-target mr-1"></i> {dept.wigs ? dept.wigs.length : 0}
                                </span>
                                WIG Aktif
                            </div>
                        </Link>
                    ))}
                </div>
            </div>

            {/* Static Highlight Cards (Recreated from Blade) */}
            <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                <i className="ph ph-chart-line-up text-brand-500 mr-2"></i>
                Highlight Progress Departemen
            </h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {/* IT Dept */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden">
                    <div className="px-5 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                        <h3 className="font-bold text-slate-800 dark:text-white">Departemen IT</h3>
                    </div>
                    <div className="p-5 space-y-4">
                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-green-500 mb-0.5 block">WIG Tercapai</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Implementasi Sistem Informasi Terintegrasi</h4>
                                </div>
                                <span className="text-sm font-bold text-green-500">100%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-green-500 h-1.5 rounded-full" style={{ width: '100%' }}></div>
                            </div>
                        </div>

                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-green-500 mb-0.5 block">WIG Tercapai</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Upgrade Infrastruktur Jaringan</h4>
                                </div>
                                <span className="text-sm font-bold text-green-500">85%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-green-500 h-1.5 rounded-full" style={{ width: '85%' }}></div>
                            </div>
                        </div>

                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-amber-500 mb-0.5 block">WIG Dalam Proses</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Digitalisasi Proses Administrasi</h4>
                                </div>
                                <span className="text-sm font-bold text-amber-500">60%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-amber-500 h-1.5 rounded-full" style={{ width: '60%' }}></div>
                            </div>
                        </div>

                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-amber-500 mb-0.5 block">WIG Dalam Proses</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Pelatihan Digital Literacy Staff</h4>
                                </div>
                                <span className="text-sm font-bold text-amber-500">45%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-amber-500 h-1.5 rounded-full" style={{ width: '45%' }}></div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* SDM Dept */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden">
                    <div className="px-5 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                        <h3 className="font-bold text-slate-800 dark:text-white">Departemen SDM</h3>
                    </div>
                    <div className="p-5 space-y-4">
                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-green-500 mb-0.5 block">WIG Tercapai</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Program Pelatihan Guru Berkelanjutan</h4>
                                </div>
                                <span className="text-sm font-bold text-green-500">95%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-green-500 h-1.5 rounded-full" style={{ width: '95%' }}></div>
                            </div>
                        </div>

                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-green-500 mb-0.5 block">WIG Tercapai</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Sistem Evaluasi Kinerja Digital</h4>
                                </div>
                                <span className="text-sm font-bold text-green-500">80%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-green-500 h-1.5 rounded-full" style={{ width: '80%' }}></div>
                            </div>
                        </div>

                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-amber-500 mb-0.5 block">WIG Dalam Proses</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Employee Engagement Program</h4>
                                </div>
                                <span className="text-sm font-bold text-amber-500">65%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-amber-500 h-1.5 rounded-full" style={{ width: '65%' }}></div>
                            </div>
                        </div>

                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-amber-500 mb-0.5 block">WIG Dalam Proses</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Talent Management System</h4>
                                </div>
                                <span className="text-sm font-bold text-amber-500">40%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-amber-500 h-1.5 rounded-full" style={{ width: '40%' }}></div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* RND Dept */}
                <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden">
                    <div className="px-5 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                        <h3 className="font-bold text-slate-800 dark:text-white">Departemen RND</h3>
                    </div>
                    <div className="p-5 space-y-4">
                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-green-500 mb-0.5 block">WIG Tercapai</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Kurikulum Merdeka Implementation</h4>
                                </div>
                                <span className="text-sm font-bold text-green-500">100%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-green-500 h-1.5 rounded-full" style={{ width: '100%' }}></div>
                            </div>
                        </div>

                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-green-500 mb-0.5 block">WIG Tercapai</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Modul Pembelajaran Digital</h4>
                                </div>
                                <span className="text-sm font-bold text-green-500">85%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-green-500 h-1.5 rounded-full" style={{ width: '85%' }}></div>
                            </div>
                        </div>

                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-amber-500 mb-0.5 block">WIG Dalam Proses</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Assessment System Upgrade</h4>
                                </div>
                                <span className="text-sm font-bold text-amber-500">75%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-amber-500 h-1.5 rounded-full" style={{ width: '75%' }}></div>
                            </div>
                        </div>

                        <div className="group">
                            <div className="flex justify-between items-end mb-1">
                                <div>
                                    <span className="text-[10px] font-bold uppercase tracking-wider text-amber-500 mb-0.5 block">WIG Dalam Proses</span>
                                    <h4 className="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-tight">Learning Analytics Platform</h4>
                                </div>
                                <span className="text-sm font-bold text-amber-500">50%</span>
                            </div>
                            <div className="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1.5 mb-1 overflow-hidden">
                                <div className="bg-amber-500 h-1.5 rounded-full" style={{ width: '50%' }}></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </AuthenticatedLayout>
    );
}
