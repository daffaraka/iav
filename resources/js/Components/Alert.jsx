import React, { useState, useEffect } from 'react';

export default function Alert({ type = 'info', message, title, dismissible = true, onClose }) {
    const [isVisible, setIsVisible] = useState(true);

    // Reset visibility if message changes
    useEffect(() => {
        if (message) {
            setIsVisible(true);
        }
    }, [message]);

    if (!message || !isVisible) return null;

    const handleClose = () => {
        setIsVisible(false);
        if (onClose) onClose();
    };

    const variants = {
        success: {
            bg: 'bg-emerald-50 dark:bg-emerald-500/10',
            border: 'border-emerald-200 dark:border-emerald-500/20',
            text: 'text-emerald-800 dark:text-emerald-300',
            iconText: 'text-emerald-600 dark:text-emerald-400',
            icon: 'ph-check-circle',
            defaultTitle: 'Berhasil'
        },
        error: {
            bg: 'bg-red-50 dark:bg-red-500/10',
            border: 'border-red-200 dark:border-red-500/20',
            text: 'text-red-800 dark:text-red-300',
            iconText: 'text-red-600 dark:text-red-400',
            icon: 'ph-warning-circle',
            defaultTitle: 'Terjadi Kesalahan'
        },
        warning: {
            bg: 'bg-amber-50 dark:bg-amber-500/10',
            border: 'border-amber-200 dark:border-amber-500/20',
            text: 'text-amber-800 dark:text-amber-300',
            iconText: 'text-amber-600 dark:text-amber-400',
            icon: 'ph-warning',
            defaultTitle: 'Peringatan'
        },
        info: {
            bg: 'bg-blue-50 dark:bg-blue-500/10',
            border: 'border-blue-200 dark:border-blue-500/20',
            text: 'text-blue-800 dark:text-blue-300',
            iconText: 'text-blue-600 dark:text-blue-400',
            icon: 'ph-info',
            defaultTitle: 'Informasi'
        }
    };

    const style = variants[type] || variants.info;
    const displayTitle = title || style.defaultTitle;

    return (
        <div className={`mb-6 p-4 ${style.bg} border ${style.border} rounded-xl flex items-start justify-between gap-3 shadow-sm transition-all duration-300 animate-in fade-in slide-in-from-top-4`}>
            <div className="flex items-start gap-3 flex-1">
                <i className={`ph ${style.icon} text-xl ${style.iconText} mt-0.5 shrink-0`}></i>
                <div>
                    <h4 className={`text-sm font-semibold ${style.text}`}>{displayTitle}</h4>
                    <p className={`text-sm ${style.iconText} mt-0.5`}>{message}</p>
                </div>
            </div>
            {dismissible && (
                <button
                    onClick={handleClose}
                    className={`shrink-0 p-1 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 transition-colors ${style.iconText} opacity-70 hover:opacity-100`}
                    aria-label="Tutup"
                >
                    <i className="ph ph-x"></i>
                </button>
            )}
        </div>
    );
}
