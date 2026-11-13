import React from 'react';

const CATEGORY_SHAPES = {
    not_found: (
        <>
            <circle cx="21" cy="21" r="11" fill="currentColor" fillOpacity="0.14" />
            <circle cx="21" cy="21" r="11" stroke="currentColor" strokeWidth="1.75" />
            <path d="M29.2 29.2L38 38" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
            <path d="M17.5 17.5L24.5 24.5M24.5 17.5L17.5 24.5" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
        </>
    ),
    forbidden: (
        <>
            <path d="M24 7L38 12.5V23.5C38 32 32 38 24 41C16 38 10 32 10 23.5V12.5L24 7Z" fill="currentColor" fillOpacity="0.14" />
            <path d="M24 7L38 12.5V23.5C38 32 32 38 24 41C16 38 10 32 10 23.5V12.5L24 7Z" stroke="currentColor" strokeWidth="1.75" strokeLinejoin="round" />
            <path d="M19.5 19.5L28.5 28.5M28.5 19.5L19.5 28.5" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
        </>
    ),
    unauthorized: (
        <>
            <rect x="11" y="21" width="26" height="19" rx="4" fill="currentColor" fillOpacity="0.14" />
            <rect x="11" y="21" width="26" height="19" rx="4" stroke="currentColor" strokeWidth="1.75" />
            <path d="M16 21V15.5C16 11.36 19.58 8 24 8C28.42 8 32 11.36 32 15.5V21" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
            <circle cx="24" cy="30.5" r="2.25" stroke="currentColor" strokeWidth="1.75" />
        </>
    ),
    expired: (
        <>
            <circle cx="24" cy="24" r="15" fill="currentColor" fillOpacity="0.14" />
            <circle cx="24" cy="24" r="15" stroke="currentColor" strokeWidth="1.75" />
            <path d="M24 15V24L30 27.5" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" strokeLinejoin="round" />
        </>
    ),
    rate_limit: (
        <>
            <path d="M13 10H35L27 23V25L35 38H13L21 25V23L13 10Z" fill="currentColor" fillOpacity="0.14" />
            <path d="M13 10H35M13 38H35M15.5 10L22.5 22.5V25.5L15.5 38M32.5 10L25.5 22.5V25.5L32.5 38" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" strokeLinejoin="round" />
        </>
    ),
    maintenance: (
        <>
            <circle cx="24" cy="24" r="14" fill="currentColor" fillOpacity="0.14" />
            <path d="M28.5 13.5L34.5 19.5L21 33H15V27L28.5 13.5Z" stroke="currentColor" strokeWidth="1.75" strokeLinejoin="round" />
            <path d="M25.5 16.5L31.5 22.5" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
        </>
    ),
    server: (
        <>
            <rect x="9" y="10" width="30" height="11" rx="3" fill="currentColor" fillOpacity="0.14" />
            <rect x="9" y="10" width="30" height="11" rx="3" stroke="currentColor" strokeWidth="1.75" />
            <rect x="9" y="27" width="30" height="11" rx="3" stroke="currentColor" strokeWidth="1.75" />
            <circle cx="15" cy="15.5" r="1.25" fill="currentColor" />
            <circle cx="15" cy="32.5" r="1.25" fill="currentColor" />
            <path d="M25 15.5H33M25 32.5H33" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
        </>
    ),
    bad_request: (
        <>
            <path d="M24 8L40 37H8L24 8Z" fill="currentColor" fillOpacity="0.14" />
            <path d="M24 8L40 37H8L24 8Z" stroke="currentColor" strokeWidth="1.75" strokeLinejoin="round" />
            <path d="M24 19V27" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
            <circle cx="24" cy="31.5" r="1.25" fill="currentColor" />
        </>
    ),
};

export default function ErrorCategorySvg({ category, className = 'w-11 h-11' }) {
    const shapes = CATEGORY_SHAPES[category] || CATEGORY_SHAPES.not_found;

    return (
        <svg viewBox="0 0 48 48" fill="none" className={className} aria-hidden="true">
            {shapes}
        </svg>
    );
}
