import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';
import KanbanBoard from './KanbanBoard';
import { ArrowLeft, Target, Plus, LayoutDashboard } from 'lucide-react';
import clsx from 'clsx';
// Placeholders for modals that would be created next
import CreateTaskModal from '../Task/CreateTaskModal';
import CardModal from '../Task/CardModal';
import '../../../../css/kanban.css';

export default function BoardView({ auth, leadMeasure, tasks, users }) {
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const [selectedColumnForNew, setSelectedColumnForNew] = useState('new');
  
  const [selectedTask, setSelectedTask] = useState(null);
  const [isCardModalOpen, setIsCardModalOpen] = useState(false);

  const handleOpenCreate = (columnId = 'new') => {
    setSelectedColumnForNew(columnId);
    setIsCreateModalOpen(true);
  };

  const handleTaskClick = (task) => {
    setSelectedTask(task);
    setIsCardModalOpen(true);
  };

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div className="flex items-center gap-3">
            <Link 
              href={route('dashboard')} // Adjust route
              className="p-2 rounded-lg bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 shadow-sm border border-gray-200 dark:border-gray-700 transition-all"
            >
              <ArrowLeft size={18} />
            </Link>
            <div>
              <h2 className="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <LayoutDashboard className="text-brand-500" size={24} />
                Kanban Board
              </h2>
              <div className="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                <Target size={14} className="text-brand-500/70" />
                <span className="font-medium">{leadMeasure?.wig?.name || 'WIG Name'}</span>
                <span className="text-gray-300 dark:text-gray-600 px-1">•</span>
                <span>{leadMeasure?.name || 'Lead Measure Name'}</span>
              </div>
            </div>
          </div>
          
          <div className="flex items-center gap-3">
            <div className="glass px-4 py-2 rounded-lg flex items-center gap-3">
              <span className="text-sm text-gray-500 dark:text-gray-400 font-medium">Bobot Board:</span>
              <span className="text-lg font-bold text-brand-600 dark:text-brand-400">
                {leadMeasure?.bobot_board || '0'}%
              </span>
            </div>
            <button
              onClick={() => handleOpenCreate('new')}
              className="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-2 font-medium text-sm"
            >
              <Plus size={16} />
              New Task
            </button>
          </div>
        </div>
      }
    >
      <Head title="Kanban Board" />

      <div className="py-6 h-[calc(100vh-140px)] min-h-[600px] flex flex-col font-sans">
        <div className="max-w-full mx-auto sm:px-6 lg:px-8 h-full w-full flex flex-col">
          
          {/* Score Summary Table - Optional based on requirements, adding simple version */}
          <div className="mb-6 glass-panel rounded-xl p-4 overflow-x-auto">
             <table className="w-full text-sm text-left">
                <thead className="text-xs text-gray-500 dark:text-gray-400 uppercase bg-gray-50/50 dark:bg-gray-800/50 rounded-t-lg">
                    <tr>
                        <th className="px-4 py-2 rounded-tl-lg">Priority</th>
                        <th className="px-4 py-2">New</th>
                        <th className="px-4 py-2">In Progress</th>
                        <th className="px-4 py-2">Done</th>
                        <th className="px-4 py-2 rounded-tr-lg">Score</th>
                    </tr>
                </thead>
                <tbody className="text-gray-700 dark:text-gray-200">
                    <tr className="border-b border-gray-100 dark:border-gray-800">
                        <td className="px-4 py-2 font-medium text-red-500">High</td>
                        <td className="px-4 py-2">-</td>
                        <td className="px-4 py-2">-</td>
                        <td className="px-4 py-2">-</td>
                        <td className="px-4 py-2 font-bold">-</td>
                    </tr>
                     <tr className="border-b border-gray-100 dark:border-gray-800">
                        <td className="px-4 py-2 font-medium text-amber-500">Medium</td>
                        <td className="px-4 py-2">-</td>
                        <td className="px-4 py-2">-</td>
                        <td className="px-4 py-2">-</td>
                        <td className="px-4 py-2 font-bold">-</td>
                    </tr>
                     <tr>
                        <td className="px-4 py-2 font-medium text-emerald-500">Low</td>
                        <td className="px-4 py-2">-</td>
                        <td className="px-4 py-2">-</td>
                        <td className="px-4 py-2">-</td>
                        <td className="px-4 py-2 font-bold">-</td>
                    </tr>
                </tbody>
             </table>
          </div>

          <div className="flex-1 overflow-hidden relative">
            <KanbanBoard 
              initialTasks={tasks || []} 
              auth={auth} 
              onTaskClick={handleTaskClick}
              onAddTask={handleOpenCreate}
            />
          </div>
        </div>
      </div>

      {isCreateModalOpen && (
        <CreateTaskModal
          isOpen={isCreateModalOpen}
          onClose={() => setIsCreateModalOpen(false)}
          users={users}
          leadMeasureId={leadMeasure?.id}
          initialColumn={selectedColumnForNew}
        />
      )}

      {isCardModalOpen && selectedTask && (
        <CardModal
          isOpen={isCardModalOpen}
          onClose={() => {
            setIsCardModalOpen(false);
            setSelectedTask(null);
          }}
          task={selectedTask}
          users={users}
          auth={auth}
        />
      )}
    </AuthenticatedLayout>
  );
}
