import React, { useEffect, useState } from 'react';

export default function ErrorDetailsCard({ error }) {
    const [copied, setCopied] = useState(false);
    const [countdown, setCountdown] = useState(error.retryAfter ?? null);

    useEffect(() => {
        setCountdown(error.retryAfter ?? null);
    }, [error.retryAfter, error.status]);

    useEffect(() => {
        if (!countdown || countdown <= 0) return undefined;

        const timer = setInterval(() => {
            setCountdown((prev) => (prev && prev > 1 ? prev - 1 : 0));
        }, 1000);

        return () => clearInterval(timer);
    }, [countdown]);

    const handleCopyReference = async () => {
        const payload = `HTTP ${error.status} (${error.codeLabel}) | ${error.method} ${error.requestedPath} | ${error.timestamp}`;
        try {
            await navigator.clipboard.writeText(payload);
            setCopied(true);
            setTimeout(() => setCopied(false), 2000);
        } catch {
            setCopied(false);
        }
    };

    return (
        <div className="mt-8 pt-6 border-t border-surface-200 dark:border-surface-700 text-left space-y-5">
            {error.retryAfter !== null && (
                <div className="px-4 py-3 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200/80 dark:border-amber-500/25 text-xs sm:text-sm text-amber-800 dark:text-amber-300 flex items-center justify-between gap-3">
                    <span>
                        {countdown > 0
                            ? `Anda dapat mencoba memuat ulang dalam ${countdown} detik.`
                            : 'Batas tunggu selesai. Anda dapat mencoba kembali sekarang.'}
                    </span>
                </div>
            )}

            {error.suggestions?.length > 0 && (
                <div>
                    <h2 className="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2.5">
                        Langkah yang Dapat Dilakukan
                    </h2>
                    <ul className="space-y-1.5 text-sm text-slate-600 dark:text-slate-300">
                        {error.suggestions.map((item) => (
                            <li key={item} className="flex items-start gap-2.5">
                                <span className="mt-2 w-1.5 h-1.5 rounded-full bg-brand-500 shrink-0" />
                                <span>{item}</span>
                            </li>
                        ))}
                    </ul>
                </div>
            )}

            <div className="bg-surface-50 dark:bg-surface-900/60 border border-surface-200 dark:border-surface-700 rounded-2xl p-4 space-y-2.5">
                <div className="flex items-center justify-between gap-2">
                    <span className="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                        Referensi Permintaan
                    </span>
                    <button
                        type="button"
                        onClick={handleCopyReference}
                        className="text-xs font-semibold text-brand-600 dark:text-brand-400 hover:underline py-1 px-2 rounded-lg"
                    >
                        {copied ? 'Tersalin' : 'Salin Referensi'}
                    </button>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-600 dark:text-slate-300 font-mono">
                    <div className="truncate">
                        <span className="text-slate-400 dark:text-slate-500">Metode: </span>
                        <span>{error.method}</span>
                    </div>
                    <div className="truncate">
                        <span className="text-slate-400 dark:text-slate-500">Waktu: </span>
                        <span>{error.timestamp}</span>
                    </div>
                    <div className="sm:col-span-2 break-all">
                        <span className="text-slate-400 dark:text-slate-500">Alamat: </span>
                        <span>{error.requestedPath}</span>
                    </div>
                </div>
            </div>
        </div>
    );
}
