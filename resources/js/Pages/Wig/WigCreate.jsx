import React, { useState } from 'react';
import { usePage, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { ArrowLeft, Save } from 'lucide-react';

export default function WigCreate({ departements = [], users = [] }) {
    const { auth } = usePage().props;
    const [data, setData] = useState({
        judul_wig: '',
        deskripsi_wig: '',
        tanggal_mulai_wig: '',
        tanggal_berakhir_wig: '',
        departement_id: '',
        bobot_kpi: ''
    });

    const submit = (e) => {
        e.preventDefault();
        router.post('/wig', data);
    };

    return (
        <AuthenticatedLayout user={auth?.user}>
            <div className="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
                <div className="mb-6">
                    <Link href={'/wig'} className="inline-flex items-center gap-2 text-slate-500 hover:text-brand-500 transition-colors">
                        <ArrowLeft className="w-4 h-4" />
                        <span>Back to WIGs</span>
                    </Link>
                </div>

                <div className="bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-2xl shadow-xl overflow-hidden p-8">
                    <h2 className="text-2xl font-bold text-slate-900 dark:text-white mb-6">Create New WIG</h2>
                    
                    <form onSubmit={submit} className="space-y-6">
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul WIG</label>
                            <input 
                                type="text" 
                                placeholder="Contoh: Meningkatkan efisiensi layanan operasional..."
                                value={data.judul_wig}
                                onChange={e => setData({...data, judul_wig: e.target.value})}
                                className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                                required
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi</label>
                            <textarea 
                                rows="4"
                                placeholder="Tuliskan deskripsi lengkap atau sasaran strategis dari WIG ini..."
                                value={data.deskripsi_wig}
                                onChange={e => setData({...data, deskripsi_wig: e.target.value})}
                                className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                            />
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tanggal Mulai</label>
                                <input 
                                    type="date" 
                                    value={data.tanggal_mulai_wig}
                                    onChange={e => setData({...data, tanggal_mulai_wig: e.target.value})}
                                    className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                                    required
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tanggal Berakhir</label>
                                <input 
                                    type="date" 
                                    value={data.tanggal_berakhir_wig}
                                    onChange={e => setData({...data, tanggal_berakhir_wig: e.target.value})}
                                    className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                                    required
                                />
                            </div>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Departemen</label>
                                <select 
                                    value={data.departement_id}
                                    onChange={e => setData({...data, departement_id: e.target.value})}
                                    className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                                    required
                                >
                                    <option value="">Select Departemen</option>
                                    {departements.map(d => (
                                        <option key={d.id} value={d.id}>{d.name}</option>
                                    ))}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Bobot KPI (%)</label>
                                <input 
                                    type="number" 
                                    min="0"
                                    max="100"
                                    placeholder="Masukkan bobot KPI (0 - 100)"
                                    value={data.bobot_kpi}
                                    onChange={e => setData({...data, bobot_kpi: e.target.value})}
                                    className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                                    required
                                />
                            </div>
                        </div>

                        <div className="pt-4 flex justify-end">
                            <button 
                                type="submit"
                                className="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-xl transition-all shadow-lg shadow-brand-500/30 font-medium"
                            >
                                <Save className="w-5 h-5" />
                                <span>Save WIG</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
