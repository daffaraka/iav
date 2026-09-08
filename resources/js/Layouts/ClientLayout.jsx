import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import { Bell, Moon, User, LogOut, Filter, Search } from 'lucide-react';

export default function ClientLayout({ children }) {
    const { auth } = usePage().props;

    return (
        <div className="min-h-screen bg-gray-50 flex flex-col">
            {/* Top Navbar */}
            <header className="bg-white border-b border-gray-200 sticky top-0 z-50">
                <div className="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-16">
                        {/* Left: Logo */}
                        <div className="flex-shrink-0 flex items-center">
                            <Link href="/" className="text-indigo-600 font-bold text-xl">
                                TimePro IT & Branding
                            </Link>
                        </div>

                        {/* Center: Tabs */}
                        <nav className="hidden md:flex space-x-8">
                            <Link href={route('kanban.wig.index')} className="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-indigo-500 transition-colors">
                                Dashboard Project
                            </Link>
                            <Link href={route('kanban.task.my-jobs')} className="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-indigo-500 transition-colors">
                                Semua Pekerjaan
                            </Link>
                            <Link href={route('kanban.calendar')} className="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-indigo-500 transition-colors">
                                Kalender
                            </Link>
                            <Link href={route('kanban.calendar.publikasi')} className="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-indigo-500 transition-colors">
                                Kalender Publikasi
                            </Link>
                            <Link href={route('kanban.calendar.meeting')} className="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-indigo-500 transition-colors">
                                Kalender Meeting
                            </Link>
                            <Link href={route('kanban.master.index')} className="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-indigo-500 transition-colors">
                                Master Data
                            </Link>
                        </nav>

                        {/* Right: Actions */}
                        <div className="flex items-center space-x-4">
                            <button className="text-gray-400 hover:text-gray-500">
                                <Bell className="w-5 h-5" />
                            </button>
                            <button className="text-gray-400 hover:text-gray-500">
                                <Moon className="w-5 h-5" />
                            </button>
                            <div className="flex items-center space-x-2 pl-4 border-l border-gray-200">
                                <div className="text-sm font-medium text-gray-700">
                                    {auth?.user?.name || 'Admin Unknown'}
                                </div>
                                <button className="text-gray-400 hover:text-red-500 transition-colors">
                                    <LogOut className="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {/* Sub-Header */}
            <div className="bg-white border-b border-gray-200 sticky top-16 z-40">
                <div className="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                    <div className="flex justify-between items-center">
                        <div className="flex items-center space-x-2">
                            <Filter className="w-4 h-4 text-gray-400" />
                            <select className="bg-transparent text-sm text-gray-700 border-none focus:ring-0 cursor-pointer">
                                <option>Semua Departemen</option>
                            </select>
                        </div>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <Search className="h-4 w-4 text-gray-400" />
                            </div>
                            <input
                                type="text"
                                className="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Cari project, board..."
                            />
                        </div>
                    </div>
                </div>
            </div>

            {/* Main Content Area */}
            <main className="flex-1 max-w-screen-2xl w-full mx-auto p-4 sm:p-6 lg:p-8">
                {children}
            </main>
        </div>
    );
}
