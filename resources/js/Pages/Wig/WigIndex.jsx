import React from 'react';
import { usePage, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Target, Plus, Edit } from 'lucide-react';

export default function WigIndex({ wigs = { data: [] }, totalWigs = 0, activeWigs = 0, averageProgress = 0, filters }) {
    const { auth } = usePage().props;

    return (
        <AuthenticatedLayout user={auth?.user}>
            <div className="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                    <div>
                        <h1 className="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <Target className="w-8 h-8 text-brand-500" />
                            Wildly Important Goals
                        </h1>
                        <p className="text-slate-500 dark:text-slate-400 mt-1">Manage and track your WIGs.</p>
                    </div>
                    <Link
                        href={'/wig/create'}
                        className="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white rounded-xl transition-all shadow-lg shadow-brand-500/30"
                    >
                        <Plus className="w-5 h-5" />
                        <span>Create WIG</span>
                    </Link>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div className="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-300 dark:border-slate-700">
                        <div className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total WIGs</div>
                        <div className="text-3xl font-bold text-slate-900 dark:text-white">{totalWigs}</div>
                    </div>
                    <div className="bg-gradient-to-br from-blue-200 to-gray-300 dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-300 dark:border-slate-700">
                        <div className="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Active WIGs</div>
                        <div className="text-3xl font-bold text-slate-900 dark:text-white">{activeWigs}</div>
                    </div>
                    <div className="bg-gradient-to-br from-brand-500 to-teal-700 rounded-2xl shadow-sm p-6 text-white relative overflow-hidden">
                        <div className="absolute right-0 bottom-0 opacity-10">
                            <Target className="w-24 h-24 -mr-4 -mb-4" />
                        </div>
                        <div className="text-teal-100 text-sm font-medium mb-1 relative z-10">Average Progress</div>
                        <div className="text-3xl font-bold relative z-10">{averageProgress}%</div>
                    </div>
                </div>

                <div className="bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-2xl shadow-xl overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                                    <th className="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-300">WIG Title</th>
                                    <th className="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-300">Departement</th>
                                    <th className="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-300">KPI Weight</th>
                                    <th className="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-300">Status</th>
                                    <th className="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-200 dark:divide-slate-700 ">
                                {wigs.data.length > 0 ? (
                                    wigs.data.map(wig => (
                                        <tr key={wig.id} className="hover:bg-slate-400/50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer " onClick={() => router.get(`/wig/${wig.id}`)}>
                                            <td className="px-6 py-4">
                                                <div className="text-sm font-medium text-slate-900 dark:text-white">{wig.judul_wig}</div>
                                                <div className="text-xs text-slate-500 truncate max-w-xs">{wig.deskripsi_wig}</div>
                                            </td>
                                            <td className="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                                {wig.deptartement?.nama_dept || '-'}
                                            </td>
                                            <td className="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                                {wig.bobot_kpi}%
                                            </td>
                                            <td className="px-6 py-4">
                                                <span className={`px-2.5 py-1 text-xs font-semibold rounded-full ${wig.status_wig === 'Aktif' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' :
                                                    wig.status_wig === 'Selesai' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400' :
                                                        'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400'
                                                    }`}>
                                                    {wig.status_wig}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="flex items-center gap-3">
                                                    <Link href={`/wig/${wig.id}/edit`} onClick={e => e.stopPropagation()} className="text-slate-400 hover:text-brand-500 transition-colors">
                                                        <Edit className="w-5 h-5" />
                                                    </Link>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="5" className="px-6 py-8 text-center text-slate-500">
                                            No WIGs found.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
