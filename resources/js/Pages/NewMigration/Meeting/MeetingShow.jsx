import React from 'react';
import { usePage, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { ArrowLeft, Edit, Trash2, Calendar, Clock, FileText, Download, Users } from 'lucide-react';

export default function MeetingShow({ meeting = {} }) {
    const { auth } = usePage().props;

    const handleDelete = () => {
        if(confirm('Are you sure you want to delete this meeting?')) {
            router.delete(route ? route('kanban.meeting.destroy', meeting.id) : `/kanban/meeting/${meeting.id}`);
        }
    };

    return (
        <AuthenticatedLayout user={auth?.user}>
            <div className="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
                <div className="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <Link href={route ? route('kanban.meeting.index') : '/kanban/meeting'} className="inline-flex items-center gap-2 text-slate-500 hover:text-brand-500 transition-colors">
                        <ArrowLeft className="w-4 h-4" />
                        <span>Back to Meetings</span>
                    </Link>
                    <div className="flex gap-3">
                        <Link 
                            href={route ? route('kanban.meeting.edit', meeting.id) : `/kanban/meeting/${meeting.id}/edit`}
                            className="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl transition-all shadow-sm"
                        >
                            <Edit className="w-4 h-4" />
                            <span>Edit</span>
                        </Link>
                        <button 
                            onClick={handleDelete}
                            className="inline-flex items-center gap-2 px-4 py-2 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 rounded-xl transition-all shadow-sm"
                        >
                            <Trash2 className="w-4 h-4" />
                            <span>Delete</span>
                        </button>
                    </div>
                </div>

                <div className="bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-2xl shadow-xl overflow-hidden mb-8">
                    <div className="p-8 border-b border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/30">
                        <div className="flex items-center gap-3 mb-4">
                            <div className="w-12 h-12 bg-brand-100 dark:bg-brand-500/20 text-brand-600 dark:text-brand-400 rounded-xl flex items-center justify-center">
                                <Users className="w-6 h-6" />
                            </div>
                            <h1 className="text-3xl font-bold text-slate-900 dark:text-white">
                                {meeting.meeting_name}
                            </h1>
                        </div>
                        
                        <div className="flex flex-wrap gap-6 mt-6">
                            <div className="flex items-center gap-2 text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                                <Calendar className="w-5 h-5 text-brand-500" />
                                <span className="font-medium">{new Date(meeting.meeting_date_start).toLocaleDateString()}</span>
                            </div>
                            <div className="flex items-center gap-2 text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                                <Clock className="w-5 h-5 text-brand-500" />
                                <span className="font-medium">{new Date(meeting.meeting_date_start).toLocaleTimeString()}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div className="p-8 space-y-8">
                        <div>
                            <h3 className="text-lg font-semibold text-slate-900 dark:text-white mb-3">Description</h3>
                            <div className="text-slate-600 dark:text-slate-300 whitespace-pre-wrap bg-slate-50 dark:bg-slate-800/50 p-6 rounded-xl border border-slate-100 dark:border-slate-700/50">
                                {meeting.meeting_description || 'No description provided.'}
                            </div>
                        </div>

                        <div>
                            <h3 className="text-lg font-semibold text-slate-900 dark:text-white mb-3">Notes / Minutes</h3>
                            <div className="text-slate-600 dark:text-slate-300 whitespace-pre-wrap bg-slate-50 dark:bg-slate-800/50 p-6 rounded-xl border border-slate-100 dark:border-slate-700/50 min-h-[150px]">
                                {meeting.meeting_notes || 'No notes provided yet.'}
                            </div>
                        </div>

                        {meeting.meeting_document && (
                            <div>
                                <h3 className="text-lg font-semibold text-slate-900 dark:text-white mb-3">Attached Document</h3>
                                <a 
                                    href={`/storage/${meeting.meeting_document}`} 
                                    target="_blank"
                                    rel="noreferrer"
                                    className="inline-flex items-center gap-3 p-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-brand-500 dark:hover:border-brand-500 rounded-xl transition-all group shadow-sm"
                                >
                                    <div className="w-10 h-10 bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <FileText className="w-5 h-5" />
                                    </div>
                                    <div className="flex-1">
                                        <div className="text-sm font-medium text-slate-900 dark:text-white group-hover:text-brand-500 transition-colors">
                                            Meeting Document
                                        </div>
                                        <div className="text-xs text-slate-500">Click to view or download</div>
                                    </div>
                                    <Download className="w-5 h-5 text-slate-400 group-hover:text-brand-500 transition-colors" />
                                </a>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
