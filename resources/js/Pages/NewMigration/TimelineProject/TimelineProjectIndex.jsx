import React, { useState, useEffect } from 'react';
import { usePage, Head, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Target, Briefcase, Calendar, Info, Edit, Trash2, Plus } from 'lucide-react';
import DashboardFilter from './Components/DashboardFilter';
import KpiBoardCard from './Components/KpiBoardCard';
import KpiModal from './Components/KpiModal';
import BoardModal from './Components/BoardModal';
import { getDaysRemaining, calculateProgress } from './utils';

export default function TimelineProjectIndex({ projects = [], programKerjas = [], title, departements = [], kategoriPrograms = [] }) {
    const { auth } = usePage().props;
    const user = auth?.user;
    const isAdmin = user?.roles?.some(r => r.name?.toLowerCase() === 'admin');

    const [activeTab, setActiveTab] = useState('wig');
    const [searchKpi, setSearchKpi] = useState('');
    const [filterDepartment, setFilterDepartment] = useState('all');
    const [isDeptDropdownOpen, setIsDeptDropdownOpen] = useState(false);

    // UI states for deleting
    const [isDeletingKpiId, setIsDeletingKpiId] = useState(null);
    const [isDeletingBoardId, setIsDeletingBoardId] = useState(null);

    // Kpi Modal States
    const [isKpiModalOpen, setIsKpiModalOpen] = useState(false);
    const [editingKpi, setEditingKpi] = useState(null);

    // Board Modal States
    const [isBoardModalOpen, setIsBoardModalOpen] = useState(false);
    const [editingBoard, setEditingBoard] = useState(null);
    const [initialTargetKpiId, setInitialTargetKpiId] = useState(null);

    const handleOpenKpiModal = (kpi = null) => {
        setEditingKpi(kpi);
        setIsKpiModalOpen(true);
    };

    const handleDeleteKpi = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus Project ini? Semua Board dan Task di dalamnya akan ikut terhapus!')) {
            setIsDeletingKpiId(id);
            router.delete(`/timeline-project/${id}`, {
                onFinish: () => setIsDeletingKpiId(null),
            });
        }
    };

    const handleOpenBoardModal = (kpiId = null, board = null) => {
        setInitialTargetKpiId(kpiId);
        setEditingBoard(board);
        setIsBoardModalOpen(true);
    };

    const handleDeleteBoard = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus Program Kerja (Board) ini? Semua task di dalamnya akan terhapus.')) {
            setIsDeletingBoardId(id);
            router.delete(`/kanban/lead-measure/${id}`, {
                onFinish: () => setIsDeletingBoardId(null),
            });
        }
    };

    const displayKpis = projects;

    return (
        <AuthenticatedLayout user={auth?.user}>
            <Head title={title || "Timeline Project"} />

            <div className="flex-1 overflow-auto p-4 sm:p-6 ">
                <div className="flex justify-between items-center mb-6 flex-wrap gap-4">
                    <DashboardFilter
                        activeTab={activeTab}
                        setActiveTab={setActiveTab}
                        filterDepartment={filterDepartment}
                        setFilterDepartment={setFilterDepartment}
                        isDeptDropdownOpen={isDeptDropdownOpen}
                        setIsDeptDropdownOpen={setIsDeptDropdownOpen}
                        searchKpi={searchKpi}
                        setSearchKpi={setSearchKpi}
                        departments={departements}
                    />

                    {activeTab === 'wig' && isAdmin && (
                        <button
                            onClick={() => handleOpenKpiModal(null)}
                            className="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-colors flex items-center gap-2"
                        >
                            <Plus size={18} />
                            Buat Project Baru
                        </button>
                    )}
                </div>

                {activeTab === 'wig' && (
                    <div className="space-y-8">
                        {displayKpis
                            .filter((kpi) => filterDepartment === 'all' || String(kpi.departement_id) === String(filterDepartment))
                            .filter((kpi) => {
                                if (!searchKpi.trim()) return true;
                                const q = searchKpi.toLowerCase();
                                if (kpi.title?.toLowerCase().includes(q)) return true;
                                if (kpi.description?.toLowerCase().includes(q)) return true;
                                if (kpi.departement?.nama_departement?.toLowerCase().includes(q)) return true;
                                if (kpi.boards?.some((b) => b.title?.toLowerCase().includes(q))) return true;
                                return false;
                            })
                            .map((kpi) => {
                                const progress = calculateProgress(kpi.boards || []);
                                const canViewDetails = isAdmin || kpi.pic_id === user?.id;

                                const bobotWig = Number(kpi.bobot ?? 100);
                                const usedBobot = (kpi.boards || []).reduce(
                                    (acc, board) => acc + Number(board.bobot ?? 0),
                                    0
                                );
                                const sisaBobot = bobotWig - usedBobot;

                                return (
                                    <div
                                        key={kpi.id}
                                        className="mb-6 sm:mb-10 bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-300 hover:shadow-lg hover:shadow-gray-300 transition-shadow"
                                    >
                                        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                                            <div className="flex flex-col gap-1">
                                                <div className="flex items-center gap-3">
                                                    <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 shrink-0">
                                                        <Target size={20} />
                                                    </div>
                                                    <h2 className="text-lg sm:text-xl md:text-xl font-bold text-gray-800">
                                                        Main Project - {kpi.title}
                                                    </h2>
                                                </div>
                                                <div className="flex items-center gap-4 mt-2 text-sm text-gray-500 pl-12">
                                                    <span className="flex items-center gap-1.5">
                                                        <Briefcase size={14} className="text-indigo-400" />{' '}
                                                        {kpi.departement?.nama_departement || 'Semua Departemen'}
                                                    </span>

                                                    {kpi.description && (
                                                        <div className="relative group flex items-center">
                                                            <button className="flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-gray-900 hover:bg-black text-white transition-colors cursor-help">
                                                                <Info size={14} />
                                                                <span className="text-[11px] font-semibold tracking-wide">
                                                                    Target WIG
                                                                </span>
                                                            </button>

                                                            <div className="absolute left-0 sm:left-4 top-full mt-2 w-72 sm:w-80 p-3 bg-gray-900 text-white text-sm rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 pointer-events-none">
                                                                {kpi.description}
                                                                <div className="absolute -top-1.5 left-6 w-3 h-3 bg-gray-900 rotate-45"></div>
                                                            </div>
                                                        </div>
                                                    )}

                                                    <span className="flex items-center gap-1.5 flex-wrap">
                                                        <Calendar size={14} className="text-indigo-400" />{' '}
                                                        {kpi.target_date ? (
                                                            <>
                                                                {new Date(kpi.target_date).toLocaleDateString('id-ID')}
                                                                {(() => {
                                                                    const r = getDaysRemaining(kpi.target_date);
                                                                    return (
                                                                        <span
                                                                            className={`font-semibold text-[11px] px-1.5 py-0.5 rounded-md ${r.isOverdue ? 'text-red-600 bg-red-50' : 'text-amber-600 bg-amber-50'}`}
                                                                        >
                                                                            ({r.text})
                                                                        </span>
                                                                    );
                                                                })()}
                                                            </>
                                                        ) : (
                                                            '-'
                                                        )}
                                                        <span className="flex items-center gap-1.5 ml-2">
                                                            <div className="flex items-center bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-md text-xs font-semibold border border-indigo-200">
                                                                Bobot WIG: {bobotWig}
                                                            </div>
                                                            <div
                                                                className={`flex items-center px-2.5 py-1 rounded-md text-xs font-semibold border ${sisaBobot < 0
                                                                    ? 'bg-red-50 text-red-700 border-red-200'
                                                                    : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                                                    }`}
                                                            >
                                                                Sisa Bobot: {sisaBobot}
                                                            </div>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                            {canViewDetails && (
                                                <div className="flex gap-2">
                                                    <button
                                                        onClick={() => handleOpenKpiModal(kpi)}
                                                        className="p-2 text-gray-400 hover:text-indigo-500 hover:bg-indigo-50 rounded-xl transition-all"
                                                        title="Edit KPI"
                                                    >
                                                        <Edit size={16} />
                                                    </button>
                                                    <button
                                                        onClick={() => handleDeleteKpi(kpi.id)}
                                                        disabled={isDeletingKpiId === kpi.id}
                                                        className="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                                                        title="Hapus KPI"
                                                    >
                                                        {isDeletingKpiId === kpi.id ? (
                                                            <div className="w-4 h-4 border-2 border-red-500/30 border-t-red-500 rounded-full animate-spin" />
                                                        ) : (
                                                            <Trash2 size={16} />
                                                        )}
                                                    </button>
                                                </div>
                                            )}
                                        </div>

                                        <div>
                                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 gap-4 sm:gap-6">
                                                {/* Create Board Card */}
                                                <div
                                                    onClick={() => handleOpenBoardModal(kpi.id, null)}
                                                    className="bg-gray-50 rounded-xl p-4 sm:p-5 border border-gray-200 border-dashed shadow-sm hover:border-indigo-500/30 hover:bg-indigo-50 hover:shadow-md transition-all cursor-pointer group flex flex-col items-center justify-center min-h-[140px] sm:min-h-[160px]"
                                                >
                                                    <div className="w-10 h-10 rounded-full bg-indigo-500/10 text-indigo-500 flex items-center justify-center mb-2 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300">
                                                        <Plus size={20} />
                                                    </div>
                                                    <span className="text-sm font-medium text-gray-500 group-hover:text-indigo-500 transition-colors text-center">
                                                        Tambah Board Project
                                                    </span>
                                                </div>

                                                {kpi.boards && kpi.boards.map((board) => (
                                                    <KpiBoardCard
                                                        key={board.id}
                                                        board={board}
                                                        user={user}
                                                        isAdmin={isAdmin}
                                                        kpiUserId={kpi.pic_id}
                                                        onEdit={(board, e) => {
                                                            e.stopPropagation();
                                                            handleOpenBoardModal(kpi.id, board);
                                                        }}
                                                        onDelete={(boardId, e) => {
                                                            e.stopPropagation();
                                                            handleDeleteBoard(boardId);
                                                        }}
                                                        isDeleting={isDeletingBoardId === board.id}
                                                    />
                                                ))}
                                            </div>
                                        </div>
                                    </div>
                                );
                            })}
                    </div>
                )}

                {activeTab === 'program_kerja' && (
                    <div className="bg-white rounded-xl p-8 text-center border border-gray-100 shadow-sm mt-8">
                        <Calendar className="w-12 h-12 text-gray-300 mx-auto mb-3" />
                        <h2 className="text-lg font-bold text-gray-700">Program Kerja</h2>
                        <p className="text-gray-500 text-sm mt-1">Fitur Program Kerja sedang dikerjakan pada tahap berikutnya.</p>
                    </div>
                )}
            </div>

            <KpiModal
                isOpen={isKpiModalOpen}
                onClose={() => setIsKpiModalOpen(false)}
                editingKpi={editingKpi}
            />

            <BoardModal
                isOpen={isBoardModalOpen}
                onClose={() => setIsBoardModalOpen(false)}
                editingBoard={editingBoard}
                initialTargetKpiId={initialTargetKpiId}
                kpis={displayKpis}
                kategoriPrograms={kategoriPrograms}
            />

        </AuthenticatedLayout>
    );
}
