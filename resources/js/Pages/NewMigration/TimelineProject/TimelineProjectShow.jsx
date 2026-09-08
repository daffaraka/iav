import React from 'react';
import { usePage, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Target, Edit, Trash2, Calendar, Plus } from 'lucide-react';

export default function Show({ wig, boards = [] }) {
    // Helper to calculate days remaining
    const calculateRemainingDays = (start, end) => {
        if (!start || !end) return 0;
        const endDate = new Date(end);
        const today = new Date();
        const diffTime = endDate - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays > 0 ? diffDays : 0;
    };

    return (
        <AuthenticatedLayout user={usePage().props.auth?.user}>
            <div className="space-y-6">
                {/* WIG Header Card */}
                <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div className="flex justify-between items-start mb-4">
                        <div className="flex items-center gap-4">
                            <div className="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <Target className="w-6 h-6 text-purple-600" />
                            </div>
                            <div>
                                <h1 className="text-2xl font-bold text-gray-900">{wig?.judul_wig || 'WIG Title'}</h1>
                            </div>
                        </div>
                        <div className="flex items-center gap-2">
                            <button className="p-2 text-gray-400 hover:text-blue-500 transition-colors rounded-lg hover:bg-gray-50">
                                <Edit className="w-5 h-5" />
                            </button>
                            <button className="p-2 text-gray-400 hover:text-red-500 transition-colors rounded-lg hover:bg-gray-50">
                                <Trash2 className="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                    
                    <div className="flex flex-wrap items-center gap-3 text-sm">
                        <span className="font-medium text-gray-700">{wig?.department?.name || 'Department Name'}</span>
                        <span className="px-3 py-1 bg-gray-900 text-white rounded-full text-xs font-medium">Target WIG</span>
                        
                        <div className="flex items-center gap-1.5 text-gray-500 bg-gray-50 px-3 py-1 rounded-full border border-gray-200">
                            <Calendar className="w-4 h-4" />
                            <span>{wig?.tanggal_mulai_wig} - {wig?.tanggal_berakhir_wig}</span>
                            <span className="text-orange-500 font-medium ml-1">(Sisa waktu {calculateRemainingDays(wig?.tanggal_mulai_wig, wig?.tanggal_berakhir_wig)} hari)</span>
                        </div>
                        
                        <span className="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Bobot WIG: {wig?.bobot_kpi || 0}</span>
                        <span className="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Sisa Bobot: X</span>
                    </div>
                </div>

                {/* Boards Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {/* Add Board Card */}
                    <button className="h-[280px] bg-white border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center gap-3 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                        <div className="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-indigo-100 transition-colors">
                            <Plus className="w-6 h-6 text-gray-400 group-hover:text-indigo-600" />
                        </div>
                        <span className="font-semibold text-gray-600 group-hover:text-indigo-600">Tambah Board Project</span>
                    </button>

                    {/* Existing Boards */}
                    {boards.map(board => {
                        const todoCount = board.task_processes?.filter(t => t.column_id === 'new').length || 0;
                        const progCount = board.task_processes?.filter(t => t.column_id === 'progress').length || 0;
                        const doneCount = board.task_processes?.filter(t => t.column_id === 'done').length || 0;

                        return (
                            <Link 
                                href={`/kanban/board/${board.id}`}
                                key={board.id}
                                className="block h-[280px] bg-blue-50/50 rounded-2xl border border-blue-100 p-5 relative hover:shadow-md transition-shadow flex flex-col"
                            >
                                <div className="flex justify-between items-start mb-3">
                                    <h3 className="font-bold text-gray-800 text-lg line-clamp-2 pr-12">{board.nama_board}</h3>
                                    <div className="absolute top-4 right-4 flex gap-1 bg-white/80 backdrop-blur rounded-lg p-1 shadow-sm">
                                        <button className="p-1.5 text-gray-400 hover:text-blue-600 rounded" onClick={(e) => e.preventDefault()}>
                                            <Edit className="w-4 h-4" />
                                        </button>
                                        <button className="p-1.5 text-gray-400 hover:text-red-600 rounded" onClick={(e) => e.preventDefault()}>
                                            <Trash2 className="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>

                                <div className="flex gap-2 mb-3">
                                    <span className="px-2 py-1 bg-gray-900 text-white rounded text-[10px] font-bold uppercase tracking-wide">Target Board</span>
                                    <span className="px-2 py-1 bg-teal-100 text-teal-800 rounded text-[10px] font-bold tracking-wide">Bobot: {board.bobot_board}</span>
                                </div>

                                <div className="text-sm text-gray-600 mb-2">
                                    <span className="font-medium">Oleh:</span> Admin
                                </div>

                                <div className="text-xs text-gray-500 mb-auto">
                                    <div className="flex items-center gap-1.5 mb-1">
                                        <Calendar className="w-3.5 h-3.5" />
                                        <span>{board.tanggal_mulai} - {board.tanggal_berakhir}</span>
                                    </div>
                                    <div className="text-orange-500 font-medium ml-5">(Sisa waktu {calculateRemainingDays(board.tanggal_mulai, board.tanggal_berakhir)} hari)</div>
                                </div>

                                <div className="flex gap-2 mt-4 mb-4">
                                    <div className="flex-1 bg-white rounded-full py-1.5 px-3 flex justify-between items-center shadow-sm border border-gray-100">
                                        <span className="text-[10px] font-bold text-gray-500">TODO</span>
                                        <span className="text-xs font-bold text-gray-900">{todoCount}</span>
                                    </div>
                                    <div className="flex-1 bg-white rounded-full py-1.5 px-3 flex justify-between items-center shadow-sm border border-gray-100">
                                        <span className="text-[10px] font-bold text-blue-500">PROG</span>
                                        <span className="text-xs font-bold text-blue-700">{progCount}</span>
                                    </div>
                                    <div className="flex-1 bg-white rounded-full py-1.5 px-3 flex justify-between items-center shadow-sm border border-gray-100">
                                        <span className="text-[10px] font-bold text-green-500">DONE</span>
                                        <span className="text-xs font-bold text-green-700">{doneCount}</span>
                                    </div>
                                </div>

                                <div className="absolute bottom-0 left-0 right-0 h-1.5 bg-green-500 rounded-b-2xl"></div>
                            </Link>
                        );
                    })}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
