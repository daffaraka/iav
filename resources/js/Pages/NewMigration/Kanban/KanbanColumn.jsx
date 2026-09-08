import React, { useMemo } from 'react';
import { SortableContext, verticalListSortingStrategy } from '@dnd-kit/sortable';
import { useDroppable } from '@dnd-kit/core';
import KanbanCard from './KanbanCard';
import clsx from 'clsx';
import { Plus } from 'lucide-react';

export default function KanbanColumn({ column, tasks, onTaskClick, onAddTask }) {
  const { setNodeRef, isOver } = useDroppable({
    id: column.id,
    data: {
      type: 'Column',
      column,
    },
  });

  const taskIds = useMemo(() => tasks.map((t) => t.id), [tasks]);

  const getColumnColor = (id) => {
    switch (id) {
      case 'new': return 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20';
      case 'progress': return 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20';
      case 'done': return 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20';
      default: return 'bg-gray-500/10 text-gray-600 dark:text-gray-400 border-gray-500/20';
    }
  };

  const getIndicatorColor = (id) => {
    switch (id) {
      case 'new': return 'bg-blue-500';
      case 'progress': return 'bg-amber-500';
      case 'done': return 'bg-emerald-500';
      default: return 'bg-gray-500';
    }
  };

  return (
    <div className="flex flex-col w-[320px] min-w-[320px] max-w-[320px] h-full">
      {/* Column Header */}
      <div className={clsx(
        "flex flex-col gap-1 p-3 mb-3 rounded-xl border glass-panel transition-colors duration-200",
        isOver && "border-brand-400/50 dark:border-brand-500/50"
      )}>
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-2">
            <div className={clsx("w-2.5 h-2.5 rounded-full shadow-sm", getIndicatorColor(column.id))} />
            <h3 className="font-semibold text-gray-800 dark:text-gray-200 text-sm">{column.title}</h3>
          </div>
          <div className={clsx(
            "text-xs font-semibold px-2 py-0.5 rounded-full border",
            getColumnColor(column.id)
          )}>
            {tasks.length}
          </div>
        </div>
        <button
          onClick={() => onAddTask(column.id)}
          className="w-full flex items-center justify-center gap-1 py-1.5 mt-2 text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg transition-colors border border-dashed border-transparent hover:border-gray-200 dark:hover:border-gray-700"
        >
          <Plus size={14} /> Add Task
        </button>
      </div>

      {/* Droppable Area */}
      <div
        ref={setNodeRef}
        className={clsx(
          "flex-1 flex flex-col gap-3 p-2 -mx-2 rounded-xl transition-colors duration-200 overflow-y-auto overflow-x-hidden kanban-column-scroll",
          isOver ? "bg-brand-50/50 dark:bg-brand-900/10 border border-brand-200/50 dark:border-brand-700/30" : "bg-transparent border border-transparent"
        )}
      >
        <SortableContext items={taskIds} strategy={verticalListSortingStrategy}>
          {tasks.map((task) => (
            <KanbanCard
              key={task.id}
              task={task}
              onClick={onTaskClick}
            />
          ))}
          {tasks.length === 0 && (
            <div className="flex flex-col items-center justify-center h-24 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-800 text-gray-400 dark:text-gray-600 text-sm font-medium">
              No tasks
            </div>
          )}
        </SortableContext>
      </div>
    </div>
  );
}
