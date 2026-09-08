import React from 'react';
import { Link } from '@inertiajs/react';
import { FolderKanban, Info, Calendar, Target, Edit, Trash2 } from 'lucide-react';
import { getDaysRemaining } from '../utils';

export default function KpiBoardCard({
  board,
  isAdmin,
  kpiUserId,
  user,
  onEdit,
  onDelete,
  isDeleting,
}) {
  const canModify = isAdmin || user?.id === kpiUserId || user?.id === board.pic_id;
  const tasks = board.tasks || [];

  const todoTasks = tasks.filter((t) => t.column_id === 'todo').length;
  const progressTasks = tasks.filter((t) => t.column_id === 'progress').length;
  const doneTasks = tasks.filter((t) => t.column_id === 'done').length;

  return (
    <div className="bg-white rounded-xl p-4 sm:p-5 border border-gray-400 shadow-sm hover:shadow-md transition-all cursor-pointer group flex flex-col min-h-[140px] sm:min-h-[160px] relative">
      <Link href={`/kanban/board/${board.id}`} className="absolute inset-0 z-0"></Link>

      <div className="flex items-start justify-between mb-3 relative z-10 pointer-events-none">
        <div className="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white transition-colors shrink-0">
          <FolderKanban size={20} />
        </div>

        {canModify && (
          <div className="flex gap-1 pointer-events-auto">
            <button
              onClick={(e) => onEdit(board, e)}
              className="p-1.5 text-gray-400 hover:text-indigo-500 hover:bg-indigo-50 rounded-lg transition-colors"
            >
              <Edit size={16} />
            </button>
            <button
              onClick={(e) => onDelete(board.id, e)}
              disabled={isDeleting}
              className="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors disabled:opacity-50"
            >
              {isDeleting ? (
                <div className="w-4 h-4 border-2 border-red-500/30 border-t-red-500 rounded-full animate-spin" />
              ) : (
                <Trash2 size={16} />
              )}
            </button>
          </div>
        )}
      </div>

      <div className="mb-3 flex-1 mt-4 sm:mt-0 relative z-10 pointer-events-none">
        <h5 className="font-semibold text-sm sm:text-base text-gray-800 group-hover:text-indigo-500 transition-all mb-1 line-clamp-2 leading-tight pr-12">
          {board.title}
        </h5>

        {(board.description || board.bobot !== null) && (
          <div className="flex flex-wrap items-center gap-2 mt-2 mb-1 pointer-events-auto">
            {board.description && (
              <div className="relative group/desc w-fit">
                <button className="flex items-center gap-1.5 px-2 py-1 rounded-md bg-gray-900 hover:bg-black text-white transition-colors cursor-help">
                  <Info size={12} />
                  <span className="text-[10px] font-semibold tracking-wide">
                    Target Board
                  </span>
                </button>
                <div className="absolute left-0 top-full mt-2 w-64 sm:w-72 p-3 bg-gray-900 text-white text-xs rounded-lg shadow-xl opacity-0 invisible group-hover/desc:opacity-100 group-hover/desc:visible transition-all duration-200 z-[60] pointer-events-none">
                  {board.description}
                  <div className="absolute -top-1.5 left-4 w-3 h-3 bg-gray-900 rotate-45"></div>
                </div>
              </div>
            )}

            {board.bobot !== null && (
              <span className="inline-flex items-center px-2 py-1 rounded-md text-xs tracking-wider bg-emerald-700/80 text-white shadow-sm border border-emerald-700">
                Bobot: {board.bobot}
              </span>
            )}

            {board.score !== null && (
              <div className="relative group/score w-fit">
                <span className="inline-flex items-center px-2 py-1 rounded-md text-xs tracking-wider bg-blue-600 hover:bg-blue-700 transition-colors text-white shadow-sm border border-blue-700 cursor-help">
                  Ketercapaian: {board.score}%
                </span>
              </div>
            )}
          </div>
        )}

        <p className="text-[10px] text-indigo-400 mt-2 font-medium">
          Oleh: {board.pic?.name || "Sistem"}
        </p>

        {(board.start_date || board.target_date) && (
          <div className="flex flex-wrap gap-1.5 mt-2.5 pointer-events-auto">
            {board.start_date && (
              <span className="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                <Calendar size={10} />
                {new Date(board.start_date).toLocaleDateString("id-ID")}
              </span>
            )}
            {board.target_date && (
              <span className="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                <Target size={10} />
                {new Date(board.target_date).toLocaleDateString("id-ID")}
                {(() => {
                  const r = getDaysRemaining(board.target_date);
                  return (
                    <span
                      className={`ml-0.5 ${r.isOverdue ? "text-red-600" : "text-amber-600"}`}
                    >
                      ({r.text})
                    </span>
                  );
                })()}
              </span>
            )}
          </div>
        )}
      </div>

      <div className="grid grid-cols-3 gap-1.5 text-center mt-auto relative z-10 pointer-events-none">
        <div className="bg-gray-50 rounded-lg p-1.5 shadow-sm border border-gray-100">
          <div className="text-[10px] text-gray-500 mb-0.5 font-medium tracking-wider">
            TODO
          </div>
          <div className="font-bold text-gray-700 text-sm">{todoTasks}</div>
        </div>
        <div className="bg-gray-50 rounded-lg p-1.5 shadow-sm border border-gray-100">
          <div className="text-[10px] text-gray-500 mb-0.5 font-medium tracking-wider">
            PROG
          </div>
          <div className="font-bold text-amber-500 text-sm">
            {progressTasks}
          </div>
        </div>
        <div className="bg-gray-50 rounded-lg p-1.5 shadow-sm border border-gray-100">
          <div className="text-[10px] text-gray-500 mb-0.5 font-medium tracking-wider">
            DONE
          </div>
          <div className="font-bold text-emerald-500 text-sm">{doneTasks}</div>
        </div>
      </div>

      {board.prioritas && (
        <div className="mt-2 relative z-10 pointer-events-none">
          <span
            className={`inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider ${board.prioritas === "high"
              ? "bg-red-100 text-red-700 border border-red-200"
              : board.prioritas === "medium"
                ? "bg-amber-100 text-amber-700 border border-amber-200"
                : "bg-green-100 text-green-700 border border-green-200"
              }`}
          >
            {board.prioritas === "high"
              ? "Prioritas Tinggi"
              : board.prioritas === "medium"
                ? "Prioritas Sedang"
                : "Prioritas Rendah"}
          </span>
        </div>
      )}
    </div>
  );
}
