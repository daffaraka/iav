import React, { useState } from 'react';
import { useForm, router } from '@inertiajs/react';
import { 
  X, Calendar, User, AlignLeft, Flag, CheckSquare, 
  MessageSquare, History, Tag, Clock, Send, Plus, Trash2
} from 'lucide-react';
import clsx from 'clsx';
import { format, isPast, isToday } from 'date-fns';

export default function CardModal({ isOpen, onClose, task, users, auth }) {
  const [activeTab, setActiveTab] = useState('details');
  const [newComment, setNewComment] = useState('');
  const [newChecklist, setNewChecklist] = useState('');

  const isOwner = auth.user.id === task.pic_id || auth.user.role === 'admin';

  if (!isOpen || !task) return null;

  const handleUpdate = (field, value) => {
    if (!isOwner) return;
    router.put(route('kanban.task.update', task.id), {
      [field]: value
    }, { preserveScroll: true });
  };

  const handleAddComment = (e) => {
    e.preventDefault();
    if (!newComment.trim()) return;
    
    router.post(route('kanban.task.comment.store', task.id), {
      content: newComment
    }, {
      preserveScroll: true,
      onSuccess: () => setNewComment('')
    });
  };

  const handleAddChecklist = (e) => {
    e.preventDefault();
    if (!newChecklist.trim()) return;
    
    router.post(route('kanban.task.checklist.store', task.id), {
      title: newChecklist
    }, {
      preserveScroll: true,
      onSuccess: () => setNewChecklist('')
    });
  };

  const toggleChecklist = (checklistId, isCompleted) => {
    router.put(route('kanban.task.checklist.update', [task.id, checklistId]), {
      is_completed: !isCompleted
    }, { preserveScroll: true });
  };
  
  const getPriorityColor = (p) => {
      if(p === 'high') return 'text-red-500 bg-red-50 dark:bg-red-900/20';
      if(p === 'medium') return 'text-amber-500 bg-amber-50 dark:bg-amber-900/20';
      return 'text-emerald-500 bg-emerald-50 dark:bg-emerald-900/20';
  }

  const tabs = [
    { id: 'details', label: 'Details', icon: AlignLeft },
    { id: 'checklist', label: 'Checklist', icon: CheckSquare, count: task.checklists?.length },
    { id: 'comments', label: 'Comments', icon: MessageSquare, count: task.comments?.length },
    { id: 'history', label: 'History', icon: History },
  ];

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
      <div 
        className="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
        onClick={onClose}
      />
      
      <div className="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-4xl h-[85vh] border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
        
        {/* Header */}
        <div className="flex items-start justify-between px-6 py-5 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/20">
          <div className="flex-1 pr-8">
             <div className="flex items-center gap-3 mb-2">
                <span className="text-xs font-semibold px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                    {task.column_id}
                </span>
                {task.priority && (
                    <span className={clsx("text-xs font-semibold px-2.5 py-1 rounded-md capitalize flex items-center gap-1", getPriorityColor(task.priority))}>
                        <Flag size={12} />
                        {task.priority}
                    </span>
                )}
             </div>
            <h2 className="text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                {task.nama_tugas || task.title}
            </h2>
            <p className="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-2">
               In list <span className="font-semibold text-gray-700 dark:text-gray-300">{task.column_id}</span>
            </p>
          </div>
          <button 
            onClick={onClose}
            className="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 transition-colors absolute top-5 right-5"
          >
            <X size={20} />
          </button>
        </div>

        <div className="flex flex-1 overflow-hidden flex-col md:flex-row">
            {/* Main Content Area */}
            <div className="flex-1 flex flex-col h-full border-r border-gray-100 dark:border-gray-800">
                {/* Tabs */}
                <div className="flex border-b border-gray-100 dark:border-gray-800 px-2 pt-2 bg-gray-50/30 dark:bg-gray-800/10">
                    {tabs.map(tab => (
                        <button
                            key={tab.id}
                            onClick={() => setActiveTab(tab.id)}
                            className={clsx(
                                "flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 transition-colors relative",
                                activeTab === tab.id 
                                    ? "border-brand-500 text-brand-600 dark:text-brand-400" 
                                    : "border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-gray-800/50 rounded-t-lg"
                            )}
                        >
                            <tab.icon size={16} />
                            {tab.label}
                            {tab.count !== undefined && tab.count > 0 && (
                                <span className={clsx(
                                    "ml-1.5 px-1.5 py-0.5 rounded-full text-[10px] font-bold",
                                    activeTab === tab.id ? "bg-brand-100 text-brand-700 dark:bg-brand-900/50 dark:text-brand-400" : "bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400"
                                )}>
                                    {tab.count}
                                </span>
                            )}
                        </button>
                    ))}
                </div>

                {/* Tab Content */}
                <div className="flex-1 overflow-y-auto p-6 custom-scrollbar">
                    {/* Details Tab */}
                    {activeTab === 'details' && (
                        <div className="space-y-6">
                            <div>
                                <h3 className="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2 mb-3">
                                    <AlignLeft size={16} className="text-gray-400" />
                                    Description
                                </h3>
                                {isOwner ? (
                                    <textarea
                                        defaultValue={task.deskripsi}
                                        onBlur={(e) => handleUpdate('deskripsi', e.target.value)}
                                        className="w-full min-h-[120px] rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 p-3 text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-brand-500 focus:bg-white dark:focus:bg-gray-900 transition-all resize-y"
                                        placeholder="Add a more detailed description..."
                                    />
                                ) : (
                                    <div className="p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                        {task.deskripsi || <span className="text-gray-400 italic">No description provided.</span>}
                                    </div>
                                )}
                            </div>
                        </div>
                    )}

                    {/* Checklist Tab */}
                    {activeTab === 'checklist' && (
                        <div className="space-y-4">
                            {/* Progress bar logic could go here */}
                            
                            <div className="space-y-2">
                                {task.checklists?.map(item => (
                                    <div key={item.id} className="flex items-start gap-3 group">
                                        <input
                                            type="checkbox"
                                            checked={item.is_completed}
                                            onChange={() => toggleChecklist(item.id, item.is_completed)}
                                            disabled={!isOwner}
                                            className="mt-1 w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 disabled:opacity-50"
                                        />
                                        <span className={clsx(
                                            "text-sm flex-1",
                                            item.is_completed ? "text-gray-400 line-through" : "text-gray-700 dark:text-gray-300"
                                        )}>
                                            {item.title}
                                        </span>
                                        {isOwner && (
                                            <button className="opacity-0 group-hover:opacity-100 text-red-500 hover:text-red-600 p-1 transition-opacity">
                                                <Trash2 size={14} />
                                            </button>
                                        )}
                                    </div>
                                ))}
                            </div>

                            {isOwner && (
                                <form onSubmit={handleAddChecklist} className="mt-4">
                                    <div className="flex gap-2">
                                        <input
                                            type="text"
                                            value={newChecklist}
                                            onChange={(e) => setNewChecklist(e.target.value)}
                                            placeholder="Add an item..."
                                            className="flex-1 text-sm rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-brand-500 focus:border-brand-500"
                                        />
                                        <button 
                                            type="submit"
                                            disabled={!newChecklist.trim()}
                                            className="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 font-medium text-sm disabled:opacity-50 transition-colors"
                                        >
                                            Add
                                        </button>
                                    </div>
                                </form>
                            )}
                        </div>
                    )}

                    {/* Comments Tab */}
                    {activeTab === 'comments' && (
                        <div className="flex flex-col h-full space-y-4">
                            <div className="flex-1 overflow-y-auto space-y-4">
                                {task.comments?.length > 0 ? (
                                    task.comments.map(comment => (
                                        <div key={comment.id} className="flex gap-3">
                                            <div className="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-300 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                                {comment.user?.name?.substring(0, 2).toUpperCase() || 'U'}
                                            </div>
                                            <div>
                                                <div className="flex items-baseline gap-2">
                                                    <span className="text-sm font-semibold text-gray-900 dark:text-gray-100">{comment.user?.name}</span>
                                                    <span className="text-xs text-gray-500">{format(new Date(comment.created_at), 'MMM d, h:mm a')}</span>
                                                </div>
                                                <div className="mt-1 text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg rounded-tl-none border border-gray-100 dark:border-gray-700/50">
                                                    {comment.content}
                                                </div>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div className="text-center py-8 text-gray-500 dark:text-gray-400 text-sm">
                                        No comments yet. Start the conversation!
                                    </div>
                                )}
                            </div>

                            <form onSubmit={handleAddComment} className="mt-auto border-t border-gray-100 dark:border-gray-800 pt-4">
                                <div className="flex gap-2 relative">
                                    <textarea
                                        value={newComment}
                                        onChange={(e) => setNewComment(e.target.value)}
                                        placeholder="Write a comment..."
                                        rows={1}
                                        className="flex-1 text-sm rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-brand-500 focus:border-brand-500 resize-none py-3 pr-12 custom-scrollbar"
                                    />
                                    <button 
                                        type="submit"
                                        disabled={!newComment.trim()}
                                        className="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 bg-brand-500 text-white rounded-lg hover:bg-brand-600 disabled:opacity-50 disabled:bg-gray-300 dark:disabled:bg-gray-700 transition-colors"
                                    >
                                        <Send size={16} />
                                    </button>
                                </div>
                            </form>
                        </div>
                    )}
                    
                    {/* History Tab */}
                     {activeTab === 'history' && (
                        <div className="text-center py-8 text-gray-500 dark:text-gray-400 text-sm">
                           Activity history will appear here.
                        </div>
                     )}
                </div>
            </div>

            {/* Sidebar */}
            <div className="w-full md:w-64 bg-gray-50/50 dark:bg-gray-900/50 p-6 flex flex-col gap-6 overflow-y-auto border-t md:border-t-0 border-gray-100 dark:border-gray-800">
                
                {/* PIC Info */}
                <div>
                    <h4 className="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <User size={14} /> Assignee
                    </h4>
                    <div className="flex items-center gap-3 bg-white dark:bg-gray-800 p-2 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                        <div className="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-300 flex items-center justify-center font-bold text-xs">
                            {task.pic?.name?.substring(0, 2).toUpperCase() || 'U'}
                        </div>
                        <div className="flex-1 min-w-0">
                            <p className="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {task.pic?.name || 'Unassigned'}
                            </p>
                        </div>
                    </div>
                </div>

                {/* Dates */}
                <div>
                    <h4 className="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <Clock size={14} /> Dates
                    </h4>
                    <div className="space-y-3">
                        {task.due_date && (
                            <div>
                                <label className="text-[10px] uppercase text-gray-500 dark:text-gray-400 font-semibold mb-1 block">Due Date</label>
                                <div className={clsx(
                                    "flex items-center gap-2 text-sm px-3 py-2 rounded-lg border",
                                    isPast(new Date(task.due_date)) && !isToday(new Date(task.due_date)) 
                                        ? "bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800"
                                        : "bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 shadow-sm"
                                )}>
                                    <Calendar size={14} />
                                    <span className="font-medium">{format(new Date(task.due_date), 'MMM d, yyyy')}</span>
                                </div>
                            </div>
                        )}
                         {task.request_date && (
                            <div>
                                <label className="text-[10px] uppercase text-gray-500 dark:text-gray-400 font-semibold mb-1 block">Request Date</label>
                                <div className="flex items-center gap-2 text-sm px-3 py-2 rounded-lg border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 shadow-sm">
                                    <Calendar size={14} />
                                    <span>{format(new Date(task.request_date), 'MMM d, yyyy')}</span>
                                </div>
                            </div>
                        )}
                    </div>
                </div>

                {/* Labels (Static representation) */}
                <div>
                    <h4 className="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <Tag size={14} /> Labels
                    </h4>
                    <div className="flex flex-wrap gap-2">
                        {task.labels?.map((label, i) => (
                            <span key={i} className="text-xs font-medium px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                {label}
                            </span>
                        )) || (
                            <span className="text-xs text-gray-400 italic">No labels</span>
                        )}
                        {isOwner && (
                            <button className="text-xs font-medium px-2.5 py-1 rounded-md bg-gray-50 dark:bg-gray-800/50 text-gray-500 border border-dashed border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center gap-1">
                                <Plus size={12} /> Add
                            </button>
                        )}
                    </div>
                </div>
                
                {/* Actions */}
                {isOwner && (
                    <div className="mt-auto pt-6">
                        <button className="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex items-center gap-2">
                            <Trash2 size={16} /> Delete Task
                        </button>
                    </div>
                )}
            </div>
        </div>
      </div>
    </div>
  );
}
