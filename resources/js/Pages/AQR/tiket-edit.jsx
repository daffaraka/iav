import React, { useState, useMemo, useEffect } from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout";
import { useTheme } from "../../Contexts/ThemeContext";
import { format } from "date-fns";
import { id } from "date-fns/locale";
import axios from "axios";

export default function TiketEdit({
    tiket,
    picSelect,
    userRoles,
    currentUser,
}) {
    const { isDarkMode } = useTheme();
    const [isForwardKepsekModalOpen, setForwardKepsekModalOpen] =
        useState(false);
    const [isForwardTUModalOpen, setForwardTUModalOpen] = useState(false);
    const [isPICModalOpen, setPICModalOpen] = useState(false);

    // AI Form
    const { post: postAi, processing: aiProcessing } = useForm({});

    // Update Form (For penanganan and initial PIC assign)
    const {
        data: updateData,
        setData: setUpdateData,
        post: postUpdate,
        processing: updateProcessing,
        errors: updateErrors,
    } = useForm({
        _method: "PUT",
        departemen: tiket.departemen || "",
        pic_menanggapi: tiket.pic_id || "",
        penanganan: "",
        fotopengerjaan: null,
    });

    // Forward Form
    const {
        data: forwardData,
        setData: setForwardData,
        post: postForward,
        processing: forwardProcessing,
    } = useForm({
        tiket_id: tiket.id,
        pic_id: "",
        forward_type: "",
        catatan: "",
    });

    // Helpers to check roles
    const hasRole = (rolesToCheck) => {
        if (!userRoles) return false;
        if (typeof rolesToCheck === "string")
            return userRoles.includes(rolesToCheck);
        return rolesToCheck.some((r) => userRoles.includes(r));
    };

    const isSuperAdminOrHumas = hasRole(["super-admin", "humas"]);
    const isPimpinan = hasRole([
        "super-admin",
        "humas",
        "admin",
        "kepala-sekolah",
        "kepala-tata-usaha",
    ]);
    const isPic = currentUser.id === tiket.pic_id;
    const isWargaSekolah = tiket.pengirim === "Warga Sekolah";
    const status = tiket.status;

    // Derived PIC Lists for Modals
    const listKepsek = useMemo(
        () =>
            picSelect.filter(
                (p) =>
                    p.jabatan &&
                    p.jabatan.toLowerCase().includes("kepala sekolah"),
            ),
        [picSelect],
    );
    const listTU = useMemo(
        () =>
            picSelect.filter(
                (p) =>
                    p.jabatan && p.jabatan.toLowerCase().includes("tata usaha"),
            ),
        [picSelect],
    );

    // Dynamic PIC Dropdown States
    const [filteredPics, setFilteredPics] = useState([]);
    const [isLoadingPics, setIsLoadingPics] = useState(false);

    const fetchPicsByDept = async (departemen) => {
        if (!departemen) {
            setFilteredPics([]);
            return;
        }
        setIsLoadingPics(true);
        try {
            const response = await axios.post("/helpdesk/get-pic-by-dept", {
                departemen,
            });
            setFilteredPics(response.data);
        } catch (error) {
            console.error("Error fetching PICs by department:", error);
        } finally {
            setIsLoadingPics(false);
        }
    };

    useEffect(() => {
        fetchPicsByDept(updateData.departemen);
    }, [updateData.departemen]);

    const handleAiAnalyze = (e) => {
        e.preventDefault();
        postAi(`/dashboard/aqr/analytics/analyze/${tiket.id}`);
    };

    const handleUpdate = (e) => {
        e.preventDefault();
        postUpdate(`/dashboard/aqr/tiket/${tiket.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                setUpdateData("penanganan", "");
                setUpdateData("fotopengerjaan", null);
                setPICModalOpen(false);
            },
        });
    };

    const handleForward = (e, type) => {
        e.preventDefault();
        postForward(`/dashboard/aqr/tiket/forward`, {
            preserveScroll: true,
            onSuccess: () => {
                setForwardKepsekModalOpen(false);
                setForwardTUModalOpen(false);
                setForwardData("catatan", "");
                setForwardData("pic_id", "");
            },
        });
    };

    const openForwardModal = (type) => {
        setForwardData("forward_type", type);
        setForwardData("pic_id", "");
        setForwardData("catatan", "");
        if (type === "kepala-sekolah") setForwardKepsekModalOpen(true);
        if (type === "kepala-tu") setForwardTUModalOpen(true);
    };

    const getStatusColor = (statusText) => {
        if (statusText === "New") return "bg-blue-500";
        if (statusText === "Proses") return "bg-amber-500";
        return "bg-emerald-500";
    };

    return (
        <AuthenticatedLayout>
            <Head title={`Tiket ${tiket.no_tiket}`} />

            {/* Header */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <div className="flex items-center gap-3 mb-1">
                        <Link
                            href="/dashboard/aqr/tiket"
                            className="text-slate-400 hover:text-brand-500 transition-colors"
                        >
                            <i className="ph ph-arrow-left text-xl"></i>
                        </Link>
                        <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                            Detail Tiket
                        </h1>
                    </div>
                    <p className="text-sm text-slate-500 dark:text-slate-300 ml-8">
                        #{tiket.no_tiket}
                    </p>
                </div>
                <div className="flex items-center gap-3">
                    {!tiket.ai_analyzed_at ? (
                        <button
                            onClick={handleAiAnalyze}
                            disabled={aiProcessing}
                            className="px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-indigo-500/30 hover:opacity-90 transition-all flex items-center disabled:opacity-50"
                        >
                            <i className="ph ph-magic-wand mr-2 text-lg"></i>
                            {aiProcessing
                                ? "Menganalisis..."
                                : "Analisis dengan AI"}
                        </button>
                    ) : (
                        <span className="px-3 py-1.5 bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 rounded-lg text-sm font-medium flex items-center border border-emerald-200 dark:border-emerald-500/20">
                            <i className="ph ph-check-circle mr-1.5 text-lg"></i>
                            Dianalisis AI
                        </span>
                    )}
                </div>
            </div>

            <div className="space-y-6">
                {/* Full Width - Detail Tiket */}
                <div className="w-full">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden transition-colors duration-300">
                        <div className="border-b border-surface-100 dark:border-surface-700 p-6 flex justify-between items-start">
                            <div>
                                <h2 className="text-lg font-bold text-slate-800 dark:text-white">
                                    Informasi Laporan
                                </h2>
                                <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                    Disubmit pada{" "}
                                    {format(
                                        new Date(tiket.created_at),
                                        "d MMMM yyyy, HH:mm",
                                        { locale: id },
                                    )}
                                </p>
                            </div>
                            <span
                                className={`inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white ${getStatusColor(status)}`}
                            >
                                {status}
                            </span>
                        </div>
                        <div className="p-6 space-y-5">
                            {/* Type Pengirim & Kategori */}
                            <div>
                                <strong>
                                    <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                        Type Pengirim
                                    </label>
                                </strong>
                                <div className="flex flex-wrap gap-2">
                                    <span
                                        className={`inline-flex px-3 py-1.5 rounded-lg text-sm font-semibold text-white ${tiket.pengirim === "Masyarakat Umum" ? "bg-blue-600" : "bg-amber-500"}`}
                                    >
                                        {tiket.pengirim}
                                    </span>

                                    {tiket.pengirim === "Warga Sekolah" &&
                                        tiket.option && (
                                            <>
                                                <span
                                                    className={`inline-flex px-3 py-1.5 rounded-lg text-sm font-semibold text-white ${tiket.option.kategori_pic === "Kepala Sekolah" ? "bg-amber-500" : "bg-red-600"}`}
                                                >
                                                    {tiket.option.kategori_pic}
                                                </span>
                                                <span
                                                    className={`inline-flex px-3 py-1.5 rounded-lg text-sm font-semibold text-white ${tiket.option.kategori_pic === "Kepala Sekolah" ? "bg-cyan-500" : "bg-slate-500"}`}
                                                >
                                                    {tiket.option.nama_option}
                                                </span>
                                            </>
                                        )}
                                </div>
                            </div>

                            {/* Nama */}
                            <div>
                                <strong>
                                    <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                                        Nama Lengkap
                                    </label>
                                </strong>
                                <input
                                    type="text"
                                    className="w-full bg-slate-100 dark:bg-surface-900 border border-surface-200 dark:border-surface-700 text-slate-700 dark:text-slate-200 rounded-xl text-sm px-4 py-2.5 shadow-sm focus:outline-none font-bold"
                                    value={tiket.nama}
                                    readOnly
                                />
                            </div>

                            {/* Email */}
                            <div>
                                <strong>
                                    <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                                        Email
                                    </label>
                                </strong>
                                <input
                                    type="text"
                                    className="w-full bg-slate-100 dark:bg-surface-900 border border-surface-200 dark:border-surface-700 text-slate-700 dark:text-slate-200 rounded-xl text-sm px-4 py-2.5 shadow-sm focus:outline-none font-bold"
                                    value={tiket.email || ""}
                                    readOnly
                                />
                            </div>

                            {/* Nomor Handphone */}
                            <div>
                                <strong>
                                    <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                                        Nomor Handphone
                                    </label>
                                </strong>
                                <input
                                    type="text"
                                    className="w-full bg-slate-100 dark:bg-surface-900 border border-surface-200 dark:border-surface-700 text-slate-700 dark:text-slate-200 rounded-xl text-sm px-4 py-2.5 shadow-sm focus:outline-none font-bold"
                                    value={tiket.no_hp || ""}
                                    readOnly
                                />
                            </div>

                            {/* Judul Kendala */}
                            <div>
                                <strong>
                                    <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                                        Judul Kendala
                                    </label>
                                </strong>
                                <textarea
                                    className="w-full bg-slate-100 dark:bg-surface-900 border border-surface-200 dark:border-surface-700 text-slate-700 dark:text-slate-200 rounded-xl text-sm px-4 py-2.5 shadow-sm focus:outline-none font-bold"
                                    value={tiket.judul_kendala}
                                    readOnly
                                    rows="2"
                                />
                            </div>

                            {/* Lokasi Sekolah */}
                            {tiket.pengirim === "Warga Sekolah" && (
                                <div>
                                    <strong>
                                        <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                                            Lokasi Sekolah
                                        </label>
                                    </strong>
                                    <input
                                        type="text"
                                        className="w-full bg-slate-100 dark:bg-surface-900 border border-surface-200 dark:border-surface-700 text-slate-700 dark:text-slate-200 rounded-xl text-sm px-4 py-2.5 shadow-sm focus:outline-none font-bold"
                                        value={tiket.lokasi_kendala || ""}
                                        readOnly
                                    />
                                </div>
                            )}

                            {/* Detail Kendala */}
                            <div>
                                <strong>
                                    <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                                        Detail Kendala
                                    </label>
                                </strong>
                                <textarea
                                    className="w-full bg-slate-100 dark:bg-surface-900 border border-surface-200 dark:border-surface-700 text-slate-700 dark:text-slate-200 rounded-xl text-sm px-4 py-2.5 shadow-sm focus:outline-none font-bold"
                                    value={tiket.detail_kendala}
                                    readOnly
                                    rows="4"
                                />
                            </div>

                            {/* Foto atau Screenshot masalah */}
                            <div>
                                <strong>
                                    <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                        Foto atau Screenshot masalah
                                    </label>
                                </strong>
                                {tiket.filename ? (
                                    <div>
                                        <a
                                            href={`/${tiket.filename}`}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="inline-flex items-center px-4 py-2 bg-slate-900 dark:bg-slate-700 hover:bg-slate-800 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm"
                                        >
                                            View
                                        </a>
                                    </div>
                                ) : (
                                    <span className="text-sm text-slate-400">
                                        Tidak ada lampiran
                                    </span>
                                )}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Penanganan & Riwayat (Two Columns Below) */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    {/* Left Column - Riwayat Tanggapan */}
                    <div className="lg:col-span-6 space-y-6">
                        {/* Timeline */}
                        <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden transition-colors duration-300">
                            <div className="border-b border-surface-100 dark:border-surface-700 p-6">
                                <h2 className="text-lg font-bold text-slate-800 dark:text-white flex items-center">
                                    <i className="ph ph-clock-counter-clockwise mr-2 text-slate-400"></i>
                                    Riwayat Tanggapan
                                </h2>
                            </div>
                            <div className="p-6">
                                {!tiket.progres ||
                                tiket.progres.length === 0 ? (
                                    <div className="text-center py-8">
                                        <div className="w-16 h-16 rounded-full bg-surface-50 dark:bg-surface-900 flex items-center justify-center mx-auto mb-3">
                                            <i className="ph ph-chat-teardrop-slash text-2xl text-slate-400"></i>
                                        </div>
                                        <p className="text-slate-500 dark:text-slate-400 text-sm">
                                            Belum ada riwayat tanggapan.
                                        </p>
                                    </div>
                                ) : (
                                    <div className="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-surface-200 dark:before:via-surface-700 before:to-transparent">
                                        {tiket.progres.map((prog, idx) => (
                                            <div
                                                key={prog.id}
                                                className="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active"
                                            >
                                                <div className="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-surface-800 bg-surface-100 dark:bg-surface-700 text-slate-500 dark:text-slate-400 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-sm z-10">
                                                    <i className="ph ph-chat-circle-text"></i>
                                                </div>
                                                <div className="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-2xl bg-surface-50 dark:bg-surface-900/50 border border-surface-100 dark:border-surface-700 shadow-sm">
                                                    <div className="flex items-center justify-between mb-1">
                                                        <span className="text-xs font-semibold text-brand-600 dark:text-brand-400">
                                                            {idx === 0
                                                                ? "Tanggapan Terakhir"
                                                                : "Tanggapan"}
                                                        </span>
                                                        <span className="text-xs text-slate-500 dark:text-slate-400">
                                                            {format(
                                                                new Date(
                                                                    prog.created_at,
                                                                ),
                                                                "d MMM, HH:mm",
                                                                { locale: id },
                                                            )}
                                                        </span>
                                                    </div>
                                                    <p className="text-sm text-slate-700 dark:text-slate-300 mt-2">
                                                        {prog.penanganan}
                                                    </p>
                                                    {prog.fotopengerjaan && (
                                                        <a
                                                            href={`/${prog.fotopengerjaan}`}
                                                            target="_blank"
                                                            rel="noreferrer"
                                                            className="mt-3 inline-flex items-center px-3 py-1.5 bg-surface-200 dark:bg-surface-700 text-slate-700 dark:text-slate-200 rounded-lg text-xs font-medium hover:bg-surface-300 dark:hover:bg-surface-600 transition-colors"
                                                        >
                                                            <i className="ph ph-image mr-1.5 text-base"></i>{" "}
                                                            Foto Pengerjaan
                                                        </a>
                                                    )}
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>

                    {/* Right Column - Penanganan Tiket */}
                    <div className="lg:col-span-6 space-y-6">
                        {/* Action Form */}
                        <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden transition-colors duration-300">
                            <div className="border-b border-surface-100 dark:border-surface-700 p-6 bg-brand-50/50 dark:bg-brand-500/5">
                                <h2 className="text-lg font-bold text-brand-700 dark:text-brand-400 flex items-center">
                                    <i className="ph ph-chat-circle-dots mr-2"></i>
                                    Penanganan Tiket
                                </h2>
                            </div>
                            <div className="p-6">
                                {/* Info Box */}
                                <div className="mb-6 p-4 bg-blue-50 dark:bg-blue-500/10 rounded-xl border border-blue-100 dark:border-blue-500/20 text-sm text-blue-800 dark:text-blue-300">
                                    <i className="ph ph-info mr-2"></i>
                                    {isWargaSekolah
                                        ? "Gerbang pertama tiket ini otomatis diteruskan ke Pimpinan/Kepala TU terkait."
                                        : "Tiket masyarakat umum ditangani langsung oleh tim Humas terlebih dahulu."}
                                </div>

                                <form
                                    onSubmit={handleUpdate}
                                    className="space-y-4"
                                >
                                    {status === "New" && isWargaSekolah && (
                                        <>
                                            <div>
                                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                                    Kepala Sekolah / KTU /
                                                    Psikolog (Gerbang 1)
                                                </label>
                                                <input
                                                    type="text"
                                                    className="w-full bg-surface-50 dark:bg-surface-900 border-surface-200 dark:border-surface-700 text-slate-500 rounded-xl text-sm shadow-sm"
                                                    value={
                                                        tiket.first_pic?.name ||
                                                        "Belum ditentukan"
                                                    }
                                                    disabled
                                                />
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                                    Teruskan ke Departemen
                                                </label>
                                                <select
                                                    className="w-full border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-700 dark:text-slate-200 rounded-xl text-sm focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                                                    value={
                                                        updateData.departemen
                                                    }
                                                    onChange={(e) =>
                                                        setUpdateData(
                                                            "departemen",
                                                            e.target.value,
                                                        )
                                                    }
                                                    required
                                                >
                                                    <option value="">
                                                        Pilih Departemen
                                                    </option>
                                                    <option value="Wakil Kurikulum">
                                                        Wakil Kurikulum
                                                    </option>
                                                    <option value="Wakil Kesiswaan">
                                                        Wakil Kesiswaan
                                                    </option>
                                                    <option value="Guru Kelas">
                                                        Wali Kelas
                                                    </option>
                                                    <option value="Psikolog">
                                                        Psikolog
                                                    </option>
                                                    <option value="Guru BK">
                                                        BK
                                                    </option>
                                                    <option value="Keuangan">
                                                        Keuangan
                                                    </option>
                                                    <option value="Staf Sarpra">
                                                        Sarana dan Prasarana
                                                    </option>
                                                    <option value="Tata Usaha">
                                                        Tata Usaha
                                                    </option>
                                                    <option value="Teknisi">
                                                        Teknisi
                                                    </option>
                                                    <option value="Humas">
                                                        Humas
                                                    </option>
                                                    <option value="Koperasi">
                                                        Koperasi
                                                    </option>
                                                </select>
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                                    PIC Yang Menangani
                                                </label>
                                                <select
                                                    className="w-full border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-700 dark:text-slate-200 rounded-xl text-sm focus:ring-brand-500 focus:border-brand-500 disabled:opacity-50 shadow-sm"
                                                    value={
                                                        updateData.pic_menanggapi
                                                    }
                                                    onChange={(e) =>
                                                        setUpdateData(
                                                            "pic_menanggapi",
                                                            e.target.value,
                                                        )
                                                    }
                                                    required
                                                    disabled={
                                                        !updateData.departemen ||
                                                        isLoadingPics
                                                    }
                                                >
                                                    <option value="">
                                                        {updateData.departemen
                                                            ? "Pilih PIC"
                                                            : "Pilih Departemen dulu"}
                                                    </option>
                                                    {isLoadingPics ? (
                                                        <option disabled>
                                                            Memuat PIC...
                                                        </option>
                                                    ) : (
                                                        filteredPics.map(
                                                            (pic) => (
                                                                <option
                                                                    key={pic.id}
                                                                    value={
                                                                        pic.id
                                                                    }
                                                                >
                                                                    {pic.unit} -{" "}
                                                                    {pic.jabatan ||
                                                                        pic.departemen}{" "}
                                                                    - {pic.name}
                                                                </option>
                                                            ),
                                                        )
                                                    )}
                                                </select>
                                            </div>
                                        </>
                                    )}

                                    {status === "Proses" && isPimpinan && (
                                        <div className="p-4 bg-surface-50 dark:bg-surface-900/50 rounded-xl border border-surface-100 dark:border-surface-700 mb-4 shadow-sm space-y-4">
                                            <h3 className="font-bold text-slate-800 dark:text-white mb-2">
                                                Penugasan Departemen & PIC
                                            </h3>
                                            <div>
                                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                                    Pilih Departemen Terkait
                                                </label>
                                                <select
                                                    className="w-full border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-700 dark:text-slate-200 rounded-xl text-sm focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                                                    value={
                                                        updateData.departemen
                                                    }
                                                    onChange={(e) =>
                                                        setUpdateData(
                                                            "departemen",
                                                            e.target.value,
                                                        )
                                                    }
                                                    required
                                                >
                                                    <option value="">
                                                        Pilih Departemen
                                                    </option>
                                                    <option value="Wakil Kurikulum">
                                                        Wakil Kurikulum
                                                    </option>
                                                    <option value="Wakil Kesiswaan">
                                                        Wakil Kesiswaan
                                                    </option>
                                                    <option value="Guru Kelas">
                                                        Wali Kelas
                                                    </option>
                                                    <option value="Psikolog">
                                                        Psikolog
                                                    </option>
                                                    <option value="Guru BK">
                                                        BK
                                                    </option>
                                                    <option value="Keuangan">
                                                        Keuangan
                                                    </option>
                                                    <option value="Staf Sarpra">
                                                        Sarana dan Prasarana
                                                    </option>
                                                    <option value="Tata Usaha">
                                                        Tata Usaha
                                                    </option>
                                                    <option value="Teknisi">
                                                        Teknisi
                                                    </option>
                                                    <option value="Humas">
                                                        Humas
                                                    </option>
                                                    <option value="Koperasi">
                                                        Koperasi
                                                    </option>
                                                </select>
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                                    Pilih PIC Yang Menangani
                                                </label>
                                                <select
                                                    className="w-full border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-700 dark:text-slate-200 rounded-xl text-sm focus:ring-brand-500 focus:border-brand-500 disabled:opacity-50 shadow-sm"
                                                    value={
                                                        updateData.pic_menanggapi
                                                    }
                                                    onChange={(e) =>
                                                        setUpdateData(
                                                            "pic_menanggapi",
                                                            e.target.value,
                                                        )
                                                    }
                                                    required
                                                    disabled={
                                                        !updateData.departemen ||
                                                        isLoadingPics
                                                    }
                                                >
                                                    <option value="">
                                                        {updateData.departemen
                                                            ? "Pilih PIC"
                                                            : "Pilih Departemen dulu"}
                                                    </option>
                                                    {isLoadingPics ? (
                                                        <option disabled>
                                                            Memuat PIC...
                                                        </option>
                                                    ) : (
                                                        filteredPics.map(
                                                            (pic) => (
                                                                <option
                                                                    key={pic.id}
                                                                    value={
                                                                        pic.id
                                                                    }
                                                                >
                                                                    {pic.unit} -{" "}
                                                                    {pic.jabatan ||
                                                                        pic.departemen}{" "}
                                                                    - {pic.name}
                                                                </option>
                                                            ),
                                                        )
                                                    )}
                                                </select>
                                            </div>
                                        </div>
                                    )}

                                    {status === "Proses" && !isPimpinan && (
                                        <div className="p-4 bg-surface-50 dark:bg-surface-900/50 rounded-xl border border-surface-100 dark:border-surface-700 mb-4 shadow-sm space-y-4">
                                            <div>
                                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                                    Departemen Terkait
                                                </label>
                                                <input
                                                    type="text"
                                                    className="w-full bg-slate-100 dark:bg-surface-900 border-surface-200 dark:border-surface-700 text-slate-500 rounded-xl text-sm shadow-sm font-bold"
                                                    value={
                                                        tiket.departemen || "-"
                                                    }
                                                    disabled
                                                />
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                                    PIC Saat Ini
                                                </label>
                                                <input
                                                    type="text"
                                                    className="w-full bg-slate-100 dark:bg-surface-900 border-surface-200 dark:border-surface-700 text-slate-500 rounded-xl text-sm shadow-sm font-bold"
                                                    value={
                                                        tiket.pic?.name ||
                                                        "Belum diassign"
                                                    }
                                                    disabled
                                                />
                                            </div>
                                        </div>
                                    )}

                                    {status === "Proses" &&
                                        (isPic || isSuperAdminOrHumas) && (
                                            <>
                                                <div>
                                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                                        Deskripsi Penanganan /
                                                        Pesan Baru
                                                    </label>
                                                    <textarea
                                                        rows="4"
                                                        className="w-full border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-700 dark:text-slate-200 rounded-xl text-sm focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                                                        value={
                                                            updateData.penanganan
                                                        }
                                                        onChange={(e) =>
                                                            setUpdateData(
                                                                "penanganan",
                                                                e.target.value,
                                                            )
                                                        }
                                                        placeholder="Tuliskan tindakan yang telah dilakukan..."
                                                        required
                                                    ></textarea>
                                                </div>
                                                <div>
                                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                                        Foto Bukti Penanganan
                                                        (Opsional)
                                                    </label>
                                                    <input
                                                        type="file"
                                                        accept="image/*"
                                                        onChange={(e) =>
                                                            setUpdateData(
                                                                "fotopengerjaan",
                                                                e.target
                                                                    .files[0],
                                                            )
                                                        }
                                                        className="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:file:bg-brand-500/10 dark:file:text-brand-400 shadow-sm"
                                                    />
                                                </div>
                                            </>
                                        )}

                                    {/* Form Submit Actions */}
                                    {status !== "Selesai" && (
                                        <div className="pt-4 mt-2 border-t border-surface-100 dark:border-surface-700">
                                            {((status === "New" &&
                                                isPimpinan) ||
                                                (status === "Proses" &&
                                                    (isPic ||
                                                        isSuperAdminOrHumas ||
                                                        isPimpinan))) && (
                                                <button
                                                    type="submit"
                                                    disabled={updateProcessing}
                                                    className="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-medium transition-colors disabled:opacity-50 flex justify-center items-center"
                                                >
                                                    {updateProcessing
                                                        ? "Memproses..."
                                                        : status === "New"
                                                          ? "Update Tiket"
                                                          : "Simpan Perubahan / Tanggapan"}
                                                </button>
                                            )}
                                        </div>
                                    )}
                                </form>

                                {/* Forward options for Humas (Masyarakat Umum only) */}
                                {status === "Proses" &&
                                    !isWargaSekolah &&
                                    isSuperAdminOrHumas &&
                                    !tiket.pic_id && (
                                        <div className="mt-6 pt-6 border-t border-surface-100 dark:border-surface-700">
                                            <p className="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                                Opsi Teruskan Tiket Publik:
                                            </p>
                                            <div className="flex gap-3">
                                                <button
                                                    onClick={() =>
                                                        openForwardModal(
                                                            "kepala-sekolah",
                                                        )
                                                    }
                                                    className="flex-1 py-2 bg-warning-100 text-warning-700 hover:bg-warning-200 dark:bg-warning-500/20 dark:text-warning-400 rounded-xl text-sm font-medium transition-colors"
                                                >
                                                    <i className="ph ph-user-tie mr-1.5"></i>{" "}
                                                    Ke Kepala Sekolah
                                                </button>
                                                <button
                                                    onClick={() =>
                                                        openForwardModal(
                                                            "kepala-tu",
                                                        )
                                                    }
                                                    className="flex-1 py-2 bg-info-100 text-info-700 hover:bg-info-200 dark:bg-info-500/20 dark:text-info-400 rounded-xl text-sm font-medium transition-colors"
                                                >
                                                    <i className="ph ph-user-gear mr-1.5"></i>{" "}
                                                    Ke Kepala TU
                                                </button>
                                            </div>
                                        </div>
                                    )}

                                {/* Finish Ticket Button */}
                                {status === "Proses" && (
                                    <div className="mt-4 pt-4 border-t border-surface-100 dark:border-surface-700">
                                        <Link
                                            href={`/dashboard/aqr/tiket/selesaikan/${tiket.id}`}
                                            className="w-full py-2.5 bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20 rounded-xl font-medium transition-colors flex justify-center items-center border border-red-200 dark:border-red-500/20"
                                            as="button"
                                            method="get"
                                            onBefore={() =>
                                                confirm(
                                                    "Apakah anda yakin ingin menyelesaikan tiket ini?",
                                                )
                                            }
                                        >
                                            <i className="ph ph-check-fat mr-2"></i>{" "}
                                            Tandai Tiket Selesai
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Modals for Forwarding */}
            {(isForwardKepsekModalOpen || isForwardTUModalOpen) && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
                    <div
                        className="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                        onClick={() => {
                            setForwardKepsekModalOpen(false);
                            setForwardTUModalOpen(false);
                        }}
                    ></div>

                    <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-xl w-full max-w-md transform transition-all relative z-10 border border-surface-100 dark:border-surface-700 overflow-hidden">
                        <div className="p-6 border-b border-surface-100 dark:border-surface-700">
                            <h3 className="text-lg font-bold text-slate-800 dark:text-white">
                                Teruskan ke{" "}
                                {isForwardKepsekModalOpen
                                    ? "Kepala Sekolah"
                                    : "Kepala TU"}
                            </h3>
                        </div>
                        <form onSubmit={handleForward}>
                            <div className="p-6 space-y-4">
                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Pilih Tujuan:
                                    </label>
                                    <select
                                        className="w-full border-surface-200 dark:border-surface-600 bg-surface-50 dark:bg-surface-900 text-slate-700 dark:text-slate-200 rounded-xl text-sm focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                                        value={forwardData.pic_id}
                                        onChange={(e) =>
                                            setForwardData(
                                                "pic_id",
                                                e.target.value,
                                            )
                                        }
                                        required
                                    >
                                        <option value="">-- Pilih --</option>
                                        {(isForwardKepsekModalOpen
                                            ? listKepsek
                                            : listTU
                                        ).map((p) => (
                                            <option key={p.id} value={p.id}>
                                                {p.name} - {p.unit}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Catatan (Opsional):
                                    </label>
                                    <textarea
                                        rows="3"
                                        className="w-full border-surface-200 dark:border-surface-600 bg-surface-50 dark:bg-surface-900 text-slate-700 dark:text-slate-200 rounded-xl text-sm focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                                        value={forwardData.catatan}
                                        onChange={(e) =>
                                            setForwardData(
                                                "catatan",
                                                e.target.value,
                                            )
                                        }
                                        placeholder="Tulis pesan/catatan..."
                                    ></textarea>
                                </div>
                            </div>
                            <div className="p-6 border-t border-surface-100 dark:border-surface-700 bg-surface-50 dark:bg-surface-800/50 flex justify-end gap-3">
                                <button
                                    type="button"
                                    onClick={() => {
                                        setForwardKepsekModalOpen(false);
                                        setForwardTUModalOpen(false);
                                    }}
                                    className="px-4 py-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 font-medium text-sm transition-colors"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    disabled={forwardProcessing}
                                    className="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-medium transition-colors shadow-soft shadow-brand-500/30 disabled:opacity-50"
                                >
                                    {forwardProcessing
                                        ? "Meneruskan..."
                                        : "Teruskan Tiket"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AuthenticatedLayout>
    );
}
