import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function Index({ date, departmentUsers, activities, departemen, allDepartemen }) {
    const awValuesList = ['Berintegritas', 'Profesional', 'Adaptif', 'Bersinergi', 'Dedikatif'];
    const habitsList = [
        'Be Proactive',
        'Begin with the End in Mind',
        'Put First Things First',
        'Think Win-Win',
        'Seek First to Understand Then to Be Understood',
        'Synergize',
        'Sharpen the Saw'
    ];

    const { data, setData, post, processing, errors } = useForm({
        date: date,
        activities: []
    });

    React.useEffect(() => {
        setData({
            date: date,
            activities: departmentUsers.map(u => {
                const existing = activities.find(a => a.user_id === u.id);
                return {
                    user_id: u.id,
                    name: u.name,
                    is_facilitator: existing ? existing.is_facilitator : false,
                    is_culture_champion: existing ? existing.is_culture_champion : false,
                    yesterday_activity: existing ? (existing.yesterday_activity || '') : '',
                    aw_value: existing && existing.aw_value ? existing.aw_value : [],
                    habits: existing && existing.habits ? existing.habits : [],
                    is_favorite: existing ? existing.is_favorite : false,
                };
            })
        });
    }, [date, departmentUsers, activities]);

    const handleFilterChange = (field, value) => {
        router.get('/avicenna-way', { 
            date: field === 'date' ? value : date,
            departemen: field === 'departemen' ? value : departemen 
        }, { preserveState: true });
    };

    const handleActivityChange = (index, field, value) => {
        const newActivities = [...data.activities];
        newActivities[index][field] = value;
        setData('activities', newActivities);
    };

    const handleCheckboxChange = (index, field, valueToToggle) => {
        const newActivities = [...data.activities];
        const currentArr = newActivities[index][field];
        if (currentArr.includes(valueToToggle)) {
            newActivities[index][field] = currentArr.filter(item => item !== valueToToggle);
        } else {
            newActivities[index][field] = [...currentArr, valueToToggle];
        }
        setData('activities', newActivities);
    };

    const handleRadioChange = (index, field) => {
        const newActivities = [...data.activities];
        // Reset field for all
        newActivities.forEach(a => a[field] = false);
        // Set for specific index
        newActivities[index][field] = true;
        setData('activities', newActivities);
    };

    const submit = (e) => {
        e.preventDefault();
        post('/avicenna-way/store');
    };

    return (
        <AuthenticatedLayout>
            <Head title="Avicenna Way - Daily Standup" />

            <div className="mb-6">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white uppercase">Avicenna Way</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mb-4">Pencatatan daily standup departemen {departemen}</p>
                </div>
                
                <div className="flex flex-col sm:flex-row items-center gap-4 bg-white dark:bg-surface-800 p-4 rounded-xl border border-surface-100 dark:border-surface-700 shadow-sm">
                    {/* <a href="/avicenna-way/analytics" className="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                        Lihat Analitik
                    </a> */}
                    
                    <div className="flex items-center gap-2">
                        <label className="text-sm font-medium text-slate-600 dark:text-slate-400">Tanggal:</label>
                        <input 
                            type="date" 
                            value={data.date} 
                            onChange={(e) => handleFilterChange('date', e.target.value)} 
                            className="rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-surface-900 dark:border-surface-600 dark:text-white"
                        />
                    </div>

                    <div className="flex items-center gap-2">
                        <label className="text-sm font-medium text-slate-600 dark:text-slate-400">Departemen:</label>
                        <select 
                            value={departemen}
                            onChange={(e) => handleFilterChange('departemen', e.target.value)}
                            className="rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-surface-900 dark:border-surface-600 dark:text-white min-w-[200px]"
                        >
                            <option value="Semua Departemen">Semua Departemen</option>
                            {allDepartemen && allDepartemen.map((dept, idx) => (
                                <option key={idx} value={dept}>{dept}</option>
                            ))}
                        </select>
                    </div>
                </div>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden">
                <form onSubmit={submit}>
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm text-left">
                            <thead className="text-xs text-slate-500 bg-slate-50 dark:bg-surface-700/50 dark:text-slate-400 uppercase">
                                <tr>
                                    <th className="px-4 py-3">Nama Peserta</th>
                                    <th className="px-4 py-3 w-64">Aktivitas Kemarin</th>
                                    <th className="px-4 py-3 w-48">Nilai Avicenna</th>
                                    <th className="px-4 py-3 w-48">7 Habits</th>
                                    <th className="px-4 py-3 text-center">Fasilitator</th>
                                    <th className="px-4 py-3 text-center">Culture Champ</th>
                                    <th className="px-4 py-3 text-center">Favorit (Bintang)</th>
                                </tr>
                            </thead>
                            <tbody>
                                {data.activities.map((activity, index) => (
                                    <tr key={activity.user_id} className="border-b border-surface-100 dark:border-surface-700 hover:bg-slate-50/50 dark:hover:bg-surface-700/30">
                                        <td className="px-4 py-3 font-medium text-slate-900 dark:text-white">
                                            {activity.name}
                                        </td>
                                        <td className="px-4 py-3">
                                            <textarea 
                                                className="w-full text-sm rounded-md border-slate-300 dark:bg-surface-900 dark:border-surface-600 dark:text-white"
                                                rows="2"
                                                value={activity.yesterday_activity}
                                                onChange={(e) => handleActivityChange(index, 'yesterday_activity', e.target.value)}
                                                placeholder="Aktivitas kemarin..."
                                            ></textarea>
                                        </td>
                                        <td className="px-4 py-3">
                                            <div className="flex flex-col gap-1 max-h-32 overflow-y-auto pr-1 text-xs">
                                                {awValuesList.map(val => (
                                                    <label key={val} className="flex items-center gap-2 cursor-pointer">
                                                        <input 
                                                            type="checkbox" 
                                                            checked={activity.aw_value.includes(val)}
                                                            onChange={() => handleCheckboxChange(index, 'aw_value', val)}
                                                            className="rounded border-slate-300 text-brand-500 focus:ring-brand-500"
                                                        />
                                                        <span className="text-slate-700 dark:text-slate-300">{val}</span>
                                                    </label>
                                                ))}
                                            </div>
                                        </td>
                                        <td className="px-4 py-3">
                                            <div className="flex flex-col gap-1 max-h-32 overflow-y-auto pr-1 text-xs">
                                                {habitsList.map(val => (
                                                    <label key={val} className="flex items-center gap-2 cursor-pointer">
                                                        <input 
                                                            type="checkbox" 
                                                            checked={activity.habits.includes(val)}
                                                            onChange={() => handleCheckboxChange(index, 'habits', val)}
                                                            className="rounded border-slate-300 text-brand-500 focus:ring-brand-500"
                                                        />
                                                        <span className="text-slate-700 dark:text-slate-300 line-clamp-1" title={val}>{val}</span>
                                                    </label>
                                                ))}
                                            </div>
                                        </td>
                                        <td className="px-4 py-3 text-center">
                                            <input 
                                                type="radio" 
                                                name="is_facilitator"
                                                checked={activity.is_facilitator}
                                                onChange={() => handleRadioChange(index, 'is_facilitator')}
                                                className="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500"
                                            />
                                        </td>
                                        <td className="px-4 py-3 text-center">
                                            <input 
                                                type="radio" 
                                                name="is_culture_champion"
                                                checked={activity.is_culture_champion}
                                                onChange={() => handleRadioChange(index, 'is_culture_champion')}
                                                className="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500"
                                            />
                                        </td>
                                        <td className="px-4 py-3 text-center">
                                            <input 
                                                type="radio" 
                                                name="is_favorite"
                                                checked={activity.is_favorite}
                                                onChange={() => handleRadioChange(index, 'is_favorite')}
                                                className="w-5 h-5 text-amber-500 border-slate-300 focus:ring-amber-500 focus:ring-2"
                                            />
                                        </td>
                                    </tr>
                                ))}
                                {data.activities.length === 0 && (
                                    <tr>
                                        <td colSpan="7" className="px-4 py-8 text-center text-slate-500">
                                            Tidak ada user di departemen ini.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                    <div className="p-4 border-t border-surface-100 dark:border-surface-700 flex justify-end">
                        <button 
                            type="submit" 
                            disabled={processing}
                            className="px-6 py-2 bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-lg disabled:opacity-50 transition-colors"
                        >
                            {processing ? 'Menyimpan...' : 'Simpan Pencatatan'}
                        </button>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
