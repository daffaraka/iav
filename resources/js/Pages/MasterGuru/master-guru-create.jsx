import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function MasterGuruCreate() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        username: '',
        password: '',
        role: 'guru',
        kelas: ''
    });

    const submit = (e) => {
        e.preventDefault();
        post('/master-guru');
    };

    return (
        <AuthenticatedLayout>
            <Head title="Tambah Master Guru" />

            <div className="mb-6 flex items-center justify-between">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">Tambah Master Guru</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Masukkan informasi guru baru</p>
                </div>
                <Link 
                    href="/master-guru" 
                    className="px-4 py-2 text-sm font-semibold text-slate-600 bg-surface-200 hover:bg-surface-300 dark:bg-surface-700 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors"
                >
                    Kembali
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 p-6">
                <form onSubmit={submit} className="max-w-2xl space-y-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Nama Lengkap <span className="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                value={data.name}
                                onChange={e => setData('name', e.target.value)}
                                className={`w-full rounded-xl border ${errors.name ? 'border-red-500' : 'border-surface-200 dark:border-surface-700'} bg-surface-50 dark:bg-surface-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none transition-all`}
                                placeholder="Nama lengkap dengan gelar"
                            />
                            {errors.name && <p className="mt-1 text-sm text-red-500">{errors.name}</p>}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Kelas (Opsional)
                            </label>
                            <input
                                type="text"
                                value={data.kelas}
                                onChange={e => setData('kelas', e.target.value)}
                                className={`w-full rounded-xl border ${errors.kelas ? 'border-red-500' : 'border-surface-200 dark:border-surface-700'} bg-surface-50 dark:bg-surface-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none transition-all`}
                                placeholder="Contoh: VII A"
                            />
                            {errors.kelas && <p className="mt-1 text-sm text-red-500">{errors.kelas}</p>}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Email <span className="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                value={data.email}
                                onChange={e => setData('email', e.target.value)}
                                className={`w-full rounded-xl border ${errors.email ? 'border-red-500' : 'border-surface-200 dark:border-surface-700'} bg-surface-50 dark:bg-surface-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none transition-all`}
                                placeholder="email@contoh.com"
                            />
                            {errors.email && <p className="mt-1 text-sm text-red-500">{errors.email}</p>}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Username <span className="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                value={data.username}
                                onChange={e => setData('username', e.target.value)}
                                className={`w-full rounded-xl border ${errors.username ? 'border-red-500' : 'border-surface-200 dark:border-surface-700'} bg-surface-50 dark:bg-surface-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none transition-all`}
                                placeholder="username"
                            />
                            {errors.username && <p className="mt-1 text-sm text-red-500">{errors.username}</p>}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Password <span className="text-red-500">*</span>
                            </label>
                            <input
                                type="password"
                                value={data.password}
                                onChange={e => setData('password', e.target.value)}
                                className={`w-full rounded-xl border ${errors.password ? 'border-red-500' : 'border-surface-200 dark:border-surface-700'} bg-surface-50 dark:bg-surface-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none transition-all`}
                                placeholder="Minimal 8 karakter"
                            />
                            {errors.password && <p className="mt-1 text-sm text-red-500">{errors.password}</p>}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Peran (Role) <span className="text-red-500">*</span>
                            </label>
                            <select
                                value={data.role}
                                onChange={e => setData('role', e.target.value)}
                                className={`w-full rounded-xl border ${errors.role ? 'border-red-500' : 'border-surface-200 dark:border-surface-700'} bg-surface-50 dark:bg-surface-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-brand-500 outline-none transition-all`}
                            >
                                <option value="guru">Guru</option>
                                <option value="walikelas">Wali Kelas</option>
                            </select>
                            {errors.role && <p className="mt-1 text-sm text-red-500">{errors.role}</p>}
                        </div>
                    </div>

                    <div className="flex justify-end gap-3 pt-4 border-t border-surface-200 dark:border-surface-700">
                        <button
                            type="button"
                            onClick={() => window.history.back()}
                            className="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:text-slate-300 dark:hover:bg-surface-600 rounded-xl transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            disabled={processing}
                            className="px-5 py-2.5 text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-colors inline-flex items-center"
                        >
                            {processing && <i className="ph ph-spinner animate-spin mr-2"></i>}
                            Simpan Guru
                        </button>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
