import React, { useEffect, useRef } from 'react';

export default function ConfirmModal({
    isOpen,
    onClose,
    onConfirm,
    title = 'Konfirmasi Hapus',
    message = 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
    confirmText = 'Ya, Hapus',
    cancelText = 'Batal',
    variant = 'danger', // 'danger' | 'warning'
    processing = false,
}) {
    const confirmRef = useRef(null);

    useEffect(() => {
        if (isOpen) {
            confirmRef.current?.focus();
        }
    }, [isOpen]);

    useEffect(() => {
        const handleKeyDown = (e) => {
            if (!isOpen) return;
            if (e.key === 'Escape') onClose();
            if (e.key === 'Enter' && !processing) onConfirm();
        };
        window.addEventListener('keydown', handleKeyDown);
        return () => window.removeEventListener('keydown', handleKeyDown);
    }, [isOpen, onClose, onConfirm, processing]);

    if (!isOpen) return null;

    const variantStyles = {
        danger: {
            iconBg: 'bg-red-100 dark:bg-red-500/20',
            iconColor: 'text-red-600 dark:text-red-400',
            icon: 'ph-trash',
            buttonBg: 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        },
        warning: {
            iconBg: 'bg-amber-100 dark:bg-amber-500/20',
            iconColor: 'text-amber-600 dark:text-amber-400',
            icon: 'ph-warning',
            buttonBg: 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
        },
    };
    const vs = variantStyles[variant] || variantStyles.danger;

    return (
        <div className="fixed inset-0 z-[9998] flex items-center justify-center p-4">
            {/* Backdrop */}
            <div className="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onClick={!processing ? onClose : undefined} />
            
            {/* Modal */}
            <div className="relative bg-white dark:bg-surface-800 rounded-2xl shadow-2xl border border-surface-200 dark:border-surface-700 max-w-sm w-full p-6 transform transition-all duration-200 scale-100 animate-in fade-in zoom-in-95">
                {/* Icon */}
                <div className="flex justify-center mb-4">
                    <div className={`w-16 h-16 rounded-full ${vs.iconBg} flex items-center justify-center`}>
                        <i className={`ph ${vs.icon} text-3xl ${vs.iconColor}`}></i>
                    </div>
                </div>
                
                {/* Content */}
                <h3 className="text-lg font-bold text-slate-800 dark:text-white text-center mb-2">{title}</h3>
                <p className="text-sm text-slate-500 dark:text-slate-400 text-center mb-6">{message}</p>
                
                {/* Buttons */}
                <div className="flex gap-3">
                    <button
                        onClick={onClose}
                        disabled={processing}
                        className="flex-1 px-4 py-2.5 bg-surface-100 dark:bg-surface-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium hover:bg-surface-200 dark:hover:bg-surface-600 transition-colors disabled:opacity-50"
                    >
                        {cancelText}
                    </button>
                    <button
                        ref={confirmRef}
                        onClick={onConfirm}
                        disabled={processing}
                        className={`flex-1 px-4 py-2.5 ${vs.buttonBg} text-white rounded-xl text-sm font-medium transition-colors focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-surface-800 disabled:opacity-50 flex items-center justify-center gap-2`}
                    >
                        {processing ? (
                            <>
                                <svg className="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                    <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" fill="none" />
                                    <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                </svg>
                                Memproses...
                            </>
                        ) : confirmText}
                    </button>
                </div>
            </div>
        </div>
    );
}
