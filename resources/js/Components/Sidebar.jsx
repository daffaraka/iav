import React, { useState } from "react";
import { Link, usePage } from "@inertiajs/react";

export default function Sidebar({ isSidebarOpen, isMobile, setIsSidebarOpen }) {
    const { auth } = usePage().props;
    const userRoles = auth?.user?.roles?.map(role => role.name) || [];
    const hasRole = (role) => userRoles.includes(role);

    const [hoveredMenu, setHoveredMenu] = useState(null);
    const [hoverPos, setHoverPos] = useState({ top: 0, left: 0 });

    const handleMouseOver = (e) => {
        if (isSidebarOpen || isMobile) {
            if (hoveredMenu) setHoveredMenu(null);
            return;
        }
        
        // Find closest element with data-title
        let el = e.target;
        while (el && el !== e.currentTarget) {
            if (el.hasAttribute && el.hasAttribute('data-title')) {
                const title = el.getAttribute('data-title');
                const rect = el.getBoundingClientRect();
                setHoverPos({ top: rect.top + rect.height / 2, left: rect.right + 16 });
                setHoveredMenu(title);
                return;
            }
            el = el.parentNode;
        }
    };

    const handleMouseOut = (e) => {
        let el = e.target;
        let isLeavingLink = false;
        
        while (el && el !== e.currentTarget) {
            if (el.hasAttribute && el.hasAttribute('data-title')) {
                isLeavingLink = true;
                break;
            }
            el = el.parentNode;
        }

        if (isLeavingLink) {
            let related = e.relatedTarget;
            let isEnteringAnotherLink = false;
            while (related && related !== e.currentTarget) {
                if (related.hasAttribute && related.hasAttribute('data-title')) {
                    isEnteringAnotherLink = true;
                    break;
                }
                related = related.parentNode;
            }

            if (!isEnteringAnotherLink) {
                setHoveredMenu(null);
            }
        }
    };

    const sidebarWidth = isSidebarOpen ? "w-64" : isMobile ? "w-64" : "w-20";
    const sidebarTranslate = isMobile
        ? isSidebarOpen
            ? "translate-x-0"
            : "-translate-x-full"
        : "translate-x-0";

    return (
        <>
            <style>
                {`
                /* Custom Scrollbar for Sidebar */
                .sidebar-scroll::-webkit-scrollbar {
                    width: 6px;
                }
                .sidebar-scroll::-webkit-scrollbar-track {
                    background: transparent;
                }
                .sidebar-scroll::-webkit-scrollbar-thumb {
                    background-color: #334155;
                    border-radius: 10px;
                }
                .sidebar-scroll:hover::-webkit-scrollbar-thumb {
                    background-color: #475569;
                }
                `}
            </style>
            {/* Mobile Sidebar Overlay */}
            {isMobile && isSidebarOpen && (
                <div
                    className="fixed inset-0 bg-slate-900/50 z-40 lg:hidden backdrop-blur-sm"
                    onClick={() => setIsSidebarOpen(false)}
                ></div>
            )}

            {/* Sidebar */}
            <aside
                onMouseOver={handleMouseOver}
                onMouseOut={handleMouseOut}
                className={`fixed inset-y-0 left-0 z-50 bg-surface-900 border-r border-surface-800 flex flex-col h-full shadow-lg transform transition-all duration-300 ${sidebarWidth} ${sidebarTranslate}`}
            >
                <div
                    className={`h-16 flex items-center border-b border-surface-800 ${isSidebarOpen ? "px-6 justify-between" : "px-0 justify-center"}`}
                >
                    <div className="flex items-center">
                        <div
                            className={`w-8 h-8 rounded-lg bg-brand-500 text-white flex items-center justify-center font-bold text-xl shadow-lg shadow-brand-500/30 ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                        >
                            A
                        </div>

                        {/* Logo Text - Hidden when collapsed */}
                        {isSidebarOpen && (
                            <div className="flex flex-col overflow-hidden whitespace-nowrap">
                                <span className="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mb-[-2px]">
                                    Internal
                                </span>
                                <span className="font-bold text-white leading-tight">
                                    Avicenna
                                </span>
                                <span className="text-[10px] text-brand-400 font-semibold tracking-widest uppercase">
                                    School System
                                </span>
                            </div>
                        )}
                    </div>
                    {/* Close button on mobile */}
                    {isMobile && (
                        <button
                            onClick={() => setIsSidebarOpen(false)}
                            className="text-surface-400 hover:text-white"
                        >
                            <i className="ph ph-x text-xl"></i>
                        </button>
                    )}
                </div>

                <div className="flex-1 overflow-y-auto py-6 space-y-1 sidebar-scroll overflow-x-hidden">
                    {/* MASTER */}
                    {hasRole('super-admin') && (
                        <>
                            <div
                                className={`mb-2 mt-2 flex items-center ${isSidebarOpen ? "px-6 gap-2" : "justify-center"}`}
                            >
                                <div className="w-2 h-2 rounded-full bg-brand-500 shrink-0"></div>
                                {isSidebarOpen && (
                                    <p className="text-[11px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">
                                        Master
                                    </p>
                                )}
                            </div>
                            <div
                                className={`px-3 ${!isSidebarOpen && "flex flex-col items-center"}`}
                            >
                                <Link
                                    href="/dashboard"
                                    data-title="Dashboard Utama"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-squares-four text-xl group-hover:text-brand-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="text-sm font-medium whitespace-nowrap">
                                            Dashboard
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/departement"
                                    data-title="Departemen"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-buildings text-xl group-hover:text-brand-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Departemen
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/user"
                                    data-title="Manajemen User"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-users text-xl group-hover:text-brand-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Manajemen User
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/role"
                                    data-title="Manajemen Roles"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-shield-check text-xl group-hover:text-brand-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Manajemen Roles
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/kanban/kategori-program"
                                    data-title="Master TimeLine"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-database text-xl group-hover:text-brand-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Master TimeLine
                                        </span>
                                    )}
                                </Link>
                            </div>

                            {/* Divider */}
                            <div className="border-t border-surface-800 my-4 mx-4"></div>
                        </>
                    )}

                    {/* AQR */}
                    <div
                        className={`mb-2 flex items-center ${isSidebarOpen ? "px-6 gap-2" : "justify-center"}`}
                    >
                        <div className="w-2 h-2 rounded-full bg-blue-500 shrink-0"></div>
                        {isSidebarOpen && (
                            <p className="text-[11px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">
                                AQR (Helpdesk){" "}
                            </p>
                        )}
                    </div>
                    <div
                        className={`px-3 ${!isSidebarOpen && "flex flex-col items-center"}`}
                    >
                        <Link
                            href="/dashboard/aqr"
                            data-title="Dashboard AQR"
                            className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                        >
                            <i
                                className={`ph ph-chart-pie-slice text-xl group-hover:text-blue-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                            ></i>
                            {isSidebarOpen && (
                                <span className="font-medium text-sm whitespace-nowrap">
                                    Dashboard AQR
                                </span>
                            )}
                        </Link>
                        <Link
                            href="/dashboard/aqr/tiket"
                            data-title="Data Tiket"
                            className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                        >
                            <i
                                className={`ph ph-ticket text-xl group-hover:text-blue-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                            ></i>
                            {isSidebarOpen && (
                                <span className="font-medium text-sm whitespace-nowrap">
                                    Data Tiket
                                </span>
                            )}
                        </Link>
                        <Link
                            href="/dashboard/aqr/tiket-karyawan"
                            data-title="Tiket Karyawan"
                            className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                        >
                            <i
                                className={`ph ph-briefcase text-xl group-hover:text-blue-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                            ></i>
                            {isSidebarOpen && (
                                <span className="font-medium text-sm whitespace-nowrap">
                                    Tiket Karyawan
                                </span>
                            )}
                        </Link>
                        {hasRole('super-admin') && (
                            <Link
                                href="/aqr-option"
                                data-title="Opsi AQR"
                                className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                            >
                                <i
                                    className={`ph ph-sliders text-xl group-hover:text-blue-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                ></i>
                                {isSidebarOpen && (
                                    <span className="font-medium text-sm whitespace-nowrap">
                                        Opsi AQR
                                    </span>
                                )}
                            </Link>
                        )}
                        <Link
                            href="/featured-question"
                            data-title="Featured Question"
                            className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                        >
                            <i
                                className={`ph ph-question text-xl group-hover:text-blue-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                            ></i>
                            {isSidebarOpen && (
                                <span className="font-medium text-sm whitespace-nowrap">
                                    Featured Question
                                </span>
                            )}
                        </Link>
                    </div>

                    {/* Divider */}
                    <div className="border-t border-surface-800 my-4 mx-4"></div>

                    {/* SEKOLAH */}
                    {hasRole('super-admin') && (
                        <>
                            <div
                                className={`mb-2 flex items-center ${isSidebarOpen ? "px-6 gap-2" : "justify-center"}`}
                            >
                                <div className="w-2 h-2 rounded-full bg-amber-500 shrink-0"></div>
                                {isSidebarOpen && (
                                    <p className="text-[11px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">
                                        Sekolah
                                    </p>
                                )}
                            </div>
                            <div
                                className={`px-3 ${!isSidebarOpen && "flex flex-col items-center"}`}
                            >
                                <Link
                                    href="/sekolah"
                                    data-title="Master Sekolah"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-graduation-cap text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Master Sekolah
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/master-ptn"
                                    data-title="Master PTN/PTS"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-bank text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Master PTN/PTS
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/persebaran-ptn"
                                    data-title="Persebaran PTN/PTS"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-map-pin text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Persebaran PTN/PTS
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/prestasi-siswa"
                                    data-title="Prestasi Siswa"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-medal text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Prestasi Siswa
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/prestasi-guru"
                                    data-title="Prestasi Guru"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-certificate text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Prestasi Guru
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/siswa"
                                    data-title="Data Siswa"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-student text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Data Siswa
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/master-guru"
                                    data-title="Master Guru"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-chalkboard-teacher text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Master Guru
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/master-kelas"
                                    data-title="Master Kelas"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-blackboard text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Master Kelas
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/penjemputan-harian"
                                    data-title="Penjemputan Siswa"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-car-profile text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Penjemputan Siswa
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/scan-qr"
                                    data-title="Scan QR Kedatangan"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-qr-code text-xl group-hover:text-amber-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Scan QR Kedatangan
                                        </span>
                                    )}
                                </Link>
                            </div>

                            {/* Divider */}
                            <div className="border-t border-surface-800 my-4 mx-4"></div>
                        </>
                    )}

                    {/* WORK OVERVIEW */}
                    {hasRole('super-admin') && (
                        <>
                            <div className="border-t border-surface-800 my-4 mx-4"></div>
                            <div
                                className={`mb-2 flex items-center ${isSidebarOpen ? "px-6 gap-2" : "justify-center"}`}
                            >
                                <div className="w-2 h-2 rounded-full bg-teal-500 shrink-0"></div>
                                {isSidebarOpen && (
                                    <p className="text-[11px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">
                                        TimeLine Project
                                    </p>
                                )}
                            </div>
                            <div
                                className={`px-3 ${!isSidebarOpen && "flex flex-col items-center"}`}
                            >
                                {/* <Link
                                    href="/kanban/wig"
                                    data-title="WIG"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i className={`ph ph-target text-xl group-hover:text-teal-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            WIG
                                        </span>
                                    )}
                                </Link> */}
                                <Link
                                    href="/timeline-project"
                                    data-title="Main Project"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i className={`ph ph-target text-xl group-hover:text-teal-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Main Project
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/kanban/my-jobs"
                                    data-title="Board"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i className={`ph ph-kanban text-xl group-hover:text-teal-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Board
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/kanban/my-jobs"
                                    data-title="To Do"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i className={`ph ph-check-square-offset text-xl group-hover:text-teal-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            To Do
                                        </span>
                                    )}
                                </Link>
                                <Link
                                    href="/kanban/calendar"
                                    data-title="Calendar"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i className={`ph ph-calendar-blank text-xl group-hover:text-teal-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Calendar
                                        </span>
                                    )}
                                </Link>
                            </div>
                        </>
                    )}

                    {/* SDM */}
                    {hasRole('super-admin') && (
                        <>
                            <div className="border-t border-surface-800 my-4 mx-4"></div>
                            <div
                                className={`mb-2 flex items-center ${isSidebarOpen ? "px-6 gap-2" : "justify-center"}`}
                            >
                                <div className="w-2 h-2 rounded-full bg-rose-500 shrink-0"></div>
                                {isSidebarOpen && (
                                    <p className="text-[11px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">
                                        SDM
                                    </p>
                                )}
                            </div>
                            <div
                                className={`px-3 ${!isSidebarOpen && "flex flex-col items-center"}`}
                            >
                                <Link
                                    href="/wig"
                                    data-title="WIG"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-target text-xl group-hover:text-rose-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            WIG
                                        </span>
                                    )}
                                </Link>
                                <a
                                    href="#"
                                    data-title="Lead Measure"
                                    className={`flex items-center py-2.5 text-slate-300 hover:bg-surface-800 hover:text-white group transition-all border-transparent hover:border-surface-600 ${isSidebarOpen ? "px-3 rounded-xl border-l-4" : "justify-center w-12 h-12 rounded-xl mt-1"}`}
                                >
                                    <i
                                        className={`ph ph-chart-line-up text-xl group-hover:text-rose-400 transition-colors ${isSidebarOpen ? "mr-3" : "mr-0"}`}
                                    ></i>
                                    {isSidebarOpen && (
                                        <span className="font-medium text-sm whitespace-nowrap">
                                            Lead Measure
                                        </span>
                                    )}
                                </a>
                            </div>
                        </>
                    )}
                </div>
            </aside>
            {hoveredMenu && !isSidebarOpen && !isMobile && (
                <div 
                    className="fixed z-[100] bg-surface-800 text-white px-3 py-1.5 rounded-md text-xs font-semibold whitespace-nowrap shadow-xl border border-surface-700 pointer-events-none transform -translate-y-1/2"
                    style={{ top: hoverPos.top, left: hoverPos.left }}
                >
                    {hoveredMenu}
                    <div className="absolute top-1/2 -left-[5px] transform -translate-y-1/2 border-[5px] border-transparent border-r-surface-800"></div>
                </div>
            )}
        </>
    );
}
