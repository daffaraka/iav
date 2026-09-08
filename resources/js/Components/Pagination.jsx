import React from 'react';
import { Link } from '@inertiajs/react';

export default function Pagination({ links }) {
    if (links.length <= 3) return null;

    return (
        <div className="flex flex-wrap justify-center gap-1">
            {links.map((link, index) => {
                const isActive = link.active;
                const label = link.label.replace('&laquo; Previous', '«').replace('Next &raquo;', '»');

                if (link.url === null) {
                    return (
                        <div
                            key={index}
                            className="mr-1 mb-1 px-4 py-2 text-sm leading-4 text-slate-400 border border-transparent rounded-lg"
                        >
                            {label}
                        </div>
                    );
                }

                return (
                    <Link
                        key={index}
                        className={`mr-1 mb-1 px-4 py-2 text-sm leading-4 border rounded-lg focus:border-brand-500 focus:text-brand-500 transition-colors ${
                            isActive
                                ? 'bg-brand-600 text-white border-brand-600'
                                : 'bg-white dark:bg-surface-800 text-slate-700 dark:text-slate-300 border-surface-200 dark:border-surface-700 hover:bg-surface-50 dark:hover:bg-surface-700'
                        }`}
                        href={link.url}
                    >
                        {label}
                    </Link>
                );
            })}
        </div>
    );
}
