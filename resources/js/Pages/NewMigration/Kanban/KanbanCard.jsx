import React, { useState } from 'react';
import { useSortable } from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';
import { Calendar, CheckSquare, MessageSquare, AlertCircle, Clock } from 'lucide-react';
import { format, isPast, isToday, addDays } from 'date-fns';
import clsx from 'clsx';

export default function KanbanCard({ task, onClick, isOverlay = false }) {
  const [shake, setShake] = useState(false);

  const {
    attributes,
    listeners,
    setNodeRef,
    transform,
    transition,
    isDragging,
  } = useSortable({
    id: task.id,
    data: {
      type: 'Task',
      task,
    },
  });

  const style = {
    transform: CSS.Transform.toString(transform),
    transition,
    opacity: isDragging ? 0.3 : 1,
  };

  const triggerShake = () => {
    setShake(true);
    setTimeout(() => setShake(false), 500);
  };

  const getPriorityColors = (priority) => {
    switch (priority?.toLowerCase()) {
      case 'high':
        return 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border-red-200 dark:border-red-800/50';
      case 'medium':
        return 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border-amber-200 dark:border-amber-800/50';
      case 'low':
        return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50';
      default:
        return 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700';
    }
  };

  const getLabelColors = (label) => {
    switch (label?.toLowerCase()) {
      case 'bug': return 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400';
      case 'feature': return 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400';
      case 'urgent': return 'bg-orange-50 text-orange-600 dark:bg-orange-900/20 dark:text-orange-400';
      case 'documentation': return 'bg-teal-50 text-teal-600 dark:bg-teal-900/20 dark:text-teal-400';
      case 'design': return 'bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400';
      default: return 'bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-400';
    }
  };

  const isDueWarning = task.due_date && (isPast(new Date(task.due_date)) || isToday(new Date(task.due_date)));
  const checklistTotal = task.checklists?.length || 0;
  const checklistDone = task.checklists?.filter(c => c.is_completed).length || 0;
  const checklistProgress = checklistTotal > 0 ? (checklistDone / checklistTotal) * 100 : 0;

  return (
    <div
      ref={setNodeRef}
      style={style}
      className={clsx(
        'group relative w-full rounded-xl p-4 cursor-grab active:cursor-grabbing',
        'glass-card glass-card-hover',
        isOverlay && 'drag-overlay-card',
        shake && 'shake',
        'font-sans'
      )}
      {...attributes}
      {...listeners}
      onClick={() => onClick && onClick(task)}
    >
      <div className="flex flex-col gap-3">
        {/* Labels & Priority */}
        <div className="flex flex-wrap items-center justify-between gap-2">
          <div className="flex flex-wrap gap-1">
            {task.labels?.map((label, i) => (
              <span key={i} className={clsx('text-[10px] font-semibold px-2 py-0.5 rounded-full', getLabelColors(label))}>
                {label}
              </span>
            ))}
          </div>
          {task.priority && (
            <span className={clsx('text-[10px] font-bold px-2 py-0.5 rounded-full border', getPriorityColors(task.priority))}>
              {task.priority.toUpperCase()}
            </span>
          )}
        </div>

        {/* Title */}
        <h4 className="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-2">
          {task.nama_tugas || task.title}
        </h4>

        {/* Info Row */}
        <div className="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
          <div className="flex items-center gap-3">
            {task.due_date && (
              <div className={clsx("flex items-center gap-1", isDueWarning && "text-red-500 dark:text-red-400 font-medium")}>
                {isDueWarning ? <AlertCircle size={12} /> : <Clock size={12} />}
                <span>{format(new Date(task.due_date), 'MMM d')}</span>
              </div>
            )}
            {checklistTotal > 0 && (
              <div className="flex items-center gap-1" title={`${checklistDone}/${checklistTotal} Checklist`}>
                <CheckSquare size={12} className={checklistDone === checklistTotal ? 'text-brand-500' : ''} />
                <span className={checklistDone === checklistTotal ? 'text-brand-500 font-medium' : ''}>
                  {checklistDone}/{checklistTotal}
                </span>
              </div>
            )}
            {task.comments_count > 0 && (
              <div className="flex items-center gap-1">
                <MessageSquare size={12} />
                <span>{task.comments_count}</span>
              </div>
            )}
          </div>

          {/* PIC Avatar */}
          {task.pic && (
            <div className="flex items-center" title={task.pic.name}>
              {task.pic.avatar ? (
                <img src={task.pic.avatar} alt={task.pic.name} className="w-6 h-6 rounded-full border-2 border-white dark:border-gray-800" />
              ) : (
                <div className="w-6 h-6 rounded-full bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-300 flex items-center justify-center text-[10px] font-bold border-2 border-white dark:border-gray-800">
                  {task.pic.name?.substring(0, 2).toUpperCase()}
                </div>
              )}
            </div>
          )}
        </div>
        
        {/* Progress Bar for Checklists */}
        {checklistTotal > 0 && (
          <div className="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-1 mt-1 overflow-hidden">
            <div 
              className={clsx(
                "h-1 rounded-full transition-all duration-500",
                checklistDone === checklistTotal ? "bg-brand-500" : "bg-brand-400/70"
              )}
              style={{ width: `${checklistProgress}%` }}
            />
          </div>
        )}
      </div>
    </div>
  );
}
