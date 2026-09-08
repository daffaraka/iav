import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { 
    Ticket as TicketIcon, 
    Plus as PlusIcon, 
    Search as MagnifyingGlassIcon,
    AlertCircle as ExclamationCircleIcon,
    CheckCircle as CheckCircleIcon,
    Clock as ClockIcon,
    ShieldAlert as ShieldExclamationIcon,
    User as UserIcon,
    Building2 as BuildingOfficeIcon
} from 'lucide-react';
import Pagination from '@/Components/Pagination';

export default function Index({ auth, tikets, filters, can }) {
    const handleSearch = (e) => {
        e.preventDefault();
        router.get('/dashboard/aqr/tiket-karyawan', {
            search: e.target.search.value,
            status: e.target.status.value
        }, { preserveState: true });
    };

    const getStatusBadge = (status) => {
        switch (status) {
            case 'New':
                return <span className="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 rounded-full flex items-center gap-1.5"><ExclamationCircleIcon className="w-3.5 h-3.5" /> New</span>;
            case 'Proses':
                return <span className="px-2.5 py-1 text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 rounded-full flex items-center gap-1.5"><ClockIcon className="w-3.5 h-3.5" /> Proses</span>;
            case 'Selesai':
                return <span className="px-2.5 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 rounded-full flex items-center gap-1.5"><CheckCircleIcon className="w-3.5 h-3.5" /> Selesai</span>;
            case 'Spam':
                return <span className="px-2.5 py-1 text-xs font-medium bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 rounded-full flex items-center gap-1.5"><ShieldExclamationIcon className="w-3.5 h-3.5" /> Spam</span>;
            default:
                return <span className="px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-500/10 dark:text-slate-400 rounded-full">{status}</span>;
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-slate-800 dark:text-white leading-tight">Tiket Karyawan</h2>}
        >
            <Head title="Tiket Karyawan" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {/* Header Section */}
                    <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <div>
                            <h3 className="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <TicketIcon className="w-6 h-6 text-brand-500" />
                                Daftar Tiket Karyawan
                            </h3>
                            <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                Kelola pengaduan dan permintaan dari karyawan internal.
                            </p>
                        </div>
                        
                        <div className="flex items-center gap-3 w-full sm:w-auto">
                            {can.create && (
                                <Link
                                    href="/dashboard/aqr/tiket-karyawan/create"
                                    className="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-sm font-medium rounded-xl transition-all shadow-sm shadow-brand-500/20"
                                >
                                    <PlusIcon className="w-5 h-5" />
                                    Buat Tiket
                                </Link>
                            )}
                        </div>
                    </div>

                    {/* Filters & Search */}
                    <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-800 p-4 mb-6">
                        <form onSubmit={handleSearch} className="flex flex-col sm:flex-row gap-4">
                            <div className="flex-1 relative">
                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <MagnifyingGlassIcon className="h-5 w-5 text-slate-400" />
                                </div>
                                <input
                                    type="text"
                                    name="search"
                                    defaultValue={filters.search}
                                    className="block w-full pl-10 pr-3 py-2 border border-surface-200 dark:border-surface-700 rounded-xl leading-5 bg-surface-50 dark:bg-surface-800 placeholder-slate-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition-colors"
                                    placeholder="Cari no tiket atau judul..."
                                />
                            </div>
                            <div className="sm:w-48">
                                <select
                                    name="status"
                                    defaultValue={filters.status}
                                    className="block w-full py-2 px-3 border border-surface-200 dark:border-surface-700 rounded-xl bg-surface-50 dark:bg-surface-800 text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm"
                                >
                                    <option value="">Semua Status</option>
                                    <option value="New">New</option>
                                    <option value="Proses">Proses</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Spam">Spam</option>
                                </select>
                            </div>
                            <button
                                type="submit"
                                className="inline-flex justify-center items-center px-4 py-2 border border-surface-200 dark:border-surface-700 rounded-xl bg-white dark:bg-surface-800 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-surface-50 dark:hover:bg-surface-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors"
                            >
                                Filter
                            </button>
                        </form>
                    </div>

                    {/* Table List */}
                    <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-800 overflow-hidden">
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-surface-200 dark:divide-surface-800">
                                <thead className="bg-surface-50 dark:bg-surface-800/50">
                                    <tr>
                                        <th scope="col" className="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">No Tiket</th>
                                        <th scope="col" className="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pengirim</th>
                                        <th scope="col" className="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Judul & Kendala</th>
                                        <th scope="col" className="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                        <th scope="col" className="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white dark:bg-surface-900 divide-y divide-surface-200 dark:divide-surface-800">
                                    {tikets.data.map((tiket) => (
                                        <tr key={tiket.id} className="hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <div className="text-sm font-mono font-medium text-brand-600 dark:text-brand-400">
                                                    {tiket.no_tiket}
                                                </div>
                                                <div className="text-xs text-slate-500 mt-1">
                                                    {new Date(tiket.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                                                </div>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="flex items-center gap-2">
                                                    <div className="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-500/20 flex items-center justify-center text-brand-600 dark:text-brand-400 font-bold text-sm">
                                                        {tiket.user?.name.charAt(0)}
                                                    </div>
                                                    <div>
                                                        <div className="text-sm font-medium text-slate-900 dark:text-white">
                                                            {tiket.user?.name}
                                                        </div>
                                                        <div className="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                                            <BuildingOfficeIcon className="w-3 h-3" />
                                                            {tiket.departemen} - {tiket.lokasi_kendala}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="text-sm font-medium text-slate-900 dark:text-white line-clamp-1">
                                                    {tiket.judul_kendala}
                                                </div>
                                                <div className="text-sm text-slate-500 line-clamp-1 mt-0.5 max-w-xs">
                                                    {tiket.detail_kendala}
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                {getStatusBadge(tiket.status)}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <Link
                                                    href={`/dashboard/aqr/tiket-karyawan/${tiket.id}`}
                                                    className="text-brand-600 hover:text-brand-900 dark:text-brand-400 dark:hover:text-brand-300"
                                                >
                                                    Detail
                                                </Link>
                                            </td>
                                        </tr>
                                    ))}
                                    {tikets.data.length === 0 && (
                                        <tr>
                                            <td colSpan="5" className="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                                <TicketIcon className="w-12 h-12 mx-auto mb-3 text-slate-300 dark:text-slate-600" />
                                                <p className="text-base font-medium text-slate-900 dark:text-white">Belum ada tiket karyawan</p>
                                                <p className="text-sm mt-1">Gunakan tombol 'Buat Tiket' untuk memulai.</p>
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                        {tikets.links && (
                            <div className="px-6 py-4 border-t border-surface-200 dark:border-surface-800 bg-surface-50 dark:bg-surface-800/50">
                                <Pagination links={tikets.links} />
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
