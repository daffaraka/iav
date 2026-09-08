import React, { useState, useMemo } from 'react';
import {
  DndContext,
  DragOverlay,
  closestCorners,
  KeyboardSensor,
  PointerSensor,
  useSensor,
  useSensors,
  defaultDropAnimationSideEffects,
} from '@dnd-kit/core';
import { sortableKeyboardCoordinates, arrayMove } from '@dnd-kit/sortable';
import KanbanColumn from './KanbanColumn';
import KanbanCard from './KanbanCard';
import { router } from '@inertiajs/react';

const COLUMNS = [
  { id: 'new', title: 'New' },
  { id: 'progress', title: 'In Progress' },
  { id: 'done', title: 'Done' }
];

export default function KanbanBoard({ initialTasks, auth, onTaskClick, onAddTask }) {
  const [tasks, setTasks] = useState(initialTasks || []);
  const [activeTask, setActiveTask] = useState(null);

  const columns = useMemo(() => COLUMNS, []);

  const sensors = useSensors(
    useSensor(PointerSensor, {
      activationConstraint: {
        distance: 5,
      },
    }),
    useSensor(KeyboardSensor, {
      coordinateGetter: sortableKeyboardCoordinates,
    })
  );

  const handleDragStart = (event) => {
    const { active } = event;
    const task = tasks.find((t) => t.id === active.id);
    
    // Check ownership
    if (task && auth.user.id !== task.pic_id && auth.user.role !== 'admin') {
      // Could trigger a toast or shake animation here via global state/ref
      return;
    }
    
    setActiveTask(task);
  };

  const handleDragOver = (event) => {
    const { active, over } = event;
    if (!over) return;

    const activeId = active.id;
    const overId = over.id;

    if (activeId === overId) return;

    const isActiveTask = active.data.current?.type === 'Task';
    const isOverTask = over.data.current?.type === 'Task';
    const isOverColumn = over.data.current?.type === 'Column';

    if (!isActiveTask) return;

    // Dropping a Task over another Task
    if (isActiveTask && isOverTask) {
      setTasks((tasks) => {
        const activeIndex = tasks.findIndex((t) => t.id === activeId);
        const overIndex = tasks.findIndex((t) => t.id === overId);

        if (tasks[activeIndex].column_id !== tasks[overIndex].column_id) {
          const newTasks = [...tasks];
          newTasks[activeIndex].column_id = tasks[overIndex].column_id;
          return arrayMove(newTasks, activeIndex, overIndex);
        }

        return arrayMove(tasks, activeIndex, overIndex);
      });
    }

    // Dropping a Task over an empty Column
    if (isActiveTask && isOverColumn) {
      setTasks((tasks) => {
        const activeIndex = tasks.findIndex((t) => t.id === activeId);
        const newTasks = [...tasks];
        newTasks[activeIndex].column_id = overId;
        return arrayMove(newTasks, activeIndex, activeIndex);
      });
    }
  };

  const handleDragEnd = (event) => {
    setActiveTask(null);
    const { active, over } = event;
    if (!over) return;

    const activeId = active.id;
    const overId = over.id;
    
    const activeTask = tasks.find((t) => t.id === activeId);
    
    // Check if task actually moved column
    const initialTask = initialTasks.find(t => t.id === activeId);
    if (activeTask && initialTask && activeTask.column_id !== initialTask.column_id) {
        // Persist to backend
        router.post(route('kanban.task.move', activeId), {
            column_id: activeTask.column_id,
            // position could be added here if backend supports ordering
        }, {
            preserveScroll: true,
            preserveState: true,
            onError: () => {
                // Revert on error
                setTasks(initialTasks);
            }
        });
    }
  };

  const dropAnimation = {
    sideEffects: defaultDropAnimationSideEffects({
      styles: {
        active: {
          opacity: '0.5',
        },
      },
    }),
  };

  return (
    <div className="h-full flex overflow-x-auto pb-4 gap-6 pt-2 kanban-column-scroll">
      <DndContext
        sensors={sensors}
        collisionDetection={closestCorners}
        onDragStart={handleDragStart}
        onDragOver={handleDragOver}
        onDragEnd={handleDragEnd}
      >
        {columns.map((col) => (
          <KanbanColumn
            key={col.id}
            column={col}
            tasks={tasks.filter((task) => task.column_id === col.id)}
            onTaskClick={onTaskClick}
            onAddTask={onAddTask}
          />
        ))}

        <DragOverlay dropAnimation={dropAnimation}>
          {activeTask ? <KanbanCard task={activeTask} isOverlay /> : null}
        </DragOverlay>
      </DndContext>
    </div>
  );
}
