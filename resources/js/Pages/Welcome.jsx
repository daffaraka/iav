import React, { useState, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import { useTheme } from '../Contexts/ThemeContext';
import SubNavLink from '../Components/SubNavLink';
import WelcomePortalSection from './Welcome/Components/WelcomePortalSection';
import WelcomeBranchSection from './Welcome/Components/WelcomeBranchSection';
import WelcomeFeatureSection from './Welcome/Components/WelcomeFeatureSection';

export default function Welcome() {
    const { isDarkMode, setIsDarkMode } = useTheme();
    const [scrolled, setScrolled] = useState(false);

    useEffect(() => {
        const handleScroll = () => {
            setScrolled(window.scrollY > 20);
        };
        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    return (
        <div className="min-h-screen bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 font-sans antialiased transition-colors duration-300">
            <Head title="Avicenna Leadership School" />

            {/* Header with Main Nav */}
            <header className="absolute top-0 left-0 right-0 z-50">
                <div className="container mx-auto max-w-10xl px-6 py-4 flex items-center justify-between border-b border-white/10">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span className="text-xl font-black text-white">A</span>
                        </div>
                        <span className="font-bold text-xl tracking-tight text-slate-900 dark:text-white">
                            Avicenna
                        </span>
                    </div>

                    <div className="flex items-center gap-4">
                        <button
                            onClick={() => setIsDarkMode(!isDarkMode)}
                            className="p-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors"
                            title="Toggle Dark Mode"
                        >
                            <i className={`ph ${isDarkMode ? 'ph-sun' : 'ph-moon'} text-xl`}></i>
                        </button>
                        <Link
                            href="/dashboard"
                            className="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5"
                        >
                            Login LMS
                        </Link>
                    </div>
                </div>
            </header>

            {/* Secondary Nav - Sticky & Dark */}
            <div className="hidden md:block h-24 mt-20 mb-2 z-[60] relative">
                <div className={`w-full flex items-center justify-center pointer-events-none transition-all duration-300 z-[60] ${scrolled ? 'fixed top-6 left-0 right-0' : 'absolute top-0 left-0 right-0'}`}>
                    <div className="pointer-events-auto bg-slate-900 dark:bg-black rounded-full px-12 py-5 shadow-2xl shadow-slate-900/40 dark:shadow-black/60 border border-slate-700/80 flex items-center gap-12 text-base font-bold tracking-wide transition-all">
                        <SubNavLink>Beranda</SubNavLink>
                        <SubNavLink>Profil Kami</SubNavLink>
                        <SubNavLink>Akademik</SubNavLink>
                        <SubNavLink>Fasilitas</SubNavLink>
                        <SubNavLink>Prestasi</SubNavLink>
                        <SubNavLink>Informasi PPDB</SubNavLink>
                        <SubNavLink>Hubungi Kami</SubNavLink>
                    </div>
                </div>
            </div>

            {/* Hero Section */}
            <section id="hero-section" className="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
                <div className="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-gradient-to-b from-blue-100 to-transparent dark:from-blue-900/20 dark:to-transparent rounded-full blur-3xl -z-10 opacity-50"></div>

                <div className="container mx-auto px-6 max-w-10xl text-center">
                    <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-medium text-sm mb-8 border border-blue-100 dark:border-blue-800">
                        <i className="ph ph-sparkle"></i>
                        <span>Indonesia Leadership School</span>
                    </div>

                    <h1 className="text-5xl lg:text-7xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6 leading-tight">
                        Sekolah Berkarakter <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Kepemimpinan</span>
                    </h1>

                    <p className="text-lg lg:text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto mb-10 leading-relaxed">
                        Avicenna Leadership School adalah Sekolah Swasta Unggulan yang berlokasi di Jagakarsa, Cinere dan Pamulang. Kami mewujudkan sekolah berkarakter kepemimpinan, berbasis sains dan teknologi, peduli pada lingkungan dan berprestasi.
                    </p>

                    <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="#ppdb" className="px-8 py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-bold text-lg hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center gap-2">
                            Daftar Sekarang <i className="ph ph-arrow-right"></i>
                        </a>
                        <a href="#cabang" className="px-8 py-4 bg-white dark:bg-slate-800 text-slate-900 dark:text-white rounded-2xl font-bold text-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                            Lihat Cabang
                        </a>
                    </div>
                </div>
            </section>

            {/* Website Pendukung Banner */}
            <WelcomePortalSection />

            {/* Cabang Sekolah */}
            <WelcomeBranchSection />

            {/* Ruang Belajar & Peta Alumni */}
            <WelcomeFeatureSection />

            {/* PPDB CTA */}
            <section id="ppdb" className="py-20">
                <div className="container mx-auto px-6 max-w-10xl">
                    <div className="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] p-10 lg:p-16 text-center text-white relative overflow-hidden shadow-2xl shadow-blue-900/20">
                        <div className="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
                        <div className="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-cyan-400 opacity-20 rounded-full blur-3xl"></div>

                        <div className="relative z-10 max-w-3xl mx-auto">
                            <h2 className="text-3xl lg:text-5xl font-bold mb-6">Penerimaan Peserta Didik Baru</h2>
                            <p className="text-blue-100 text-lg lg:text-xl mb-10 leading-relaxed">
                                Informasi Pendaftaran Peserta Didik Baru Avicenna Leadership School T.P 2026-2027. Mari bergabung bersama kami mewujudkan generasi pemimpin berprestasi.
                            </p>
                            <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
                                <a href="https://ppdb.sekolah-avicenna.sch.id/" target="_blank" rel="noreferrer" className="px-8 py-4 bg-white text-blue-700 rounded-2xl font-bold text-lg hover:shadow-xl hover:scale-105 transition-all w-full sm:w-auto">
                                    Menuju PPDB Online
                                </a>
                                <a href="https://docs.google.com/forms/d/e/1FAIpQLSfm6i3tMhlNhxzXDcNVG2lp5JaWJdsloNSa2nEPQuxHNLhVTw/viewform" target="_blank" rel="noreferrer" className="px-8 py-4 bg-transparent border-2 border-white/30 hover:bg-white/10 text-white rounded-2xl font-bold text-lg transition-all w-full sm:w-auto">
                                    Daftar Trial Class TK
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-black border-t border-slate-800 pt-16 pb-8">
                <div className="container mx-auto px-6 max-w-10xl text-center">
                    <div className="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <span className="text-2xl font-black text-white">A</span>
                    </div>
                    <h3 className="text-xl font-bold text-white mb-2">Avicenna Leadership School</h3>
                    <p className="text-slate-400 mb-8 max-w-md mx-auto">Sekolah Swasta Unggulan berbasis kepemimpinan, sains, dan teknologi.</p>

                    <div className="flex items-center justify-center gap-6 mb-12">
                        <a href="#" className="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-300 hover:bg-blue-900/50 hover:text-blue-400 transition-colors">
                            <i className="ph ph-instagram-logo text-xl"></i>
                        </a>
                        <a href="#" className="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-300 hover:bg-blue-900/50 hover:text-blue-400 transition-colors">
                            <i className="ph ph-facebook-logo text-xl"></i>
                        </a>
                        <a href="#" className="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-300 hover:bg-red-900/50 hover:text-red-400 transition-colors">
                            <i className="ph ph-youtube-logo text-xl"></i>
                        </a>
                    </div>

                    <div className="pt-8 border-t border-slate-800 text-sm text-slate-500">
                        Copyright &copy; 2019 - {new Date().getFullYear()} Yayasan Pendidikan Avicenna Prestasi. All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    );
}
