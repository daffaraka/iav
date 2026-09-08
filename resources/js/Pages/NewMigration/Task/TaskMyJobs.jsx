import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { Briefcase, Calendar, Search, Filter, AlertCircle, Clock, CheckCircle2 } from 'lucide-react';
import { format, isPast, isToday } from 'date-fns';
import clsx from 'clsx';
// Re-use CardModal for showing task details
import CardModal from './CardModal';
import '../../../../css/kanban.css';

export default function MyJobs({ auth, tasks = { new: [], progress: [], done: [] } }) {
  const [searchQuery, setSearchQuery] = useState('');
  const [priorityFilter, setPriorityFilter] = useState('all');
  
  const [selectedTask, setSelectedTask] = useState(null);
  const [isCardModalOpen, setIsCardModalOpen] = useState(false);

  const handleTaskClick = (task) => {
    setSelectedTask(task);
    setIsCardModalOpen(true);
  };

  // Flatten and filter tasks
  const allTasks = [...(tasks.new || []), ...(tasks.progress || []), ...(tasks.done || [])];
  
  const filteredTasks = allTasks.filter(task => {
      const matchesSearch = (task.nama_tugas?.toLowerCase() || '').includes(searchQuery.toLowerCase());
      const matchesPriority = priorityFilter === 'all' || task.priority === priorityFilter;
      return matchesSearch && matchesPriority;
  });

  const groupedTasks = {
      new: filteredTasks.filter(t => t.column_id === 'new'),
      progress: filteredTasks.filter(t => t.column_id === 'progress'),
      done: filteredTasks.filter(t => t.column_id === 'done'),
  };

  const getPriorityColor = (p) => {
      if(p === 'high') return 'text-red-600 bg-red-100 dark:bg-red-900/30 dark:text-red-400 border-red-200 dark:border-red-800/50';
      if(p === 'medium') return 'text-amber-600 bg-amber-100 dark:bg-amber-900/30 dark:text-amber-400 border-amber-200 dark:border-amber-800/50';
      if(p === 'low') return 'text-emerald-600 bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50';
      return 'text-gray-600 bg-gray-100 dark:bg-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700';
  };

  const renderColumn = (title, columnId, items, icon) => (
      <div className="flex flex-col gap-4">
          <div className="flex items-center gap-2 px-1">
              {icon}
              <h3 className="font-semibold text-gray-800 dark:text-gray-200">{title}</h3>
              <span className="ml-auto bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs font-bold px-2 py-0.5 rounded-full">
                  {items.length}
              </span>
          </div>
          
          <div className="flex flex-col gap-3">
              {items.length === 0 ? (
                  <div className="glass-panel border-dashed rounded-xl p-8 text-center text-gray-400 dark:text-gray-500 text-sm">
                      No tasks found
                  </div>
              ) : (
                  items.map(task => {
                      const isDueWarning = task.due_date && task.column_id !== 'done' && (isPast(new Date(task.due_date)) || isToday(new Date(task.due_date)));
                      return (
                          <div 
                              key={task.id}
                              onClick={() => handleTaskClick(task)}
                              className="glass-card glass-card-hover rounded-xl p-4 cursor-pointer group transition-all duration-300"
                          >
                              <div className="flex justify-between items-start mb-2 gap-2">
                                  <h4 className="font-medium text-gray-900 dark:text-gray-100 text-sm line-clamp-2 group-hover:text-brand-500 transition-colors">
                                      {task.nama_tugas || task.title}
                                  </h4>
                                  {task.priority && (
                                      <span className={clsx('text-[10px] font-bold px-2 py-0.5 rounded-full border shrink-0', getPriorityColor(task.priority))}>
                                          {task.priority.toUpperCase()}
                                      </span>
                                  )}
                              </div>
                              
                              <div className="text-xs text-gray-500 dark:text-gray-400 mb-3 line-clamp-1">
                                  {task.board_name || 'Board'} / {task.wig_name || 'WIG'}
                              </div>
                              
                              <div className="flex items-center justify-between mt-auto">
                                  {task.due_date ? (
                                      <div className={clsx(
                                          "flex items-center gap-1.5 text-xs px-2 py-1 rounded-md border",
                                          isDueWarning 
                                            ? "bg-red-50 text-red-600 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/30" 
                                            : "bg-gray-50 text-gray-500 border-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700"
                                      )}>
                                          {isDueWarning ? <AlertCircle size={12} /> : <Calendar size={12} />}
                                          <span className={isDueWarning ? "font-semibold" : ""}>
                                              {format(new Date(task.due_date), 'MMM d')}
                                          </span>
                                      </div>
                                  ) : (
                                      <div />
                                  )}
                                  
                                  {/* Action button visible on hover */}
                                  <div className="opacity-0 group-hover:opacity-100 transition-opacity">
                                      <Link
                                          href={route('kanban.board', { id: task.lead_measure_id })}
                                          onClick={(e) => e.stopPropagation()}
                                          className="text-[10px] font-medium text-brand-500 bg-brand-50 dark:bg-brand-900/20 px-2 py-1 rounded hover:bg-brand-100 dark:hover:bg-brand-900/40 transition-colors"
                                      >
                                          View Board
                                      </Link>
                                  </div>
                              </div>
                          </div>
                      );
                  })
              )}
          </div>
      </div>
  );

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div className="flex items-center gap-3">
            <div className="p-2 bg-brand-100 dark:bg-brand-900/40 text-brand-600 dark:text-brand-400 rounded-lg shadow-sm">
                <Briefcase size={24} />
            </div>
            <div>
              <h2 className="text-xl font-bold text-gray-800 dark:text-white leading-tight">
                My Jobs
              </h2>
              <p className="text-sm text-gray-500 dark:text-gray-400">
                Manage all your assigned tasks across boards
              </p>
            </div>
          </div>
          
          <div className="flex items-center gap-3 w-full md:w-auto">
              <div className="relative w-full md:w-64">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <Search size={16} className="text-gray-400" />
                  </div>
                  <input
                      type="text"
                      placeholder="Search tasks..."
                      value={searchQuery}
                      onChange={(e) => setSearchQuery(e.target.value)}
                      className="w-full pl-9 pr-4 py-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg text-sm focus:ring-brand-500 focus:border-brand-500 shadow-sm transition-all"
                  />
              </div>
              
              <div className="relative shrink-0">
                  <select
                      value={priorityFilter}
                      onChange={(e) => setPriorityFilter(e.target.value)}
                      className="pl-9 pr-8 py-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg text-sm focus:ring-brand-500 focus:border-brand-500 shadow-sm appearance-none transition-all"
                  >
                      <option value="all">All Priorities</option>
                      <option value="high">High Priority</option>
                      <option value="medium">Medium Priority</option>
                      <option value="low">Low Priority</option>
                  </select>
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <Filter size={16} className="text-gray-400" />
                  </div>
              </div>
          </div>
        </div>
      }
    >
      <Head title="My Jobs" />

      <div className="py-8 font-sans">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {/* Overview Stats */}
            <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div className="glass-panel rounded-xl p-4 flex items-center gap-4">
                    <div className="p-3 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                        <AlertCircle size={20} />
                    </div>
                    <div>
                        <p className="text-sm font-medium text-gray-500 dark:text-gray-400">To Do</p>
                        <p className="text-2xl font-bold text-gray-900 dark:text-white">{groupedTasks.new.length}</p>
                    </div>
                </div>
                <div className="glass-panel rounded-xl p-4 flex items-center gap-4">
                    <div className="p-3 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-lg">
                        <Clock size={20} />
                    </div>
                    <div>
                        <p className="text-sm font-medium text-gray-500 dark:text-gray-400">In Progress</p>
                        <p className="text-2xl font-bold text-gray-900 dark:text-white">{groupedTasks.progress.length}</p>
                    </div>
                </div>
                <div className="glass-panel rounded-xl p-4 flex items-center gap-4">
                    <div className="p-3 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-lg">
                        <CheckCircle2 size={20} />
                    </div>
                    <div>
                        <p className="text-sm font-medium text-gray-500 dark:text-gray-400">Completed</p>
                        <p className="text-2xl font-bold text-gray-900 dark:text-white">{groupedTasks.done.length}</p>
                    </div>
                </div>
            </div>

            {/* Kanban-style Grid */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 items-start">
                {renderColumn("New Tasks", "new", groupedTasks.new, <AlertCircle size={18} className="text-blue-500" />)}
                {renderColumn("In Progress", "progress", groupedTasks.progress, <Clock size={18} className="text-amber-500" />)}
                {renderColumn("Done", "done", groupedTasks.done, <CheckCircle2 size={18} className="text-emerald-500" />)}
            </div>
        </div>
      </div>

      {isCardModalOpen && selectedTask && (
        <CardModal
          isOpen={isCardModalOpen}
          onClose={() => {
            setIsCardModalOpen(false);
            setSelectedTask(null);
          }}
          task={selectedTask}
          users={[]} // Would ideally pass users here or fetch them
          auth={auth}
        />
      )}
    </AuthenticatedLayout>
  );
}
