import React from 'react';

const ACTION_ICONS = {
    reload: (
        <path
            d="M16.5 10A6.5 6.5 0 1 1 14.6 5.4M16.5 3.5V7H13"
            stroke="currentColor"
            strokeWidth="1.75"
            strokeLinecap="round"
            strokeLinejoin="round"
        />
    ),
    back: (
        <path
            d="M15.5 10H4.5M4.5 10L9 5.5M4.5 10L9 14.5"
            stroke="currentColor"
            strokeWidth="1.75"
            strokeLinecap="round"
            strokeLinejoin="round"
        />
    ),
    login: (
        <>
            <path
                d="M11 4.5H15.5C16.05 4.5 16.5 4.95 16.5 5.5V14.5C16.5 15.05 16.05 15.5 15.5 15.5H11"
                stroke="currentColor"
                strokeWidth="1.75"
                strokeLinecap="round"
            />
            <path
                d="M3.5 10H12M12 10L9 7M12 10L9 13"
                stroke="currentColor"
                strokeWidth="1.75"
                strokeLinecap="round"
                strokeLinejoin="round"
            />
        </>
    ),
    home: (
        <path
            d="M3.5 9.5L10 4L16.5 9.5V16C16.5 16.55 16.05 17 15.5 17H4.5C3.95 17 3.5 16.55 3.5 16V9.5Z"
            fill="currentColor"
            fillOpacity="0.16"
            stroke="currentColor"
            strokeWidth="1.75"
            strokeLinejoin="round"
        />
    ),
};

export default function ErrorActionIcon({ primaryAction }) {
    return (
        <svg viewBox="0 0 20 20" fill="none" className="w-4 h-4 shrink-0" aria-hidden="true">
            {ACTION_ICONS[primaryAction] || ACTION_ICONS.home}
        </svg>
    );
}
