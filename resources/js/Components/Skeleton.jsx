import React from 'react';

function Skeleton({ className = '', width = '100%', height = '1rem' }) {
    return (
        <div
            className={`animate-pulse rounded-lg bg-surface-200 dark:bg-surface-700 ${className}`}
            style={{ width, height }}
        />
    );
}

Skeleton.Circle = function SkeletonCircle({ size = '2.5rem', className = '' }) {
    return (
        <div
            className={`animate-pulse rounded-full bg-surface-200 dark:bg-surface-700 shrink-0 ${className}`}
            style={{ width: size, height: size }}
        />
    );
};

Skeleton.Table = function SkeletonTable({ rows = 5, cols = 5 }) {
    return (
        <div className="w-full">
            {/* Header */}
            <div className="flex gap-4 px-6 py-4 bg-surface-50 dark:bg-surface-900/50 border-b border-surface-200 dark:border-surface-700 rounded-t-xl">
                {Array.from({ length: cols }).map((_, i) => (
                    <Skeleton key={i} height="0.875rem" width={i === 0 ? '2rem' : `${Math.random() * 40 + 60}%`} />
                ))}
            </div>
            {/* Rows */}
            {Array.from({ length: rows }).map((_, rowIdx) => (
                <div key={rowIdx} className="flex gap-4 px-6 py-4 border-b border-surface-100 dark:border-surface-700 last:border-0">
                    {Array.from({ length: cols }).map((_, colIdx) => (
                        <Skeleton key={colIdx} height="0.875rem" width={colIdx === 0 ? '2rem' : `${Math.random() * 30 + 50}%`} />
                    ))}
                </div>
            ))}
        </div>
    );
};

Skeleton.Chart = function SkeletonChart({ height = '320px' }) {
    return (
        <div className="w-full flex flex-col items-center justify-center gap-3" style={{ height }}>
            <div className="animate-pulse rounded-full bg-surface-200 dark:bg-surface-700" style={{ width: '180px', height: '180px' }} />
            <div className="flex gap-3 mt-2">
                <Skeleton width="60px" height="0.75rem" />
                <Skeleton width="60px" height="0.75rem" />
                <Skeleton width="60px" height="0.75rem" />
            </div>
        </div>
    );
};

Skeleton.Card = function SkeletonCard() {
    return (
        <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden p-6">
            <div className="flex justify-between items-start">
                <div className="space-y-2 flex-1">
                    <Skeleton width="60%" height="0.75rem" />
                    <Skeleton width="40%" height="1.75rem" />
                </div>
                <Skeleton.Circle size="3rem" />
            </div>
        </div>
    );
};

export default Skeleton;
