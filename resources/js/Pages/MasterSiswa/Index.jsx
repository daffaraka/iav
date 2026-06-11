import React, { useMemo } from 'react';
import { usePage, Link, Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DataTable from '@/Components/DataTable';
import { Toaster } from 'react-hot-toast';

export default function Index() {
    const { siswa } = usePage().props;

    const columns = useMemo(
        () => [
            {
                header: 'NIS',
                accessorKey: 'nis',
            },
            {
                header: 'Nama',
                accessorKey: 'nama',
            },
            {
                header: 'Kelas',
                accessorKey: 'kelas',
                cell: ({ row }) => (
                    <span>
                        {row.original.kelas} {row.original.sub_kelas}
                    </span>
                )
            },
            {
                header: 'Jenis Kelamin',
                accessorKey: 'jenis_kelamin',
            },
            {
                header: 'Aksi',
                id: 'actions',
                cell: ({ row }) => (
                    <div className="flex items-center gap-2">
                        <a
                            href={`/siswa/${row.original.id}/qrcode`}
                            className="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-brand-500 hover:bg-brand-600 text-white rounded-lg transition-colors"
                        >
                            <i className="ph ph-qr-code text-sm"></i>
                            Download QR
                        </a>
                    </div>
                ),
            },
        ],
        []
    );

    return (
        <AuthenticatedLayout>
            <Head title="Master Siswa" />
            <Toaster />
            <div className="flex flex-col gap-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-800 dark:text-slate-100">
                            Data Master Siswa
                        </h1>
                        <p className="text-slate-500 dark:text-slate-400 mt-1">
                            Manajemen data siswa dan cetak QR Code Penjemputan
                        </p>
                    </div>
                </div>

                <div className="bg-white dark:bg-surface-800 p-6 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700">
                    <DataTable
                        data={siswa}
                        columns={columns}
                        searchable={true}
                        searchPlaceholder="Cari nama atau NIS..."
                    />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
