import React, { useState, useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import Sidebar from '../Components/Sidebar';
import Topbar from '../Components/Topbar';
import ToastContainer from '../Components/Toast';
import { useToast } from '../Contexts/ToastContext';

export default function AuthenticatedLayout({ children }) {
    const [isSidebarOpen, setIsSidebarOpen] = useState(true);
    const [isMobile, setIsMobile] = useState(false);
    const { flash } = usePage().props;
    const { showToast } = useToast();

    useEffect(() => {
        if (flash?.success) showToast('success', flash.success);
        if (flash?.error) showToast('error', flash.error);
        if (flash?.warning) showToast('warning', flash.warning);
    }, [flash]);

    useEffect(() => {
        const checkMobile = () => {
            setIsMobile(window.innerWidth < 1024);
            if (window.innerWidth < 1024) {
                setIsSidebarOpen(false);
            } else {
                setIsSidebarOpen(true);
            }
        };
        
        checkMobile();
        window.addEventListener('resize', checkMobile);
        return () => window.removeEventListener('resize', checkMobile);
    }, []);

    const mainMargin = isMobile ? 'ml-0' : (isSidebarOpen ? 'ml-64' : 'ml-20');

    return (
        <div className="flex h-screen overflow-hidden bg-surface-50 dark:bg-surface-900 text-slate-800 dark:text-slate-200 font-sans antialiased selection:bg-brand-100 selection:text-brand-900 transition-colors duration-300">
            <Sidebar 
                isSidebarOpen={isSidebarOpen} 
                isMobile={isMobile} 
                setIsSidebarOpen={setIsSidebarOpen} 
            />

            <div className={`flex-1 flex flex-col h-screen overflow-hidden transition-all duration-300 ${mainMargin}`}>
                <Topbar 
                    isSidebarOpen={isSidebarOpen} 
                    setIsSidebarOpen={setIsSidebarOpen} 
                />

                <main className="flex-1 overflow-x-hidden overflow-y-auto p-4 lg:p-8 space-y-6">
                    {children}
                </main>
            </div>
            
            <ToastContainer />
        </div>
    );
}
