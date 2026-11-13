import React, { useState } from 'react';
import { Link } from '@inertiajs/react';
import { useTheme } from '../../../Contexts/ThemeContext';

function ThemeToggleIcon({ isDarkMode }) {
    if (isDarkMode) {
        return (
            <svg viewBox="0 0 20 20" fill="none" className="w-5 h-5" aria-hidden="true">
                <circle cx="10" cy="10" r="3.75" fill="currentColor" fillOpacity="0.18" stroke="currentColor" strokeWidth="1.6" />
                <path d="M10 2.5V4M10 16V17.5M17.5 10H16M4 10H2.5M15.3 4.7L14.2 5.8M5.8 14.2L4.7 15.3M15.3 15.3L14.2 14.2M5.8 5.8L4.7 4.7" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" />
            </svg>
        );
    }

    return (
        <svg viewBox="0 0 20 20" fill="none" className="w-5 h-5" aria-hidden="true">
            <path
                d="M15.8 12.6A6.5 6.5 0 0 1 7.4 4.2a6.5 6.5 0 1 0 8.4 8.4Z"
                fill="currentColor"
                fillOpacity="0.16"
                stroke="currentColor"
                strokeWidth="1.6"
                strokeLinejoin="round"
            />
        </svg>
    );
}

export default function ErrorHeader({ homeUrl, authContext }) {
    const { isDarkMode, setIsDarkMode } = useTheme();
    const [logoFailed, setLogoFailed] = useState(false);

    return (
        <header className="w-full max-w-3xl mx-auto flex items-center justify-between gap-4 pb-6">
            <Link href={homeUrl} className="flex items-center gap-3 group">
                {!logoFailed ? (
                    <div className="inline-flex items-center rounded-xl transition-colors dark:bg-white/95 dark:px-2.5 dark:py-1 dark:shadow-sm">
                        <img
                            src="/image/logo_baru.png"
                            alt="Avicenna Leadership School"
                            onError={() => setLogoFailed(true)}
                            className="h-7 sm:h-8 w-auto object-contain"
                        />
                    </div>
                ) : (
                    <div className="flex items-center gap-2.5">
                        <div className="w-9 h-9 rounded-xl bg-brand-600 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                            A
                        </div>
                        <div className="flex flex-col">
                            <span className="text-sm font-bold text-slate-800 dark:text-white leading-tight">
                                Avicenna
                            </span>
                            <span className="text-[10px] font-semibold tracking-wider uppercase text-brand-600 dark:text-brand-400">
                                School System
                            </span>
                        </div>
                    </div>
                )}
            </Link>

            <div className="flex items-center gap-2.5">
                {authContext?.isAuthenticated && authContext.userName && (
                    <span className="hidden sm:inline-flex items-center px-3 py-1.5 rounded-xl bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 text-xs font-medium text-slate-600 dark:text-slate-300">
                        {authContext.userName}
                    </span>
                )}

                <button
                    type="button"
                    onClick={() => setIsDarkMode(!isDarkMode)}
                    title={isDarkMode ? 'Aktifkan Mode Terang' : 'Aktifkan Mode Gelap'}
                    aria-label={isDarkMode ? 'Aktifkan Mode Terang' : 'Aktifkan Mode Gelap'}
                    className="min-w-[42px] min-h-[42px] p-2.5 rounded-xl bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 text-slate-600 dark:text-slate-300 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors flex items-center justify-center"
                >
                    <ThemeToggleIcon isDarkMode={isDarkMode} />
                </button>
            </div>
        </header>
    );
}
