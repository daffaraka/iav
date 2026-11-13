import React from 'react';
import { Link } from '@inertiajs/react';

export default function ErrorPreviewBar({ currentStatus, statuses = [] }) {
    if (!statuses.length) return null;

    return (
        <div className="mb-6 bg-white/90 dark:bg-surface-800/90 backdrop-blur border border-surface-200 dark:border-surface-700 rounded-2xl p-3 sm:p-4 shadow-softer">
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <p className="text-xs font-bold uppercase tracking-wider text-brand-600 dark:text-brand-400">
                        Mode Pratinjau Halaman Error
                    </p>
                    <p className="text-xs text-slate-500 dark:text-slate-400">
                        Pilih kode status untuk meninjau tampilan setiap kondisi error.
                    </p>
                </div>

                <div className="flex flex-wrap items-center gap-1.5">
                    {statuses.map((item) => {
                        const isActive = Number(item.status) === Number(currentStatus);

                        return (
                            <Link
                                key={item.status}
                                href={`/errors/preview/${item.status}`}
                                title={item.title}
                                className={`px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors ${
                                    isActive
                                        ? 'bg-brand-600 text-white shadow-sm'
                                        : 'bg-surface-100 dark:bg-surface-700 text-slate-600 dark:text-slate-300 hover:bg-surface-200 dark:hover:bg-surface-600'
                                }`}
                            >
                                {item.status}
                            </Link>
                        );
                    })}
                </div>
            </div>
        </div>
    );
}
