import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';
import { X, Calendar, User, AlignLeft, Flag } from 'lucide-react';
import clsx from 'clsx';

export default function CreateTaskModal({ isOpen, onClose, users, leadMeasureId, initialColumn }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    nama_tugas: '',
    deskripsi: '',
    priority: 'medium',
    column_id: initialColumn || 'new',
    pic_id: '',
    due_date: '',
    request_date: new Date().toISOString().split('T')[0],
    lead_measure_id: leadMeasureId || '',
  });

  if (!isOpen) return null;

  const handleSubmit = (e) => {
    e.preventDefault();
    post(route('kanban.task.store'), {
      onSuccess: () => {
        reset();
        onClose();
      },
    });
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
      <div 
        className="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"
        onClick={onClose}
      />
      
      <div className="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col max-h-[90vh] animate-in fade-in zoom-in duration-200">
        
        {/* Header */}
        <div className="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
          <h2 className="text-xl font-bold text-gray-900 dark:text-white">Create New Task</h2>
          <button 
            onClick={onClose}
            className="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 transition-colors"
          >
            <X size={20} />
          </button>
        </div>

        {/* Form Body */}
        <form onSubmit={handleSubmit} className="flex-1 overflow-y-auto p-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {/* Left Column */}
            <div className="space-y-5">
              <div>
                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Task Title <span className="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  value={data.nama_tugas}
                  onChange={e => setData('nama_tugas', e.target.value)}
                  className="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                  placeholder="What needs to be done?"
                  required
                />
                {errors.nama_tugas && <p className="mt-1 text-sm text-red-500">{errors.nama_tugas}</p>}
              </div>

              <div>
                <label className="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  <AlignLeft size={16} className="text-gray-400" />
                  Description
                </label>
                <textarea
                  value={data.deskripsi}
                  onChange={e => setData('deskripsi', e.target.value)}
                  rows={4}
                  className="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 shadow-sm resize-none"
                  placeholder="Add more details to this task..."
                />
              </div>

              <div className="flex gap-4">
                <div className="flex-1">
                  <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Priority
                  </label>
                  <select
                    value={data.priority}
                    onChange={e => setData('priority', e.target.value)}
                    className="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                  >
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                  </select>
                </div>
                
                <div className="flex-1">
                  <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Status (Column)
                  </label>
                  <select
                    value={data.column_id}
                    onChange={e => setData('column_id', e.target.value)}
                    className="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                  >
                    <option value="new">New</option>
                    <option value="progress">In Progress</option>
                    <option value="done">Done</option>
                  </select>
                </div>
              </div>
            </div>

            {/* Right Column */}
            <div className="space-y-5">
              <div>
                <label className="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  <User size={16} className="text-gray-400" />
                  Assignee (PIC) <span className="text-red-500">*</span>
                </label>
                <select
                  value={data.pic_id}
                  onChange={e => setData('pic_id', e.target.value)}
                  className="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                  required
                >
                  <option value="">Select Assignee</option>
                  {users?.map(user => (
                    <option key={user.id} value={user.id}>{user.name}</option>
                  ))}
                </select>
                {errors.pic_id && <p className="mt-1 text-sm text-red-500">{errors.pic_id}</p>}
              </div>

              <div>
                <label className="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  <Calendar size={16} className="text-gray-400" />
                  Due Date
                </label>
                <input
                  type="date"
                  value={data.due_date}
                  onChange={e => setData('due_date', e.target.value)}
                  className="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                />
              </div>
              
               <div>
                <label className="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  <Calendar size={16} className="text-gray-400" />
                  Request Date
                </label>
                <input
                  type="date"
                  value={data.request_date}
                  onChange={e => setData('request_date', e.target.value)}
                  className="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 shadow-sm"
                />
              </div>
            </div>
          </div>
          
          {/* Footer actions */}
          <div className="mt-8 pt-5 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-3">
            <button
              type="button"
              onClick={onClose}
              className="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors"
            >
              Cancel
            </button>
            <button
              type="submit"
              disabled={processing}
              className="px-4 py-2 text-sm font-medium text-white bg-brand-500 border border-transparent rounded-lg hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 disabled:opacity-50 transition-colors shadow-sm"
            >
              {processing ? 'Creating...' : 'Create Task'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
