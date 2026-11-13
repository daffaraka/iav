export const ERROR_THEME_MAP = {
    not_found: {
        badgeClass:
            'bg-brand-50 text-brand-700 border-brand-200/80 dark:bg-brand-500/10 dark:text-brand-300 dark:border-brand-500/25',
        illustrationBoxClass:
            'bg-brand-50/90 text-brand-600 border-brand-200/70 dark:bg-brand-500/10 dark:text-brand-400 dark:border-brand-500/20',
        codeTextClass: 'text-brand-600 dark:text-brand-400',
    },
    forbidden: {
        badgeClass:
            'bg-rose-50 text-rose-700 border-rose-200/80 dark:bg-rose-500/10 dark:text-rose-300 dark:border-rose-500/25',
        illustrationBoxClass:
            'bg-rose-50/90 text-rose-600 border-rose-200/70 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20',
        codeTextClass: 'text-rose-600 dark:text-rose-400',
    },
    server: {
        badgeClass:
            'bg-rose-50 text-rose-700 border-rose-200/80 dark:bg-rose-500/10 dark:text-rose-300 dark:border-rose-500/25',
        illustrationBoxClass:
            'bg-rose-50/90 text-rose-600 border-rose-200/70 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20',
        codeTextClass: 'text-rose-600 dark:text-rose-400',
    },
    unauthorized: {
        badgeClass:
            'bg-amber-50 text-amber-800 border-amber-200/80 dark:bg-amber-500/10 dark:text-amber-300 dark:border-amber-500/25',
        illustrationBoxClass:
            'bg-amber-50/90 text-amber-600 border-amber-200/70 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
        codeTextClass: 'text-amber-600 dark:text-amber-400',
    },
    expired: {
        badgeClass:
            'bg-amber-50 text-amber-800 border-amber-200/80 dark:bg-amber-500/10 dark:text-amber-300 dark:border-amber-500/25',
        illustrationBoxClass:
            'bg-amber-50/90 text-amber-600 border-amber-200/70 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
        codeTextClass: 'text-amber-600 dark:text-amber-400',
    },
    rate_limit: {
        badgeClass:
            'bg-amber-50 text-amber-800 border-amber-200/80 dark:bg-amber-500/10 dark:text-amber-300 dark:border-amber-500/25',
        illustrationBoxClass:
            'bg-amber-50/90 text-amber-600 border-amber-200/70 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
        codeTextClass: 'text-amber-600 dark:text-amber-400',
    },
    maintenance: {
        badgeClass:
            'bg-amber-50 text-amber-800 border-amber-200/80 dark:bg-amber-500/10 dark:text-amber-300 dark:border-amber-500/25',
        illustrationBoxClass:
            'bg-amber-50/90 text-amber-600 border-amber-200/70 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
        codeTextClass: 'text-amber-600 dark:text-amber-400',
    },
    bad_request: {
        badgeClass:
            'bg-sky-50 text-sky-700 border-sky-200/80 dark:bg-sky-500/10 dark:text-sky-300 dark:border-sky-500/25',
        illustrationBoxClass:
            'bg-sky-50/90 text-sky-600 border-sky-200/70 dark:bg-sky-500/10 dark:text-sky-400 dark:border-sky-500/20',
        codeTextClass: 'text-sky-600 dark:text-sky-400',
    },
};

export function getErrorTheme(category) {
    return ERROR_THEME_MAP[category] || ERROR_THEME_MAP.not_found;
}
