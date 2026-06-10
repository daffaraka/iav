import React, { useState, useRef, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { useTheme } from '../Contexts/ThemeContext';

export default function Topbar({ isSidebarOpen, setIsSidebarOpen }) {
    const { isDarkMode, setIsDarkMode } = useTheme();
    const { auth } = usePage().props;
    const user = auth?.user;
    
    const [isProfileOpen, setIsProfileOpen] = useState(false);
    const profileRef = useRef(null);

    // Close dropdown when clicking outside
    useEffect(() => {
        function handleClickOutside(event) {
            if (profileRef.current && !profileRef.current.contains(event.target)) {
                setIsProfileOpen(false);
            }
        }
        document.addEventListener("mousedown", handleClickOutside);
        return () => document.removeEventListener("mousedown", handleClickOutside);
    }, []);

    // Get initials for avatar
    const getInitials = (name) => {
        if (!name) return 'U';
        return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
    };

    return (
        <header className="h-16 bg-white dark:bg-surface-800 border-b border-slate-200 dark:border-surface-700 flex items-center justify-between px-4 lg:px-8 shadow-md z-30 transition-colors duration-300 relative">
            <div className="flex items-center gap-4">
                {/* Toggle Sidebar Button */}
                <button 
                    onClick={() => setIsSidebarOpen(!isSidebarOpen)}
                    className={`p-2.5 transition-all duration-200 rounded-xl flex items-center justify-center ${
                        isSidebarOpen 
                        ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-500/20' 
                        : 'bg-surface-100 text-slate-600 dark:bg-surface-700 dark:text-slate-300 hover:bg-surface-200 dark:hover:bg-surface-600'
                    }`}
                >
                    <i className={`ph ph-list text-xl`}></i>
                </button>

                <div className="hidden md:block relative group ml-2">
                    <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i className="ph ph-magnifying-glass text-slate-400 group-focus-within:text-brand-500 transition-colors"></i>
                    </div>
                    <input 
                        type="text" 
                        className="block w-72 pl-10 pr-3 py-2 border-none bg-surface-100/70 dark:bg-surface-900/50 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:bg-white dark:focus:bg-surface-900 transition-all text-slate-700 dark:text-slate-200" 
                        placeholder="Cari apapun (Ctrl+K)..." 
                    />
                </div>
            </div>
            
            <div className="flex items-center gap-3">
                {/* Dark Mode Toggle */}
                <button 
                    onClick={() => setIsDarkMode(!isDarkMode)}
                    className="p-2.5 text-slate-500 hover:text-brand-600 dark:text-slate-400 dark:hover:text-brand-400 transition-colors rounded-xl hover:bg-surface-100 dark:hover:bg-surface-700 bg-surface-50 dark:bg-surface-800 border border-surface-200 dark:border-surface-600"
                >
                    <i className={`ph ${isDarkMode ? 'ph-sun' : 'ph-moon'} text-xl`}></i>
                </button>
                {/* Notification */}
                <button className="relative p-2.5 text-slate-500 hover:text-brand-600 dark:text-slate-400 dark:hover:text-brand-400 transition-colors rounded-xl hover:bg-surface-100 dark:hover:bg-surface-700 bg-surface-50 dark:bg-surface-800 border border-surface-200 dark:border-surface-600">
                    <i className="ph ph-bell text-xl"></i>
                    <span className="absolute top-2 right-2 block h-2.5 w-2.5 rounded-full bg-rose-500 ring-2 ring-white dark:ring-surface-800"></span>
                </button>
                
                {/* User Profile Mini with Dropdown */}
                <div className="relative ml-2 pl-4 border-l border-surface-200 dark:border-surface-700" ref={profileRef}>
                    <div 
                        className="flex items-center gap-3 cursor-pointer group"
                        onClick={() => setIsProfileOpen(!isProfileOpen)}
                    >
                        <div className="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-900 flex items-center justify-center text-brand-600 dark:text-brand-400 font-bold border-2 border-white dark:border-surface-800 shadow-sm transition-transform group-hover:scale-105">
                            {getInitials(user?.name)}
                        </div>
                        <div className="hidden md:block">
                            <p className="text-sm font-bold text-slate-700 dark:text-white leading-tight group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                                {user?.name || 'User'}
                            </p>
                            <p className="text-xs text-slate-500 dark:text-slate-400 capitalize">
                                {user?.roles?.[0]?.name || 'Staff'}
                            </p>
                        </div>
                        <i className={`ph ph-caret-down text-slate-400 ml-1 hidden md:block group-hover:text-brand-500 transition-transform duration-200 ${isProfileOpen ? 'rotate-180' : ''}`}></i>
                    </div>

                    {/* Dropdown Menu */}
                    {isProfileOpen && (
                        <div className="absolute right-0 mt-3 w-56 bg-white dark:bg-surface-800 rounded-2xl shadow-xl border border-surface-200 dark:border-surface-700 py-2 z-50 animate-in fade-in slide-in-from-top-2 duration-200">
                            <div className="px-4 py-3 border-b border-surface-100 dark:border-surface-700 md:hidden">
                                <p className="text-sm font-bold text-slate-800 dark:text-white">{user?.name || 'User'}</p>
                                <p className="text-xs text-slate-500 dark:text-slate-400 capitalize mt-0.5">{user?.roles?.[0]?.name || 'Staff'}</p>
                            </div>
                            
                            <div className="py-1">
                                <Link 
                                    href="/profile" 
                                    className="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-surface-50 dark:hover:bg-surface-700 hover:text-brand-600 dark:hover:text-brand-400 transition-colors"
                                    onClick={() => setIsProfileOpen(false)}
                                >
                                    <i className="ph ph-user-circle text-lg"></i>
                                    Edit Profile
                                </Link>
                                <Link 
                                    href="#" 
                                    className="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-surface-50 dark:hover:bg-surface-700 hover:text-brand-600 dark:hover:text-brand-400 transition-colors justify-between"
                                    onClick={() => setIsProfileOpen(false)}
                                >
                                    <div className="flex items-center gap-3">
                                        <i className="ph ph-bell text-lg"></i>
                                        Notifikasi
                                    </div>
                                    <span className="px-1.5 py-0.5 rounded-full bg-rose-100 text-rose-600 dark:bg-rose-500/20 dark:text-rose-400 text-[10px] font-bold">3</span>
                                </Link>
                            </div>
                            
                            <div className="border-t border-surface-100 dark:border-surface-700 mt-1 pt-1">
                                <Link 
                                    href="/logout" 
                                    method="post" 
                                    as="button"
                                    className="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors"
                                >
                                    <i className="ph ph-sign-out text-lg"></i>
                                    Logout
                                </Link>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </header>
    );
}
