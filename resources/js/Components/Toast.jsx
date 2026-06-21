import React, { useEffect, useState } from 'react';
import { useToast } from '../Contexts/ToastContext';

const variants = {
    success: {
        bg: 'bg-emerald-50 dark:bg-emerald-500/10',
        border: 'border-emerald-200 dark:border-emerald-500/30',
        text: 'text-emerald-800 dark:text-emerald-200',
        icon: 'ph-check-circle',
        iconColor: 'text-emerald-600 dark:text-emerald-400',
        progressBar: 'bg-emerald-500',
    },
    error: {
        bg: 'bg-red-50 dark:bg-red-500/10',
        border: 'border-red-200 dark:border-red-500/30',
        text: 'text-red-800 dark:text-red-200',
        icon: 'ph-warning-circle',
        iconColor: 'text-red-600 dark:text-red-400',
        progressBar: 'bg-red-500',
    },
    warning: {
        bg: 'bg-amber-50 dark:bg-amber-500/10',
        border: 'border-amber-200 dark:border-amber-500/30',
        text: 'text-amber-800 dark:text-amber-200',
        icon: 'ph-warning',
        iconColor: 'text-amber-600 dark:text-amber-400',
        progressBar: 'bg-amber-500',
    },
    info: {
        bg: 'bg-blue-50 dark:bg-blue-500/10',
        border: 'border-blue-200 dark:border-blue-500/30',
        text: 'text-blue-800 dark:text-blue-200',
        icon: 'ph-info',
        iconColor: 'text-blue-600 dark:text-blue-400',
        progressBar: 'bg-blue-500',
    },
};

function ToastItem({ toast, onRemove }) {
    const [isExiting, setIsExiting] = useState(false);
    const [progress, setProgress] = useState(100);
    const style = variants[toast.type] || variants.info;

    useEffect(() => {
        const startTime = Date.now();
        const interval = setInterval(() => {
            const elapsed = Date.now() - startTime;
            const remaining = Math.max(0, 100 - (elapsed / toast.duration) * 100);
            setProgress(remaining);
            if (remaining <= 0) clearInterval(interval);
        }, 50);
        return () => clearInterval(interval);
    }, [toast.duration]);

    const handleClose = () => {
        setIsExiting(true);
        setTimeout(() => onRemove(toast.id), 200);
    };

    return (
        <div className={`relative w-80 rounded-xl border shadow-lg overflow-hidden transition-all duration-300 ${
            isExiting ? 'opacity-0 translate-x-8' : 'opacity-100 translate-x-0'
        } ${style.bg} ${style.border}`}>
            <div className="flex items-start gap-3 p-4">
                <i className={`ph ${style.icon} text-xl ${style.iconColor} mt-0.5 shrink-0`}></i>
                <p className={`text-sm font-medium flex-1 ${style.text}`}>{toast.message}</p>
                <button onClick={handleClose} className={`shrink-0 p-0.5 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 ${style.iconColor} opacity-60 hover:opacity-100 transition-opacity`}>
                    <i className="ph ph-x text-sm"></i>
                </button>
            </div>
            <div className="h-0.5 w-full bg-black/5 dark:bg-white/5">
                <div className={`h-full ${style.progressBar} transition-all duration-100 ease-linear`} style={{ width: `${progress}%` }} />
            </div>
        </div>
    );
}

export default function ToastContainer() {
    const { toasts, removeToast } = useToast();

    return (
        <div className="fixed top-4 right-4 z-[9999] flex flex-col gap-3">
            {toasts.map(toast => (
                <ToastItem key={toast.id} toast={toast} onRemove={removeToast} />
            ))}
        </div>
    );
}
