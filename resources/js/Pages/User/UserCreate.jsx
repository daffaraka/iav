import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function UserCreate({ roles }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        employee_code: '',
        position: '',
        department: '',
        location: '',
        role: ''
    });

    const submit = (e) => {
        e.preventDefault();
        post('/user');
    };

    return (
        <AuthenticatedLayout>
            <Head title="Tambah User" />

            <div className="mb-6 flex items-center justify-between">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">Tambah User</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Buat akun pengguna baru</p>
                </div>
                <Link 
                    href="/user" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-arrow-left mr-2"></i>
                    Kembali
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 transition-colors duration-300">
                <form onSubmit={submit} className="space-y-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {/* Kolom Kiri */}
                        <div className="space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Nama <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.name ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                    required
                                />
                                {errors.name && <p className="mt-1 text-sm text-red-500">{errors.name}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Email <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.email ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                    required
                                />
                                {errors.email && <p className="mt-1 text-sm text-red-500">{errors.email}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Password <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.password ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                    required
                                />
                                {errors.password && <p className="mt-1 text-sm text-red-500">{errors.password}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Konfirmasi Password <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="password"
                                    value={data.password_confirmation}
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 focus:ring-brand-500 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                    required
                                />
                            </div>
                        </div>

                        {/* Kolom Kanan */}
                        <div className="space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Kode Karyawan
                                </label>
                                <input
                                    type="text"
                                    value={data.employee_code}
                                    onChange={(e) => setData('employee_code', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.employee_code ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                />
                                {errors.employee_code && <p className="mt-1 text-sm text-red-500">{errors.employee_code}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Jabatan
                                </label>
                                <input
                                    type="text"
                                    value={data.position}
                                    onChange={(e) => setData('position', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.position ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                />
                                {errors.position && <p className="mt-1 text-sm text-red-500">{errors.position}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Departemen
                                </label>
                                <input
                                    type="text"
                                    value={data.department}
                                    onChange={(e) => setData('department', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.department ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                />
                                {errors.department && <p className="mt-1 text-sm text-red-500">{errors.department}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Lokasi
                                </label>
                                <select
                                    value={data.location}
                                    onChange={(e) => setData('location', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.location ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                >
                                    <option value="">Pilih Lokasi</option>
                                    <option value="Cinere">Cinere</option>
                                    <option value="Jagakarsa">Jagakarsa</option>
                                    <option value="Pamulang">Pamulang</option>
                                    <option value="BPS">BPS</option>
                                </select>
                                {errors.location && <p className="mt-1 text-sm text-red-500">{errors.location}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Role <span className="text-red-500">*</span>
                                </label>
                                <select
                                    value={data.role}
                                    onChange={(e) => setData('role', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.role ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                    required
                                >
                                    <option value="">Pilih Role</option>
                                    {roles && roles.map(r => (
                                        <option key={r.id} value={r.name}>
                                            {r.name.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                        </option>
                                    ))}
                                </select>
                                {errors.role && <p className="mt-1 text-sm text-red-500">{errors.role}</p>}
                            </div>
                        </div>
                    </div>

                    <div className="pt-6 border-t border-surface-100 dark:border-surface-700 flex items-center justify-end gap-3">
                        <Link 
                            href="/user"
                            className="inline-flex items-center justify-center px-6 py-2.5 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            disabled={processing}
                            className="inline-flex items-center justify-center px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors disabled:opacity-50"
                        >
                            {processing ? 'Menyimpan...' : 'Simpan User'}
                        </button>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
