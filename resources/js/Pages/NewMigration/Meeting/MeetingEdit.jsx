import React, { useState } from 'react';
import { usePage, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { ArrowLeft, Save, Upload, FileText } from 'lucide-react';

export default function MeetingEdit({ meeting }) {
    const { auth } = usePage().props;
    
    // Helper to format date for datetime-local input
    const formatDate = (dateStr) => {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        return new Date(d.getTime() - d.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
    };

    const [data, setData] = useState({
        meeting_name: meeting?.meeting_name || '',
        meeting_description: meeting?.meeting_description || '',
        meeting_notes: meeting?.meeting_notes || '',
        meeting_document: null,
        meeting_date_start: formatDate(meeting?.meeting_date_start)
    });

    const submit = (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('_method', 'PUT'); // For Laravel parsing
        
        Object.keys(data).forEach(key => {
            if (data[key] !== null) {
                formData.append(key, data[key]);
            }
        });
        
        router.post(route ? route('kanban.meeting.update', meeting.id) : `/kanban/meeting/${meeting.id}`, formData, {
            forceFormData: true,
        });
    };

    return (
        <AuthenticatedLayout user={auth?.user}>
            <div className="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
                <div className="mb-6">
                    <Link href={route ? route('kanban.meeting.index') : '/kanban/meeting'} className="inline-flex items-center gap-2 text-slate-500 hover:text-brand-500 transition-colors">
                        <ArrowLeft className="w-4 h-4" />
                        <span>Back to Meetings</span>
                    </Link>
                </div>

                <div className="bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl border border-white/20 dark:border-slate-800/50 rounded-2xl shadow-xl overflow-hidden p-8">
                    <h2 className="text-2xl font-bold text-slate-900 dark:text-white mb-6">Edit Meeting</h2>
                    
                    <form onSubmit={submit} className="space-y-6">
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Meeting Name</label>
                            <input 
                                type="text" 
                                value={data.meeting_name}
                                onChange={e => setData({...data, meeting_name: e.target.value})}
                                className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                                required
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Date & Time</label>
                            <input 
                                type="datetime-local" 
                                value={data.meeting_date_start}
                                onChange={e => setData({...data, meeting_date_start: e.target.value})}
                                className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                                required
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Description</label>
                            <textarea 
                                rows="3"
                                value={data.meeting_description}
                                onChange={e => setData({...data, meeting_description: e.target.value})}
                                className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Notes</label>
                            <textarea 
                                rows="5"
                                value={data.meeting_notes}
                                onChange={e => setData({...data, meeting_notes: e.target.value})}
                                className="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-colors"
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Document Attachment</label>
                            
                            {meeting.meeting_document && (
                                <div className="mb-3 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center gap-3">
                                    <FileText className="w-5 h-5 text-brand-500" />
                                    <span className="text-sm text-slate-700 dark:text-slate-300 flex-1">Current document attached</span>
                                </div>
                            )}

                            <div className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 dark:border-slate-700 border-dashed rounded-xl hover:border-brand-500 transition-colors group">
                                <div className="space-y-1 text-center">
                                    <Upload className="mx-auto h-12 w-12 text-slate-400 group-hover:text-brand-500 transition-colors" />
                                    <div className="flex text-sm text-slate-600 dark:text-slate-400 justify-center">
                                        <label htmlFor="file-upload" className="relative cursor-pointer bg-white dark:bg-slate-800 rounded-md font-medium text-brand-500 hover:text-brand-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-500 px-1">
                                            <span>Upload a new file</span>
                                            <input 
                                                id="file-upload" 
                                                name="file-upload" 
                                                type="file" 
                                                className="sr-only" 
                                                onChange={e => setData({...data, meeting_document: e.target.files[0]})}
                                            />
                                        </label>
                                        <p className="pl-1">to replace current</p>
                                    </div>
                                    <p className="text-xs text-slate-500">
                                        {data.meeting_document ? data.meeting_document.name : 'PDF, DOCX, XLSX up to 10MB'}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div className="pt-4 flex justify-end">
                            <button 
                                type="submit"
                                className="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-xl transition-all shadow-lg shadow-brand-500/30 font-medium"
                            >
                                <Save className="w-5 h-5" />
                                <span>Update Meeting</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
