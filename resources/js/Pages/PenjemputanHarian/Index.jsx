import React, { useEffect, useState, useMemo } from 'react';
import { usePage, router, Link, Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DataTable from '@/Components/DataTable';
import dayjs from 'dayjs';
import toast, { Toaster } from 'react-hot-toast';

export default function Index() {
    const { penjemputan, auth } = usePage().props;
    const userRole = auth.user.roles?.[0]?.name || auth.user.role; // Handle spatie or direct string

    const [isModalOpen, setIsModalOpen] = useState(false);
    const [selectedPenjemput, setSelectedPenjemput] = useState(null);
    const [typeOjol, setTypeOjol] = useState('');

    const [tableData, setTableData] = useState(penjemputan || []);

    useEffect(() => {
        setTableData(penjemputan || []);
    }, [penjemputan]);

    useEffect(() => {
        if (window.Echo) {
            const channel = window.Echo.channel('apus-notification');
            channel.listen('.notifikasi-penjemputan', (eventData) => {
                console.log('Realtime Event Received:', eventData);
                
                if (auth.user.kelas && eventData.kelas === auth.user.kelas) {
                    toast.success(eventData.notifikasi || 'Penjemputan Terbaru', {
                        duration: 5000,
                        position: 'top-right',
                    });
                }
                
                axios.get('/reload-penjemputan', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => {
                        if (response.data && response.data.data) {
                            setTableData(response.data.data);
                        }
                    });
            });

            return () => {
                window.Echo.leaveChannel('apus-notification');
            };
        }
    }, [auth.user.kelas]);

    const handleNullPenjemputan = (e) => {
        e.preventDefault();
        router.get('/null-penjemputan', {}, {
            preserveScroll: true,
            onSuccess: () => toast.success('Penjemputan berhasil dihapus')
        });
    };

    const handleGenerate = (e) => {
        e.preventDefault();
        router.get('/generate-harian', {}, {
            preserveScroll: true,
            onSuccess: () => toast.success('Penjemputan hari ini berhasil ditambahkan')
        });
    };

    const handleConfirmOjol = (e) => {
        e.preventDefault();
        router.post('/penjemputan-harian/satpam-konfirmasi-ojol', {
            penjemputan_id: selectedPenjemput?.id,
            nis: selectedPenjemput?.siswa?.nis,
            ojol: 'ojol',
            type_ojol: typeOjol
        }, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Satpam telah mengkonfirmasi');
                setIsModalOpen(false);
                setTypeOjol('');
            }
        });
    };

    const openOjolModal = (penjemput) => {
        setSelectedPenjemput(penjemput);
        setIsModalOpen(true);
    };

    const columns = useMemo(() => [
        {
            accessorKey: 'siswa.nama',
            header: 'Siswa',
            cell: info => info.getValue() ?? '-'
        },
        {
            accessorKey: 'siswa.kelas',
            header: 'Kelas',
            cell: info => info.getValue() ?? '-'
        },
        {
            accessorKey: 'waktu_dijemput',
            header: 'Jam Penjemput Datang',
            cell: info => info.getValue() ? dayjs(info.getValue()).format('HH:mm') : '-'
        },
        {
            accessorKey: 'confirm_pic_at',
            header: 'Confirm Wali Kelas',
            cell: info => info.getValue() ? dayjs(info.getValue()).format('HH:mm') : '-'
        },
        {
            accessorKey: 'confirm_satpam_at',
            header: 'Confirm Satpam',
            cell: info => info.getValue() ? dayjs(info.getValue()).format('HH:mm') : '-'
        },
        {
            id: 'actions',
            header: 'Action',
            cell: ({ row }) => {
                const penjemput = row.original;
                const isAdmin = userRole === 'admin' || userRole === 'super-admin';
                const isSatpam = userRole === 'satpam' || isAdmin;
                const isGuru = userRole === 'guru' || userRole === 'walikelas' || isAdmin;

                if (!penjemput.waktu_dijemput) {
                    if (isSatpam) {
                        return (
                            <div className="flex flex-wrap gap-2">
                                <Link 
                                    href={`/penjemputan-harian/satpam-konfirmasi-kedatangan/${penjemput.id}`} 
                                    className="px-3 py-1.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-lg transition-colors inline-block whitespace-nowrap"
                                    preserveScroll
                                >
                                    Konfirmasi Kedatangan
                                </Link>
                                <button 
                                    onClick={() => openOjolModal(penjemput)} 
                                    className="px-3 py-1.5 bg-surface-200 hover:bg-surface-300 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 text-sm font-medium rounded-lg transition-colors whitespace-nowrap"
                                >
                                    Penjemput Lain
                                </button>
                            </div>
                        );
                    }
                    return <span className="text-slate-500 dark:text-slate-400 text-sm font-medium">Menunggu Kedatangan</span>;
                }

                if (penjemput.waktu_dijemput && !penjemput.confirm_pic_at) {
                    if (isGuru) {
                        return (
                            <Link 
                                href={`/penjemputan-harian/guru-konfirmasi/${penjemput.id}`}
                                className="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors inline-block whitespace-nowrap"
                                preserveScroll
                            >
                                Konfirmasi Dijemput (Guru)
                            </Link>
                        );
                    }
                    return <span className="text-slate-500 dark:text-slate-400 text-sm font-medium">Menunggu Konfirmasi Guru</span>;
                }

                if (penjemput.waktu_dijemput && penjemput.confirm_pic_at && !penjemput.confirm_satpam_at) {
                    if (isSatpam) {
                        return (
                            <Link 
                                href={`/penjemputan-harian/satpam-konfirmasi-keluar/${penjemput.id}`}
                                className="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition-colors inline-block whitespace-nowrap"
                                preserveScroll
                            >
                                Siswa Sudah Keluar Area
                            </Link>
                        );
                    }
                    return <span className="text-slate-500 dark:text-slate-400 text-sm font-medium">Menunggu Konfirmasi Satpam</span>;
                }

                if (penjemput.waktu_dijemput && penjemput.confirm_pic_at && penjemput.confirm_satpam_at) {
                    return <span className="px-3 py-1.5 bg-green-500 text-white text-sm font-medium rounded-lg flex w-fit items-center gap-2 whitespace-nowrap"><i className="ph ph-check-circle"></i> Sudah Pulang</span>;
                }

                return null;
            }
        }
    ], [userRole]);

    return (
        <AuthenticatedLayout>
            <Head title="Penjemputan Harian" />
            <Toaster />
            
            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-slate-100">
                        Data Penjemputan Hari Ini
                    </h1>
                    <p className="text-slate-500 dark:text-slate-400 mt-1">
                        Daftar siswa dijemput kelas {auth.user.kelas || 'Semua Kelas'}
                    </p>
                </div>
                
                <div className="flex gap-2">
                    <button 
                        onClick={handleNullPenjemputan}
                        className="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2"
                    >
                        <i className="ph ph-trash"></i> Null Penjemputan
                    </button>
                    <button 
                        onClick={handleGenerate}
                        className="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white font-medium rounded-xl shadow-sm transition-colors flex items-center gap-2"
                    >
                        <i className="ph ph-arrows-clockwise"></i> Generate Hari Ini
                    </button>
                </div>
            </div>

            <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700">
                <DataTable columns={columns} data={tableData || []} searchable={true} />
            </div>

            {/* Modal Ojol */}
            {isModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
                        <div className="flex justify-between items-center p-5 border-b border-surface-200 dark:border-surface-700">
                            <h3 className="text-lg font-semibold text-slate-800 dark:text-slate-100">Konfirmasi Penjemput Lain</h3>
                            <button onClick={() => setIsModalOpen(false)} className="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                <i className="ph ph-x text-xl"></i>
                            </button>
                        </div>
                        
                        <form onSubmit={handleConfirmOjol} className="p-5 space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Siswa</label>
                                <input type="text" disabled value={selectedPenjemput?.siswa?.nama || ''} className="w-full bg-surface-100 dark:bg-surface-900 border-surface-200 dark:border-surface-700 rounded-lg px-4 py-2 text-slate-500" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kelas</label>
                                <input type="text" disabled value={selectedPenjemput?.siswa?.kelas || ''} className="w-full bg-surface-100 dark:bg-surface-900 border-surface-200 dark:border-surface-700 rounded-lg px-4 py-2 text-slate-500" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pilih Penjemput</label>
                                <select 
                                    required
                                    value={typeOjol}
                                    onChange={(e) => setTypeOjol(e.target.value)}
                                    className="w-full bg-white dark:bg-surface-900 border-surface-300 dark:border-surface-600 rounded-lg px-4 py-2 text-slate-700 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                                >
                                    <option value="">Pilih</option>
                                    <option value="Kerabat&Keluarga">Kerabat/Keluarga</option>
                                    <option value="Ojol">Ojek Online</option>
                                    <option value="Taxi Online">Taxi Online</option>
                                </select>
                            </div>
                            
                            <div className="flex justify-end gap-3 pt-4 border-t border-surface-200 dark:border-surface-700 mt-6">
                                <button type="button" onClick={() => setIsModalOpen(false)} className="px-4 py-2 text-slate-600 dark:text-slate-300 font-medium hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-colors">Batal</button>
                                <button type="submit" className="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white font-medium rounded-lg shadow-sm transition-colors">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

        </AuthenticatedLayout>
    );
}
