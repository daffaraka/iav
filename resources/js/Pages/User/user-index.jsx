import React, { useState, useMemo } from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout";
import DataTable from "../../Components/DataTable";
import ConfirmModal from "../../Components/ConfirmModal";

export default function UserIndex({ users, title }) {
    const { delete: destroy } = useForm();
    const [confirmModal, setConfirmModal] = useState({
        isOpen: false,
        id: null,
    });

    const handleDelete = (id) => {
        setConfirmModal({ isOpen: true, id });
    };

    const confirmDelete = () => {
        destroy(`/user/${confirmModal.id}`);
        setConfirmModal({ isOpen: false, id: null });
    };

    const columns = useMemo(
        () => [
            {
                accessorKey: "kode_karyawan",
                header: "Kode Karyawan",
                cell: (info) => info.getValue() || "-",
            },
            {
                accessorKey: "name",
                header: "Nama",
                cell: (info) => (
                    <div className="text-sm font-semibold text-slate-800 dark:text-white">
                        {info.getValue()}
                    </div>
                ),
            },
            {
                accessorKey: "email",
                header: "Email",
            },
            {
                accessorKey: "jabatan",
                header: "Jabatan",
                cell: (info) => {
                    const val = info.getValue();
                    if (!val) return "-";
                    const lowerVal = val.toLowerCase();
                    let colorClass = 'bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300';
                    if (lowerVal.includes('kepala sekolah')) colorClass = 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400';
                    else if (lowerVal.includes('wakil')) colorClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400';
                    else if (lowerVal.includes('guru')) colorClass = 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400';
                    else if (lowerVal.includes('admin')) colorClass = 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400';
                    return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-medium ${colorClass}`}>{val}</span>;
                },
            },
            {
                accessorKey: "departemen",
                header: "Departemen",
                cell: (info) => {
                    const val = info.getValue();
                    if (!val) return "-";
                    const jabatan = (info.row.original.jabatan || "").toLowerCase();
                    let colorClass = 'border-surface-300 text-surface-700 dark:border-surface-500/40 dark:text-surface-300';
                    if (jabatan.includes('kepala sekolah')) colorClass = 'border-blue-400 text-blue-700 dark:border-blue-500/40 dark:text-blue-400';
                    else if (jabatan.includes('wakil')) colorClass = 'border-emerald-400 text-emerald-700 dark:border-emerald-500/40 dark:text-emerald-400';
                    else if (jabatan.includes('guru')) colorClass = 'border-cyan-400 text-cyan-700 dark:border-cyan-500/40 dark:text-cyan-400';
                    else if (jabatan.includes('admin')) colorClass = 'border-red-400 text-red-700 dark:border-red-500/40 dark:text-red-400';
                    return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-medium border bg-transparent ${colorClass}`}>{val}</span>;
                },
            },
            {
                accessorKey: "unit",
                header: "Unit",
                cell: (info) => {
                    const val = info.getValue();
                    if (!val) return "-";
                    const lowerVal = val.toLowerCase();
                    let colorClass = 'bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300';
                    if(lowerVal == 'jagakarsa') colorClass = 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400';
                    if(lowerVal == 'pamulang') colorClass = 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400';
                    if(lowerVal == 'cinere') colorClass = 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400';
                    if(lowerVal == 'bps') colorClass = 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400';
                    return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-medium ${colorClass}`}>{val}</span>;
                },
            },
            {
                accessorKey: "jenjang",
                header: "Jenjang",
                cell: (info) => {
                    const val = info.getValue();
                    if (!val) return "-";
                    let colorClass = 'border-indigo-200 bg-indigo-50 text-indigo-700 dark:border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-400';
                    if(val == 'TK' || val == 'KB') colorClass = 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-400';
                    if(val == 'SD') colorClass = 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400';
                    if(val == 'SMP') colorClass = 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400';
                    if(val == 'SMA') colorClass = 'border-red-200 bg-red-50 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400';
                    return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-medium border ${colorClass}`}>{val}</span>;
                },
            },
            {
                accessorKey: "roles",
                header: "Role",
                cell: (info) => {
                    const roles = info.getValue() || [];
                    return (
                        <div className="flex flex-wrap gap-1">
                            {roles.map((role) => (
                                <span
                                    key={role.id}
                                    className="inline-flex px-2 py-0.5 rounded bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300 text-xs font-semibold"
                                >
                                    {role.name}
                                </span>
                            ))}
                        </div>
                    );
                },
            },
            {
                id: "wali_kelas",
                header: "Wali Kelas",
                cell: (info) => {
                    const user = info.row.original;
                    const isGuru =
                        user.roles &&
                        user.roles.some(
                            (r) => r.name === "guru" || r.name === "wali-kelas",
                        );
                    if (isGuru) {
                        return (
                            <span className="inline-flex px-2 py-1 rounded border border-danger-200 text-danger-700 dark:border-danger-500/30 dark:text-danger-400 text-xs font-semibold">
                                {(user.kelas || "") + (user.sub_kelas || "")}
                            </span>
                        );
                    }
                    return "-";
                },
            },
            {
                id: "aksi",
                header: "Aksi",
                cell: (info) => {
                    const user = info.row.original;
                    return (
                        <div className="flex items-center gap-2">
                            <Link
                                href={`/user/${user.id}`}
                                className="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-colors"
                                title="Detail"
                            >
                                <i className="ph ph-eye text-lg"></i>
                            </Link>
                            <Link
                                href={`/user/${user.id}/edit`}
                                className="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg transition-colors"
                                title="Edit"
                            >
                                <i className="ph ph-pencil-simple text-lg"></i>
                            </Link>
                            <button
                                onClick={() => handleDelete(user.id)}
                                className="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors"
                                title="Hapus"
                            >
                                <i className="ph ph-trash text-lg"></i>
                            </button>
                        </div>
                    );
                },
            },
        ],
        [],
    );

    return (
        <AuthenticatedLayout>
            <Head title={title || "Manajemen User"} />

            <div className="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">
                        {title || "Manajemen User"}
                    </h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">
                        Kelola pengguna dan hak akses sistem
                    </p>
                </div>
                <Link
                    href="/user/create"
                    className="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-plus mr-2"></i>
                    Tambah User
                </Link>
            </div>

            <DataTable columns={columns} data={users || []} />

            <ConfirmModal
                isOpen={confirmModal.isOpen}
                onClose={() => setConfirmModal({ isOpen: false, id: null })}
                onConfirm={confirmDelete}
                title="Hapus User?"
                message="Data user yang dihapus tidak dapat dikembalikan."
            />
        </AuthenticatedLayout>
    );
}
