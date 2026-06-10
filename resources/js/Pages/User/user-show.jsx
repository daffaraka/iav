import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function UserShow({ user }) {
    return (
        <AuthenticatedLayout>
            <Head title={`Profil User: ${user.name}`} />

            <div className="mb-6 flex items-center justify-between">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">Detail User</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Informasi profil dan hak akses pengguna</p>
                </div>
                <div className="flex gap-2">
                    <Link 
                        href={`/user/${user.id}/edit`}
                        className="inline-flex items-center justify-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold transition-colors"
                    >
                        <i className="ph ph-pencil-simple mr-2"></i>
                        Edit Data
                    </Link>
                    <Link 
                        href="/user" 
                        className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                    >
                        <i className="ph ph-arrow-left mr-2"></i>
                        Kembali
                    </Link>
                </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                {/* Profile Card */}
                <div className="col-span-1">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden h-full flex flex-col items-center text-center p-8">
                        <div className="w-24 h-24 rounded-full bg-brand-100 dark:bg-brand-900/30 flex items-center justify-center text-brand-600 dark:text-brand-400 text-3xl font-bold mb-4">
                            {user.name.charAt(0).toUpperCase()}
                        </div>
                        <h2 className="text-xl font-bold text-slate-800 dark:text-white mb-1">{user.name}</h2>
                        <p className="text-slate-500 dark:text-slate-400 text-sm mb-4">{user.email}</p>
                        
                        <div className="flex flex-wrap justify-center gap-2 mb-6">
                            {user.roles && user.roles.map(role => (
                                <span key={role.id} className="inline-flex px-3 py-1 rounded-lg bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300 text-xs font-semibold uppercase tracking-wider">
                                    {role.name}
                                </span>
                            ))}
                        </div>

                        <div className="w-full pt-6 border-t border-surface-100 dark:border-surface-700 space-y-3 text-left">
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-slate-500 dark:text-slate-400">Kode Karyawan</span>
                                <span className="text-sm font-semibold text-slate-800 dark:text-slate-200">{user.employee_code || user.kode_karyawan || '-'}</span>
                            </div>
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-slate-500 dark:text-slate-400">Jabatan</span>
                                <span className="text-sm font-semibold text-slate-800 dark:text-slate-200">{user.jabatan || user.position || '-'}</span>
                            </div>
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-slate-500 dark:text-slate-400">Unit</span>
                                <span className="text-sm font-semibold text-slate-800 dark:text-slate-200">{user.unit || user.location || '-'}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Additional Details */}
                <div className="col-span-1 md:col-span-2 space-y-6">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                            <h3 className="font-semibold text-slate-800 dark:text-white">Detail Akademik & Organisasi</h3>
                        </div>
                        <div className="p-6">
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Departemen</label>
                                    <div className="text-base text-slate-800 dark:text-slate-200 font-medium bg-surface-50 dark:bg-surface-900/50 px-4 py-2.5 rounded-xl border border-surface-100 dark:border-surface-700">
                                        {user.departemen || user.department || 'Tidak diatur'}
                                    </div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">NIP</label>
                                    <div className="text-base text-slate-800 dark:text-slate-200 font-medium bg-surface-50 dark:bg-surface-900/50 px-4 py-2.5 rounded-xl border border-surface-100 dark:border-surface-700">
                                        {user.nip || 'Tidak diatur'}
                                    </div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Jenjang</label>
                                    <div className="text-base text-slate-800 dark:text-slate-200 font-medium bg-surface-50 dark:bg-surface-900/50 px-4 py-2.5 rounded-xl border border-surface-100 dark:border-surface-700">
                                        {user.jenjang || 'Tidak diatur'}
                                    </div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Wali Kelas</label>
                                    <div className="text-base text-slate-800 dark:text-slate-200 font-medium bg-surface-50 dark:bg-surface-900/50 px-4 py-2.5 rounded-xl border border-surface-100 dark:border-surface-700">
                                        {user.kelas ? `Kelas ${user.kelas}${user.sub_kelas || ''}` : 'Bukan Wali Kelas'}
                                    </div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Username System</label>
                                    <div className="text-base text-slate-800 dark:text-slate-200 font-medium bg-surface-50 dark:bg-surface-900/50 px-4 py-2.5 rounded-xl border border-surface-100 dark:border-surface-700">
                                        {user.username || 'Sama dengan email'}
                                    </div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">No. HP / Kontak</label>
                                    <div className="text-base text-slate-800 dark:text-slate-200 font-medium bg-surface-50 dark:bg-surface-900/50 px-4 py-2.5 rounded-xl border border-surface-100 dark:border-surface-700">
                                        {user.no_hp || 'Tidak diatur'}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
