import React, { useState } from 'react';
import { usePage, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Database, Plus, Edit, Trash2, Tag, Save, X } from 'lucide-react';

export default function MasterDataPage({ weights = [], categories = [], labels = [] }) {
    const { auth } = usePage().props;

    const { data, setData, post, processing, reset } = useForm({
        name: '',
        color: '#3b82f6',
    });

    const [showLabelForm, setShowLabelForm] = useState(false);

    const submitLabel = (e) => {
        e.preventDefault();
        post(route('kanban.master-label.store'), {
            onSuccess: () => {
                reset();
                setShowLabelForm(false);
            },
        });
    };

    return (
        <AuthenticatedLayout user={usePage().props.auth?.user}>
            <div className="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                        <Database className="w-8 h-8 text-brand-500" />
                        Master Data Management
                    </h1>
                    <p className="text-slate-500 dark:text-slate-400 mt-1">Manage global system parameters and configurations.</p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {/* Task Weights Section */}
                    <div className="bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-2xl shadow-xl overflow-hidden flex flex-col">
                        <div className="p-6 border-b border-slate-200 dark:border-slate-700/50 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/30">
                            <h2 className="text-xl font-bold text-slate-900 dark:text-white">Task Weights</h2>
                            <button className="p-2 bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-500/20 rounded-lg transition-colors">
                                <Plus className="w-5 h-5" />
                            </button>
                        </div>
                        <div className="flex-1 overflow-x-auto p-0">
                            <table className="w-full text-left border-collapse">
                                <thead>
                                    <tr className="bg-slate-100/50 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700">
                                        <th className="px-6 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300">Level</th>
                                        <th className="px-6 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300">Weight</th>
                                        <th className="px-6 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300 w-24">Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-200 dark:divide-slate-700">
                                    {weights.length > 0 ? (
                                        weights.map(weight => (
                                            <tr key={weight.id} className="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                                <td className="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{weight.level}</td>
                                                <td className="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{weight.weight_value}</td>
                                                <td className="px-6 py-4">
                                                    <div className="flex items-center gap-2">
                                                        <button className="text-slate-400 hover:text-brand-500 transition-colors">
                                                            <Edit className="w-4 h-4" />
                                                        </button>
                                                        <button className="text-slate-400 hover:text-red-500 transition-colors">
                                                            <Trash2 className="w-4 h-4" />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td colSpan="3" className="px-6 py-8 text-center text-slate-500">
                                                No task weights defined.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {/* Kategori Program Kerja Section */}
                    <div className="bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-2xl shadow-xl overflow-hidden flex flex-col">
                        <div className="p-6 border-b border-slate-200 dark:border-slate-700/50 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/30">
                            <h2 className="text-xl font-bold text-slate-900 dark:text-white">Kategori Program Kerja</h2>
                            <button className="p-2 bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-500/20 rounded-lg transition-colors">
                                <Plus className="w-5 h-5" />
                            </button>
                        </div>
                        <div className="flex-1 overflow-x-auto p-0">
                            <table className="w-full text-left border-collapse">
                                <thead>
                                    <tr className="bg-slate-100/50 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700">
                                        <th className="px-6 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300">Category Name</th>
                                        <th className="px-6 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300 w-24">Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-200 dark:divide-slate-700">
                                    {categories.length > 0 ? (
                                        categories.map(category => (
                                            <tr key={category.id} className="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                                <td className="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{category.name}</td>
                                                <td className="px-6 py-4">
                                                    <div className="flex items-center gap-2">
                                                        <button className="text-slate-400 hover:text-brand-500 transition-colors">
                                                            <Edit className="w-4 h-4" />
                                                        </button>
                                                        <button className="text-slate-400 hover:text-red-500 transition-colors">
                                                            <Trash2 className="w-4 h-4" />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td colSpan="2" className="px-6 py-8 text-center text-slate-500">
                                                No categories defined.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {/* Manajemen Label Section */}
                <div className="mt-8 bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-2xl shadow-xl overflow-hidden flex flex-col">
                    <div className="p-6 border-b border-slate-200 dark:border-slate-700/50 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/30">
                        <div className="flex items-center gap-3">
                            <Tag className="w-6 h-6 text-brand-500" />
                            <h2 className="text-xl font-bold text-slate-900 dark:text-white">Manajemen Label</h2>
                        </div>
                        <button 
                            onClick={() => setShowLabelForm(!showLabelForm)}
                            className="p-2 bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-500/20 rounded-lg transition-colors"
                        >
                            {showLabelForm ? <X className="w-5 h-5" /> : <Plus className="w-5 h-5" />}
                        </button>
                    </div>
                    
                    {showLabelForm && (
                        <div className="p-6 border-b border-slate-200 dark:border-slate-700/50 bg-slate-50 dark:bg-slate-800/50">
                            <form onSubmit={submitLabel} className="flex flex-col sm:flex-row items-end gap-4">
                                <div className="flex-1 w-full">
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Label</label>
                                    <input 
                                        type="text" 
                                        value={data.name}
                                        onChange={e => setData('name', e.target.value)}
                                        className="w-full border-slate-300 dark:border-slate-700 dark:bg-slate-900 rounded-lg shadow-sm focus:ring-brand-500 focus:border-brand-500" 
                                        required 
                                        placeholder="Contoh: Urgent, Bug, Fitur"
                                    />
                                </div>
                                <div className="w-full sm:w-32">
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Warna</label>
                                    <div className="flex items-center gap-2">
                                        <input 
                                            type="color" 
                                            value={data.color}
                                            onChange={e => setData('color', e.target.value)}
                                            className="h-10 w-full rounded cursor-pointer" 
                                        />
                                    </div>
                                </div>
                                <button 
                                    type="submit" 
                                    disabled={processing}
                                    className="w-full sm:w-auto flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-sm disabled:opacity-70"
                                >
                                    <Save className="w-4 h-4" />
                                    Simpan
                                </button>
                            </form>
                        </div>
                    )}

                    <div className="overflow-x-auto p-0">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="bg-slate-100/50 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700">
                                    <th className="px-6 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300">Label</th>
                                    <th className="px-6 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300">Warna</th>
                                    <th className="px-6 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300 w-24">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-200 dark:divide-slate-700">
                                {labels?.length > 0 ? (
                                    labels.map(label => (
                                        <tr key={label.id} className="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td className="px-6 py-4">
                                                <span 
                                                    className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border"
                                                    style={{ 
                                                        backgroundColor: `${label.color}20`, 
                                                        color: label.color,
                                                        borderColor: `${label.color}40`
                                                    }}
                                                >
                                                    {label.name}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="flex items-center gap-2">
                                                    <div className="w-6 h-6 rounded border border-slate-200" style={{ backgroundColor: label.color }}></div>
                                                    <span className="text-sm text-slate-500 font-mono">{label.color}</span>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="flex items-center gap-2">
                                                    <button className="text-slate-400 hover:text-brand-500 transition-colors">
                                                        <Edit className="w-4 h-4" />
                                                    </button>
                                                    <button className="text-slate-400 hover:text-red-500 transition-colors">
                                                        <Trash2 className="w-4 h-4" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="3" className="px-6 py-8 text-center text-slate-500">
                                            Belum ada label.
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
