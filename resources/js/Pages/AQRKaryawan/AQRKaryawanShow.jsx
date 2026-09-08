import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, router } from '@inertiajs/react';
import { 
    Ticket as TicketIcon, 
    ArrowLeft as ArrowLeftIcon,
    MessageSquare as ChatBubbleLeftRightIcon,
    Paperclip as PaperClipIcon,
    CheckCircle as CheckCircleIcon,
    UserCircle as UserCircleIcon
} from 'lucide-react';

export default function Show({ auth, tiket, pics, can }) {
    const { data: updateData, setData: setUpdateData, put, processing } = useForm({
        status: tiket.status,
        pic_id: tiket.pic_id || ''
    });

    const handleUpdate = (e) => {
        e.preventDefault();
        put(`/dashboard/aqr/tiket-karyawan/${tiket.id}`);
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-slate-800 dark:text-white leading-tight">Detail Tiket Karyawan</h2>}
        >
            <Head title={`Tiket ${tiket.no_tiket}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    
                    <div>
                        <Link 
                            href="/dashboard/aqr/tiket-karyawan" 
                            className="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300"
                        >
                            <ArrowLeftIcon className="w-4 h-4" />
                            Kembali ke Daftar
                        </Link>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        {/* Kolom Kiri: Detail Tiket */}
                        <div className="lg:col-span-2 space-y-6">
                            <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-800 p-6">
                                <div className="flex justify-between items-start mb-6">
                                    <div>
                                        <h3 className="text-xl font-bold text-slate-900 dark:text-white">{tiket.judul_kendala}</h3>
                                        <div className="text-sm font-mono text-brand-600 dark:text-brand-400 mt-1">
                                            {tiket.no_tiket}
                                        </div>
                                    </div>
                                    <span className={`px-3 py-1 text-sm font-medium rounded-full ${
                                        tiket.status === 'New' ? 'bg-blue-100 text-blue-700' :
                                        tiket.status === 'Proses' ? 'bg-amber-100 text-amber-700' :
                                        tiket.status === 'Selesai' ? 'bg-emerald-100 text-emerald-700' :
                                        'bg-red-100 text-red-700'
                                    }`}>
                                        {tiket.status}
                                    </span>
                                </div>

                                <div className="grid grid-cols-2 gap-4 mb-6 text-sm">
                                    <div>
                                        <p className="text-slate-500 dark:text-slate-400">Pengirim</p>
                                        <p className="font-medium text-slate-900 dark:text-white">{tiket.user?.name}</p>
                                    </div>
                                    <div>
                                        <p className="text-slate-500 dark:text-slate-400">Departemen</p>
                                        <p className="font-medium text-slate-900 dark:text-white">{tiket.departemen}</p>
                                    </div>
                                    <div>
                                        <p className="text-slate-500 dark:text-slate-400">Kategori Masalah</p>
                                        <p className="font-medium text-slate-900 dark:text-white">{tiket.masalah_dept}</p>
                                    </div>
                                    <div>
                                        <p className="text-slate-500 dark:text-slate-400">Lokasi</p>
                                        <p className="font-medium text-slate-900 dark:text-white">{tiket.lokasi_kendala}</p>
                                    </div>
                                    <div>
                                        <p className="text-slate-500 dark:text-slate-400">Tanggal Pengajuan</p>
                                        <p className="font-medium text-slate-900 dark:text-white">
                                            {new Date(tiket.created_at).toLocaleString('id-ID')}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <p className="text-slate-500 dark:text-slate-400 text-sm mb-2">Detail Kendala</p>
                                    <div className="p-4 bg-surface-50 dark:bg-surface-800 rounded-xl text-slate-700 dark:text-slate-300 text-sm whitespace-pre-wrap">
                                        {tiket.detail_kendala}
                                    </div>
                                </div>

                                {tiket.filename && (
                                    <div className="mt-6">
                                        <p className="text-slate-500 dark:text-slate-400 text-sm mb-2">Lampiran</p>
                                        <a href={`/storage/${tiket.filename}`} target="_blank" rel="noreferrer" className="inline-flex items-center gap-2 px-4 py-2 border border-surface-200 dark:border-surface-700 rounded-xl text-sm font-medium text-brand-600 dark:text-brand-400 hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors">
                                            <PaperClipIcon className="w-5 h-5" />
                                            Lihat Lampiran
                                        </a>
                                    </div>
                                )}
                            </div>

                            {/* Komentar / Progres (Placeholder) */}
                            <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-800 p-6">
                                <h4 className="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2 mb-6">
                                    <ChatBubbleLeftRightIcon className="w-5 h-5 text-brand-500" />
                                    Progres Penanganan
                                </h4>
                                
                                {tiket.progres && tiket.progres.length > 0 ? (
                                    <div className="space-y-4">
                                        {tiket.progres.map(prog => (
                                            <div key={prog.id} className="p-4 rounded-xl border border-surface-200 dark:border-surface-800 bg-surface-50 dark:bg-surface-800/50">
                                                <div className="flex items-center gap-2 mb-2">
                                                    <UserCircleIcon className="w-5 h-5 text-slate-400" />
                                                    <span className="text-sm font-medium text-slate-900 dark:text-white">{prog.user?.name}</span>
                                                    <span className="text-xs text-slate-500">{new Date(prog.created_at).toLocaleString('id-ID')}</span>
                                                </div>
                                                <p className="text-sm text-slate-700 dark:text-slate-300">{prog.keterangan}</p>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <p className="text-sm text-slate-500 text-center py-4">Belum ada progres yang dicatat.</p>
                                )}
                            </div>
                        </div>

                        {/* Kolom Kanan: Actions */}
                        <div className="space-y-6">
                            
                            {/* Panel Admin / PIC */}
                            {(can.monitor_all || tiket.pic_id === auth.user.id) && tiket.status !== 'Selesai' && (
                                <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-800 p-6">
                                    <h4 className="text-base font-bold text-slate-900 dark:text-white mb-4">Pengaturan Tiket</h4>
                                    
                                    <form onSubmit={handleUpdate} className="space-y-4">
                                        {can.monitor_all && (
                                            <div>
                                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tugaskan PIC</label>
                                                <select
                                                    value={updateData.pic_id}
                                                    onChange={e => setUpdateData('pic_id', e.target.value)}
                                                    className="w-full px-3 py-2 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-slate-900 dark:text-white text-sm"
                                                >
                                                    <option value="">Pilih Teknisi/PIC</option>
                                                    {pics && pics.map(p => (
                                                        <option key={p.id} value={p.id}>{p.name} ({p.unit})</option>
                                                    ))}
                                                </select>
                                            </div>
                                        )}

                                        <div>
                                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ubah Status</label>
                                            <select
                                                value={updateData.status}
                                                onChange={e => setUpdateData('status', e.target.value)}
                                                className="w-full px-3 py-2 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-slate-900 dark:text-white text-sm"
                                            >
                                                <option value="New">New</option>
                                                <option value="Proses">Proses</option>
                                                <option value="Selesai">Selesai</option>
                                                <option value="Spam">Spam</option>
                                            </select>
                                        </div>

                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="w-full justify-center inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-sm font-medium rounded-xl transition-all shadow-sm"
                                        >
                                            Simpan Perubahan
                                        </button>
                                    </form>
                                </div>
                            )}

                            {/* Info Handling */}
                            <div className="bg-surface-50 dark:bg-surface-800/50 rounded-2xl border border-surface-200 dark:border-surface-800 p-6">
                                <h4 className="text-base font-bold text-slate-900 dark:text-white mb-4">Informasi Penanganan</h4>
                                
                                <div className="space-y-3 text-sm">
                                    <div className="flex justify-between">
                                        <span className="text-slate-500">Admin</span>
                                        <span className="font-medium text-slate-900 dark:text-white">{tiket.admin?.name || '-'}</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-slate-500">PIC / Teknisi</span>
                                        <span className="font-medium text-slate-900 dark:text-white">{tiket.pic?.name || 'Belum ada'}</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-slate-500">Waktu Proses</span>
                                        <span className="font-medium text-slate-900 dark:text-white">
                                            {tiket.waktu_proses ? new Date(tiket.waktu_proses).toLocaleString('id-ID') : '-'}
                                        </span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-slate-500">Waktu Selesai</span>
                                        <span className="font-medium text-slate-900 dark:text-white">
                                            {tiket.waktu_close ? new Date(tiket.waktu_close).toLocaleString('id-ID') : '-'}
                                        </span>
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
