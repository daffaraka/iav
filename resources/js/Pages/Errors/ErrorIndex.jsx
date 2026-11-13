import React from 'react';
import { Head } from '@inertiajs/react';
import ErrorHeader from './Components/ErrorHeader';
import ErrorIllustration from './Components/ErrorIllustration';
import ErrorActionButtons from './Components/ErrorActionButtons';
import ErrorDetailsCard from './Components/ErrorDetailsCard';
import ErrorPreviewBar from './Components/ErrorPreviewBar';

export default function ErrorIndex({ error, authContext, navigation, preview }) {
    return (
        <div className="min-h-screen bg-surface-50 dark:bg-surface-900 text-slate-800 dark:text-slate-200 font-sans antialiased selection:bg-brand-100 selection:text-brand-900 transition-colors duration-300 flex flex-col justify-between px-4 py-5 sm:px-6 sm:py-8 relative overflow-hidden">
            <Head title={`${error.status} - ${error.title}`} />

            <div className="pointer-events-none fixed inset-0 overflow-hidden -z-0">
                <div className="absolute -top-32 left-1/2 -translate-x-1/2 w-[540px] h-[300px] rounded-full bg-brand-500/5 dark:bg-brand-500/10 blur-3xl" />
            </div>

            <div className="relative z-10 w-full">
                <ErrorHeader homeUrl={navigation.homeUrl} authContext={authContext} />
            </div>

            <main className="relative z-10 w-full max-w-2xl mx-auto my-auto">
                {preview?.enabled && (
                    <ErrorPreviewBar currentStatus={error.status} statuses={preview.statuses} />
                )}

                <section className="bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 rounded-3xl shadow-soft p-6 sm:p-10 text-center">
                    <ErrorIllustration
                        status={error.status}
                        codeLabel={error.codeLabel}
                        category={error.category}
                    />

                    <div className="mt-6 space-y-3 max-w-lg mx-auto">
                        <h1 className="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                            {error.title}
                        </h1>
                        <p className="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed">
                            {error.description}
                        </p>
                    </div>

                    {error.detail && (
                        <div className="mt-4 max-w-lg mx-auto px-4 py-2.5 rounded-xl bg-surface-100 dark:bg-surface-900/70 border border-surface-200 dark:border-surface-700 text-xs sm:text-sm text-slate-700 dark:text-slate-300 break-words">
                            {error.detail}
                        </div>
                    )}

                    <div className="mt-7">
                        <ErrorActionButtons
                            primaryAction={error.primaryAction}
                            navigation={navigation}
                            isAuthenticated={authContext?.isAuthenticated}
                        />
                    </div>

                    <ErrorDetailsCard error={error} />
                </section>
            </main>

            <footer className="relative z-10 w-full max-w-3xl mx-auto pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500 dark:text-slate-400">
                <span>&copy; {new Date().getFullYear()} Internal Avicenna School System</span>
                <a
                    href={navigation.supportUrl}
                    className="font-semibold text-brand-600 dark:text-brand-400 hover:underline py-1"
                >
                    Butuh bantuan? Buka Helpdesk AQR
                </a>
            </footer>
        </div>
    );
}
