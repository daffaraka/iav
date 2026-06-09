import { Head } from '@inertiajs/react';
import { useTheme } from '../Contexts/ThemeContext';

export default function GuestLayout({ children, title }) {
    const { isDarkMode, setIsDarkMode } = useTheme();

    return (
        <div className="min-h-screen flex font-sans antialiased selection:bg-blue-100 selection:text-blue-900 bg-white dark:bg-surface-900 transition-colors duration-300">
            <Head title={title} />
            
            {/* Left Branding Column */}
            <div className="hidden lg:flex lg:w-1/2 bg-slate-900 flex-col items-center justify-center p-12 text-white relative overflow-hidden">
                <div className="absolute inset-0 bg-gradient-to-br from-blue-900 to-slate-900 opacity-95"></div>
                
                {/* Theme Toggle in Branding */}
                <button 
                    onClick={() => setIsDarkMode(!isDarkMode)}
                    className="absolute top-6 left-6 p-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm transition-all shadow-sm"
                    title="Toggle Dark Mode"
                >
                    <i className={`ph ${isDarkMode ? 'ph-sun' : 'ph-moon'} text-xl`}></i>
                </button>

                <div className="relative z-10 flex flex-col items-center text-center max-w-md">
                    <div className="w-24 h-24 bg-white rounded-2xl flex items-center justify-center shadow-xl mb-8 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                        <span className="text-4xl font-black text-blue-900">A</span>
                    </div>
                    <h1 className="text-4xl font-bold tracking-tight mb-4">Internal Avicenna School System</h1>
                    <p className="text-blue-100 text-lg leading-relaxed">
                        Selamat datang kembali. Sistem operasional terpadu untuk efisiensi dan transparansi manajemen pendidikan.
                    </p>
                </div>
                
                {/* Decorative Elements */}
                <div className="absolute top-1/4 right-0 w-64 h-64 bg-blue-800 rounded-full blur-3xl opacity-30"></div>
                <div className="absolute bottom-0 left-1/4 w-96 h-96 bg-indigo-900 rounded-full blur-3xl opacity-40"></div>
            </div>

            {/* Right Form Column */}
            <div className="w-full lg:w-1/2 flex flex-col justify-center px-6 sm:px-12 lg:px-24 xl:px-32 relative bg-surface-50 dark:bg-surface-900">
                {/* Theme Toggle Mobile */}
                <button 
                    onClick={() => setIsDarkMode(!isDarkMode)}
                    className="lg:hidden absolute top-6 right-6 p-2.5 rounded-xl bg-white dark:bg-surface-800 text-slate-500 dark:text-slate-400 hover:bg-surface-50 dark:hover:bg-surface-700 transition-all border border-surface-200 dark:border-surface-700 shadow-sm"
                >
                    <i className={`ph ${isDarkMode ? 'ph-sun' : 'ph-moon'} text-xl`}></i>
                </button>
                
                {/* Mobile Logo Logo */}
                <div className="lg:hidden mb-8 flex justify-center mt-12">
                     <div className="w-16 h-16 bg-blue-900 rounded-2xl flex items-center justify-center shadow-lg">
                        <span className="text-2xl font-black text-white">A</span>
                    </div>
                </div>

                <div className="w-full max-w-md mx-auto">
                    {children}
                </div>
            </div>
        </div>
    );
}
