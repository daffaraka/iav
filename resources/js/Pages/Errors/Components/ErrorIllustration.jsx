import React from 'react';
import ErrorCategorySvg from './ErrorCategorySvg';
import { getErrorTheme } from './errorThemeConfig';

export default function ErrorIllustration({ status, codeLabel, category }) {
    const theme = getErrorTheme(category);

    return (
        <div className="flex flex-col items-center text-center">
            <div
                className={`w-20 h-20 sm:w-24 sm:h-24 rounded-2xl border flex items-center justify-center mb-5 transition-colors ${theme.illustrationBoxClass}`}
            >
                <ErrorCategorySvg category={category} className="w-11 h-11 sm:w-12 sm:h-12" />
            </div>

            <div className="flex flex-col items-center gap-2">
                <span
                    className={`inline-flex items-center px-3 py-1 rounded-full border text-[11px] font-bold tracking-widest uppercase ${theme.badgeClass}`}
                >
                    HTTP {status} &middot; {codeLabel}
                </span>

                <p
                    className={`text-5xl sm:text-7xl font-extrabold tracking-tight leading-none select-none mt-1 ${theme.codeTextClass}`}
                >
                    {status}
                </p>
            </div>
        </div>
    );
}
