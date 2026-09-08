import React, { useState } from 'react';
import { usePage } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Calendar as CalendarIcon, ChevronLeft, ChevronRight, Filter } from 'lucide-react';
import { format, addMonths, subMonths, startOfMonth, endOfMonth, eachDayOfInterval, isSameMonth, isSameDay, startOfWeek, endOfWeek } from 'date-fns';

export default function CalendarView({ tasks = [] }) {
    const { auth } = usePage().props;
    const [currentDate, setCurrentDate] = useState(new Date());

    const nextMonth = () => setCurrentDate(addMonths(currentDate, 1));
    const prevMonth = () => setCurrentDate(subMonths(currentDate, 1));
    const today = () => setCurrentDate(new Date());

    const monthStart = startOfMonth(currentDate);
    const monthEnd = endOfMonth(monthStart);
    const startDate = startOfWeek(monthStart, { weekStartsOn: 1 }); // Monday start
    const endDate = endOfWeek(monthEnd, { weekStartsOn: 1 });

    const days = eachDayOfInterval({ start: startDate, end: endDate });

    // Group tasks by date
    const tasksByDate = tasks.reduce((acc, task) => {
        if (task.due_date) {
            const dateStr = format(new Date(task.due_date), 'yyyy-MM-dd');
            if (!acc[dateStr]) acc[dateStr] = [];
            acc[dateStr].push(task);
        }
        return acc;
    }, {});

    const getPriorityColor = (priority) => {
        switch (priority?.toLowerCase()) {
            case 'high': return 'bg-red-500';
            case 'medium': return 'bg-amber-500';
            case 'low': return 'bg-emerald-500';
            default: return 'bg-brand-500';
        }
    };

    return (
        <AuthenticatedLayout user={usePage().props.auth?.user}>
            <style>
                {`
                @media print {
                    .no-print { display: none !important; }
                    .print-only { display: block !important; }
                    body { background: white; }
                    .calendar-grid { border: 1px solid #e2e8f0; }
                    .calendar-cell { border: 1px solid #e2e8f0; page-break-inside: avoid; }
                }
                `}
            </style>
            
            {/* Filter Bar */}
            <div className="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-wrap gap-4 items-center no-print">
                <div className="flex items-center gap-2 text-gray-500 mr-2">
                    <Filter className="w-5 h-5" />
                    <span className="font-medium text-sm">Filters:</span>
                </div>
                <select className="border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Priority (All)</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
                <select className="border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Departemen (All)</option>
                    <option value="it">IT</option>
                    <option value="hr">HR</option>
                </select>
                <select className="border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Kategori Label (All)</option>
                    <option value="publikasi">Publikasi</option>
                    <option value="meeting">Meeting</option>
                </select>
            </div>

            <div className="py-2">
                <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 no-print">
                    <div>
                        <h1 className="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <CalendarIcon className="w-8 h-8 text-brand-500" />
                            Project Calendar
                        </h1>
                        <p className="text-slate-500 dark:text-slate-400 mt-1">Track task deadlines and milestones.</p>
                    </div>
                    
                    <div className="flex items-center gap-4">
                        <button 
                            onClick={today}
                            className="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl transition-all shadow-sm font-medium text-sm"
                        >
                            Today
                        </button>
                        <div className="flex items-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm">
                            <button 
                                onClick={prevMonth}
                                className="p-2 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 transition-colors"
                            >
                                <ChevronLeft className="w-5 h-5" />
                            </button>
                            <div className="px-4 font-semibold text-slate-900 dark:text-white min-w-[140px] text-center">
                                {format(currentDate, 'MMMM yyyy')}
                            </div>
                            <button 
                                onClick={nextMonth}
                                className="p-2 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 transition-colors"
                            >
                                <ChevronRight className="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>

                <div className="bg-white dark:bg-slate-900 rounded-2xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-800 calendar-grid">
                    <div className="grid grid-cols-7 border-b border-slate-200 dark:border-slate-800">
                        {['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].map(day => (
                            <div key={day} className="py-3 text-center text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider bg-slate-50 dark:bg-slate-800/50">
                                {day}
                            </div>
                        ))}
                    </div>
                    <div className="grid grid-cols-7 auto-rows-[120px]">
                        {days.map((day, idx) => {
                            const dateStr = format(day, 'yyyy-MM-dd');
                            const dayTasks = tasksByDate[dateStr] || [];
                            const isCurrentMonth = isSameMonth(day, currentDate);
                            const isTodayDate = isSameDay(day, new Date());

                            return (
                                <div 
                                    key={day.toString()} 
                                    className={`calendar-cell border-b border-r border-slate-200 dark:border-slate-800 p-2 transition-colors relative
                                        ${!isCurrentMonth ? 'bg-slate-50/50 dark:bg-slate-900/30' : 'bg-white dark:bg-slate-900'}
                                        ${idx % 7 === 6 ? 'border-r-0' : ''}
                                        hover:bg-slate-50 dark:hover:bg-slate-800/80 cursor-pointer
                                    `}
                                >
                                    <div className="flex justify-between items-start mb-2">
                                        <span className={`w-7 h-7 flex items-center justify-center rounded-full text-sm font-medium ${
                                            isTodayDate 
                                                ? 'bg-brand-500 text-white shadow-md shadow-brand-500/30' 
                                                : isCurrentMonth 
                                                    ? 'text-slate-900 dark:text-white' 
                                                    : 'text-slate-400 dark:text-slate-600'
                                        }`}>
                                            {format(day, 'd')}
                                        </span>
                                        {dayTasks.length > 0 && (
                                            <span className="text-xs font-semibold text-slate-400">
                                                {dayTasks.length}
                                            </span>
                                        )}
                                    </div>
                                    <div className="space-y-1 overflow-y-auto max-h-[70px] no-scrollbar">
                                        {dayTasks.map(task => (
                                            <div 
                                                key={task.id} 
                                                className="px-2 py-1 text-xs rounded border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm truncate flex items-center gap-1.5"
                                                title={task.title}
                                            >
                                                <div className={`w-1.5 h-1.5 rounded-full shrink-0 ${getPriorityColor(task.priority)}`}></div>
                                                <span className="text-slate-700 dark:text-slate-300 truncate">{task.title}</span>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
