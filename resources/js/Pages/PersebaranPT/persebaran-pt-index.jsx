import React, { useState, useMemo } from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout";
import DataTable from "../../Components/DataTable";
import Alert from "../../Components/Alert";
import ConfirmModal from "../../Components/ConfirmModal";
import Chart from "react-apexcharts";

export default function PtIndex({ persebarans, charts, flash = {} }) {
    const { delete: destroy } = useForm();
    const [confirmModal, setConfirmModal] = useState({
        isOpen: false,
        id: null,
    });

    const handleDelete = (id) => {
        setConfirmModal({ isOpen: true, id });
    };

    const confirmDelete = () => {
        if (confirmModal.id) {
            destroy(`/persebaran-ptn/${confirmModal.id}`, {
                preserveScroll: true,
                onSuccess: () => setConfirmModal({ isOpen: false, id: null }),
            });
        }
    };

    const columns = useMemo(
        () => [
            {
                accessorKey: "siswa.nama",
                header: "Nama Siswa",
                cell: (info) => (
                    <div className="font-medium text-slate-800 dark:text-slate-200">
                        {info.getValue() || "-"}
                    </div>
                ),
            },
            {
                accessorKey: "ptn.nama_pt",
                header: "Perguruan Tinggi",
                cell: (info) => (
                    <div className="font-semibold text-emerald-600 dark:text-emerald-400">
                        {info.getValue() || "-"}
                    </div>
                ),
            },
            {
                accessorKey: "fakultas",
                header: "Fakultas",
                cell: (info) => info.getValue() || "-",
            },
            {
                accessorKey: "jurusan",
                header: "Jurusan / Prodi",
                cell: (info) => {
                    const jurusan = info.getValue();
                    const prodi = info.row.original.program_studi;
                    if (jurusan && prodi) return `${jurusan} - ${prodi}`;
                    return jurusan || prodi || "-";
                },
            },
            {
                accessorKey: "rumpun_ilmu",
                header: "Rumpun Ilmu",
                cell: (info) => {
                    const val = info.getValue();
                    if (!val) return "-";

                    let colorClass =
                        "bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700";
                    if (val === "Saintek") {
                        colorClass =
                            "bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border-blue-200 dark:border-blue-800/50";
                    } else if (val === "Soshum") {
                        colorClass =
                            "bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 border-rose-200 dark:border-rose-800/50";
                    } else if (val === "Campuran") {
                        colorClass =
                            "bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 border-purple-200 dark:border-purple-800/50";
                    }

                    return (
                        <span
                            className={`px-2 py-1 rounded-md text-xs font-medium border ${colorClass}`}
                        >
                            {val}
                        </span>
                    );
                },
            },
            {
                accessorKey: "jalur_masuk",
                header: "Jalur Masuk",
                cell: (info) => {
                    const val = info.getValue();
                    if (!val) return "-";
                    return (
                        <span className="px-2 py-1 bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 rounded-md text-xs font-medium border border-indigo-200 dark:border-indigo-800/50">
                            {val}
                        </span>
                    );
                },
            },
            {
                id: "actions",
                header: "Aksi",
                cell: (info) => (
                    <div className="flex items-center gap-2">
                        <Link
                            href={`/persebaran-ptn/${info.row.original.id}/edit`}
                            className="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors"
                            title="Edit Data"
                        >
                            <i className="ph ph-pencil-simple text-lg"></i>
                        </Link>
                        <button
                            onClick={() => handleDelete(info.row.original.id)}
                            className="p-2 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-lg transition-colors"
                            title="Hapus Data"
                        >
                            <i className="ph ph-trash text-lg"></i>
                        </button>
                    </div>
                ),
            },
        ],
        [],
    );

    return (
        <AuthenticatedLayout>
            <Head title="Persebaran PTN/PTS" />

            <div className="">
                <div className="max-w-7xl mx-auto">
                    <div className="flex justify-between items-center mb-6">
                        <div>
                            <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                                Data Persebaran PTN/PTS
                            </h1>
                            <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                Kelola data persebaran siswa ke berbagai
                                Perguruan Tinggi
                            </p>
                        </div>
                        <Link
                            href="/persebaran-ptn/create"
                            className="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-xl transition-colors shadow-sm shadow-emerald-500/20"
                        >
                            <i className="ph ph-plus-circle text-lg"></i>
                            Tambah Data
                        </Link>
                    </div>

                    {flash.success && (
                        <Alert
                            type="success"
                            message={flash.success}
                            className="mb-6"
                        />
                    )}
                    {flash.error && (
                        <Alert
                            type="error"
                            message={flash.error}
                            className="mb-6"
                        />
                    )}

                    {charts && (
                        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                            {/* Chart 1: Status PT */}
                            <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-slate-200 dark:border-surface-800 p-5">
                                <h3 className="text-sm font-bold text-slate-800 dark:text-slate-200 mb-4">
                                    Tipe Perguruan Tinggi
                                </h3>
                                <Chart
                                    options={{
                                        labels: Object.keys(
                                            charts.statusPt || {},
                                        ),
                                        colors: [
                                            "#10b981",
                                            "#f59e0b",
                                            "#3b82f6",
                                        ],
                                        legend: { position: "bottom" },
                                        chart: { background: "transparent" },
                                        theme: { mode: "light" },
                                        dataLabels: {
                                            formatter: function (val, opts) {
                                                return opts.w.config.series[opts.seriesIndex];
                                            }
                                        }
                                    }}
                                    series={
                                        Object.keys(charts.statusPt || {}).length > 0 
                                            ? Object.values(charts.statusPt).map(v => Number(v)) 
                                            : []
                                    }
                                    type="donut"
                                    height={250}
                                />
                            </div>

                            {/* Chart 2: Jalur Masuk */}
                            <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-slate-200 dark:border-surface-800 p-5">
                                <h3 className="text-sm font-bold text-slate-800 dark:text-slate-200 mb-4">
                                    Jalur Masuk
                                </h3>
                                <Chart 
                                    options={{
                                        labels: Object.keys(charts.jalurMasuk || {}),
                                        colors: ['#6366f1', '#10b981', '#f43f5e', '#f59e0b', '#8b5cf6'],
                                        legend: { position: 'bottom' },
                                        chart: { background: 'transparent' },
                                        theme: { mode: 'light' },
                                        dataLabels: {
                                            formatter: function (val, opts) {
                                                return opts.w.config.series[opts.seriesIndex];
                                            }
                                        }
                                    }} 
                                    series={Object.values(charts.jalurMasuk || {}).map(v => Number(v))} 
                                    type="donut" 
                                    height={250} 
                                />
                            </div>

                            {/* Chart 3: Top 10 PTN */}
                            <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-slate-200 dark:border-surface-800 p-5 xl:col-span-2">
                                <h3 className="text-sm font-bold text-slate-800 dark:text-slate-200 mb-4">
                                    Top 10 Perguruan Tinggi
                                </h3>
                                <Chart 
                                    options={{
                                        labels: Object.keys(charts.topPtn || {}),
                                        colors: ['#10b981', '#3b82f6', '#f59e0b', '#f43f5e', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6', '#84cc16', '#6366f1'],
                                        legend: { position: 'right' },
                                        chart: { background: 'transparent' },
                                        theme: { mode: 'light' },
                                        dataLabels: { 
                                            enabled: true,
                                            formatter: function (val, opts) {
                                                return opts.w.config.series[opts.seriesIndex];
                                            }
                                        }
                                    }} 
                                    series={Object.values(charts.topPtn || {}).map(v => Number(v))} 
                                    type="pie" 
                                    height={250} 
                                />
                            </div>

                            {/* Chart 4: Provinsi */}
                            <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-slate-200 dark:border-surface-800 p-5 xl:col-span-4">
                                <h3 className="text-sm font-bold text-slate-800 dark:text-slate-200 mb-4">
                                    Persebaran Provinsi
                                </h3>
                                <Chart
                                    options={{
                                        xaxis: {
                                            categories: Object.keys(
                                                charts.provinsi || {},
                                            ),
                                        },
                                        colors: ["#ec4899"],
                                        chart: {
                                            toolbar: { show: false },
                                            background: "transparent",
                                        },
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 4,
                                                columnWidth: "40%",
                                            },
                                        },
                                        dataLabels: { enabled: false },
                                    }}
                                    series={[
                                        {
                                            name: "Siswa",
                                            data: Object.values(
                                                charts.provinsi || {},
                                            ),
                                        },
                                    ]}
                                    type="bar"
                                    height={250}
                                />
                            </div>
                        </div>
                    )}

                    <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-slate-200 dark:border-surface-800">
                        <div className="p-6">
                            <DataTable
                                data={persebarans}
                                columns={columns}
                                searchable={true}
                            />
                        </div>
                    </div>
                </div>
            </div>

            <ConfirmModal
                isOpen={confirmModal.isOpen}
                onClose={() => setConfirmModal({ isOpen: false, id: null })}
                onConfirm={confirmDelete}
                title="Hapus Data"
                message="Apakah Anda yakin ingin menghapus data persebaran ini? Tindakan ini tidak dapat dibatalkan."
            />
        </AuthenticatedLayout>
    );
}
