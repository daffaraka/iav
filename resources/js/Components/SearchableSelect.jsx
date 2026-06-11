import React, { useState, useRef, useEffect } from 'react';

export default function SearchableSelect({ options, value, onChange, placeholder, error, className = "" }) {
    const [isOpen, setIsOpen] = useState(false);
    const [query, setQuery] = useState('');
    const wrapperRef = useRef(null);

    // Find current label to display when not searching
    const selectedOption = options.find(opt => opt.value == value);
    const displayValue = isOpen ? query : (selectedOption ? selectedOption.label : '');

    useEffect(() => {
        function handleClickOutside(event) {
            if (wrapperRef.current && !wrapperRef.current.contains(event.target)) {
                setIsOpen(false);
                setQuery('');
            }
        }
        document.addEventListener("mousedown", handleClickOutside);
        return () => document.removeEventListener("mousedown", handleClickOutside);
    }, [wrapperRef]);

    const filteredOptions = query === '' 
        ? options 
        : options.filter(option => 
            option.label.toLowerCase().includes(query.toLowerCase())
          );

    return (
        <div className={`relative ${className}`} ref={wrapperRef}>
            <input
                type="text"
                value={displayValue}
                onChange={(e) => {
                    setQuery(e.target.value);
                    setIsOpen(true);
                    if (e.target.value === '') {
                        onChange('');
                    }
                }}
                onFocus={() => {
                    setIsOpen(true);
                    setQuery('');
                }}
                placeholder={placeholder || 'Pilih...'}
                className={`w-full px-4 py-2.5 rounded-xl border ${error ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all`}
            />
            <div className="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                <i className="ph ph-caret-down text-slate-400"></i>
            </div>

            {isOpen && (
                <ul className="absolute z-50 w-full mt-1 bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 shadow-lg max-h-60 rounded-xl py-1 text-base overflow-auto focus:outline-none sm:text-sm custom-scrollbar">
                    {filteredOptions.length === 0 ? (
                        <li className="text-slate-500 dark:text-slate-400 cursor-default select-none relative py-2 pl-4 pr-9">
                            Data tidak ditemukan
                        </li>
                    ) : (
                        filteredOptions.map((option) => (
                            <li
                                key={option.value}
                                className={`cursor-pointer select-none relative py-2.5 px-4 hover:bg-brand-50 dark:hover:bg-surface-700 hover:text-brand-700 dark:hover:text-brand-300 transition-colors ${value == option.value ? 'bg-brand-50 text-brand-700 dark:bg-surface-700 dark:text-brand-300 font-semibold' : 'text-slate-700 dark:text-slate-300'}`}
                                onClick={() => {
                                    onChange(option.value);
                                    setIsOpen(false);
                                    setQuery('');
                                }}
                            >
                                {option.label}
                            </li>
                        ))
                    )}
                </ul>
            )}
        </div>
    );
}
