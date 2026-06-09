import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function Index({ aqrOptions }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Yakin ingin menghapus AQR Option ini?')) {
            destroy(`/aqr-option/${id}`);
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="AQR Option" />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">Data AQR Option</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Kelola opsi pertanyaan dan kendala</p>
                </div>
                <Link 
                    href="/aqr-option/create" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-plus mr-2"></i>
                    Tambah Option
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden transition-colors duration-300">
                <div className="overflow-x-auto custom-scrollbar">
                    <table className="w-full text-left border-collapse min-w-max">
                        <thead>
                            <tr className="bg-surface-50/50 dark:bg-surface-800/50 text-slate-500 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-surface-100 dark:border-surface-700">
                                <th className="px-6 py-4 font-semibold">No</th>
                                <th className="px-6 py-4 font-semibold">Nama Option</th>
                                <th className="px-6 py-4 font-semibold">Kategori PIC</th>
                                <th className="px-6 py-4 font-semibold">Aktif</th>
                                <th className="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-surface-100 dark:divide-surface-700">
                            {aqrOptions && aqrOptions.length > 0 ? (
                                aqrOptions.map((option, index) => (
                                    <tr key={option.id} className="hover:bg-surface-50/50 dark:hover:bg-surface-700/50 transition-colors group">
                                        <td className="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                            {index + 1}
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="text-sm font-semibold text-slate-800 dark:text-white">{option.nama_option}</div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className={`inline-flex px-2.5 py-1 rounded-lg text-xs font-medium border ${
                                                option.kategori_pic === 'Kepala Sekolah' ? 'border-primary-200 bg-primary-50 text-primary-700 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-400' :
                                                option.kategori_pic === 'Kepala TU' ? 'border-success-200 bg-success-50 text-success-700 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400' :
                                                option.kategori_pic === 'Psikolog' ? 'border-info-200 bg-info-50 text-info-700 dark:border-info-500/20 dark:bg-info-500/10 dark:text-info-400' :
                                                'border-surface-200 bg-surface-50 text-surface-700 dark:border-surface-500/20 dark:bg-surface-500/10 dark:text-surface-400'
                                            }`}>
                                                {option.kategori_pic}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4">
                                            {option.is_aktif ? (
                                                <span className="inline-flex px-2 py-1 rounded bg-slate-800 text-white dark:bg-white dark:text-slate-800 text-xs font-semibold">Aktif</span>
                                            ) : (
                                                <span className="inline-flex px-2 py-1 rounded bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400 text-xs font-semibold">Tidak Aktif</span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="flex items-center justify-center gap-2">
                                                <Link 
                                                    href={`/aqr-option/${option.id}/edit`}
                                                    className="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg transition-colors"
                                                    title="Edit"
                                                >
                                                    <i className="ph ph-pencil-simple text-lg"></i>
                                                </Link>
                                                <button 
                                                    onClick={() => handleDelete(option.id)}
                                                    className="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors"
                                                    title="Hapus"
                                                >
                                                    <i className="ph ph-trash text-lg"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="5" className="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                                        <div className="flex flex-col items-center justify-center">
                                            <i className="ph ph-list-dashes text-4xl mb-2 text-slate-300 dark:text-slate-600"></i>
                                            <p>Tidak ada data AQR Option</p>
                                        </div>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
