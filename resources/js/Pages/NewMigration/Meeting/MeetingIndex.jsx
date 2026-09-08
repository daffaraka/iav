import React from 'react';
import { usePage, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Users, Plus, Calendar, Clock, FileText } from 'lucide-react';

export default function MeetingIndex({ meetings = { data: [] } }) {
    const { auth } = usePage().props;

    return (
        <AuthenticatedLayout user={auth?.user}>
            <div className="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                    <div>
                        <h1 className="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <Users className="w-8 h-8 text-brand-500" />
                            Meetings
                        </h1>
                        <p className="text-slate-500 dark:text-slate-400 mt-1">Manage and track your meetings.</p>
                    </div>
                    <Link
                        href={route ? route('kanban.meeting.create') : '/kanban/meeting/create'}
                        className="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white rounded-xl transition-all shadow-lg shadow-brand-500/30"
                    >
                        <Plus className="w-5 h-5" />
                        <span>Schedule Meeting</span>
                    </Link>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {meetings.data.length > 0 ? (
                        meetings.data.map(meeting => (
                            <div 
                                key={meeting.id} 
                                onClick={() => router.get(route ? route('kanban.meeting.show', meeting.id) : `/kanban/meeting/${meeting.id}`)}
                                className="bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-2xl shadow-lg p-6 hover:shadow-xl hover:border-brand-500/30 transition-all cursor-pointer group flex flex-col"
                            >
                                <div className="flex-1">
                                    <h3 className="text-xl font-bold text-slate-900 dark:text-white group-hover:text-brand-500 transition-colors mb-3">
                                        {meeting.meeting_name}
                                    </h3>
                                    <p className="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-3">
                                        {meeting.meeting_description}
                                    </p>
                                </div>
                                
                                <div className="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700/50 flex flex-col gap-2">
                                    <div className="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                        <Calendar className="w-4 h-4 text-brand-500" />
                                        <span>{new Date(meeting.meeting_date_start).toLocaleDateString()}</span>
                                    </div>
                                    <div className="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                        <Clock className="w-4 h-4 text-brand-500" />
                                        <span>{new Date(meeting.meeting_date_start).toLocaleTimeString()}</span>
                                    </div>
                                    {meeting.meeting_document && (
                                        <div className="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                            <FileText className="w-4 h-4 text-brand-500" />
                                            <span>Document Attached</span>
                                        </div>
                                    )}
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="col-span-full bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl border border-dashed border-slate-300 dark:border-slate-700 rounded-2xl p-12 text-center text-slate-500">
                            No meetings found.
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
