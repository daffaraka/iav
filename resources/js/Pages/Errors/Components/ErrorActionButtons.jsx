import React from 'react';
import { Link, router } from '@inertiajs/react';
import ErrorActionIcon from './ErrorActionIcon';

const primaryBtnClass =
    'w-full sm:w-auto min-h-[46px] px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors inline-flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-brand-500/40';

const secondaryBtnClass =
    'w-full sm:w-auto min-h-[46px] px-5 py-2.5 bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 text-slate-700 dark:text-slate-200 hover:bg-surface-100 dark:hover:bg-surface-700 text-sm font-semibold rounded-xl transition-colors inline-flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-brand-500/30';

export default function ErrorActionButtons({ primaryAction, navigation, isAuthenticated }) {
    const handleGoBack = () => {
        if (window.history.length > 1) {
            window.history.back();
            return;
        }
        router.visit(navigation.homeUrl);
    };

    const handleReload = () => {
        window.location.reload();
    };

    return (
        <div className="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center justify-center gap-3 pt-2">
            {primaryAction === 'reload' && (
                <button type="button" onClick={handleReload} className={primaryBtnClass}>
                    <ErrorActionIcon primaryAction="reload" />
                    <span>Muat Ulang Halaman</span>
                </button>
            )}

            {primaryAction === 'login' && (
                <Link href={navigation.loginUrl} className={primaryBtnClass}>
                    <ErrorActionIcon primaryAction="login" />
                    <span>Masuk ke Akun</span>
                </Link>
            )}

            {primaryAction === 'back' && (
                <button type="button" onClick={handleGoBack} className={primaryBtnClass}>
                    <ErrorActionIcon primaryAction="back" />
                    <span>Halaman Sebelumnya</span>
                </button>
            )}

            {primaryAction === 'home' && (
                <Link href={navigation.homeUrl} className={primaryBtnClass}>
                    <ErrorActionIcon primaryAction="home" />
                    <span>{navigation.homeLabel}</span>
                </Link>
            )}

            {primaryAction !== 'back' && (
                <button type="button" onClick={handleGoBack} className={secondaryBtnClass}>
                    Halaman Sebelumnya
                </button>
            )}

            {primaryAction !== 'home' && (
                <Link href={navigation.homeUrl} className={secondaryBtnClass}>
                    {navigation.homeLabel}
                </Link>
            )}

            {!isAuthenticated && primaryAction !== 'login' && (
                <Link href={navigation.loginUrl} className={secondaryBtnClass}>
                    Masuk Sistem
                </Link>
            )}
        </div>
    );
}
