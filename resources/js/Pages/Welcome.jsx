import React, { useState, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import { useTheme } from '../Contexts/ThemeContext';
import SubNavLink from '../Components/SubNavLink';
import PortalCard from '../Components/PortalCard';

export default function Welcome() {
    const { isDarkMode, setIsDarkMode } = useTheme();
    const [scrolled, setScrolled] = useState(false);
    const [activeBranch, setActiveBranch] = useState(0);

    // Handle scroll effect for header
    useEffect(() => {
        const handleScroll = () => {
            setScrolled(window.scrollY > 20);
        };
        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const branches = [
        {
            name: 'Avicenna Jagakarsa',
            levels: 'TK - SD - SMP - SMA',
            address: 'Jl. M Kahfi II No.66, Jagakarsa, Jakarta Selatan, 12610, DKI Jakarta.',
            email: 'jagakarsa@sekolah-avicenna.sch.id',
            phones: ['(021) - 7888 4887', '(021) - 7888 4942'],
            website: 'http://jagakarsa.sekolah-avicenna.sch.id/',
            color: 'from-blue-500 to-cyan-500',
            icon: 'ph-buildings',
            image: 'https://images.unsplash.com/photo-1541829070764-84a5d30cb273?auto=format&fit=crop&q=80&w=1200'
        },
        {
            name: 'Avicenna Cinere',
            levels: 'SD - SMP - SMA',
            address: 'Jl. Flamboyan Blok F, Cinere, Depok, 16514, Jawa Barat. Jl. H. Rosyid No. 21, Cinere, Depok.',
            email: 'cinere@sekolah-avicenna.sch.id',
            phones: ['(021) - 754 7516', '(021) - 754 6953'],
            website: 'http://cinere.sekolah-avicenna.sch.id/',
            color: 'from-purple-500 to-indigo-500',
            icon: 'ph-graduation-cap',
            image: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=1200'
        },
        {
            name: 'Avicenna Pamulang',
            levels: 'Kelompok Bermain',
            address: 'JL. Villa Pamulang Blok AJ (Sektor 1), Pondok Benda Pamulang, Tangerang Selatan, 15416, Banten.',
            email: 'pamulang@sekolah-avicenna.sch.id',
            phones: ['(021) - 7470 5045', '(021) - 743 1847'],
            website: 'http://pamulang.sekolah-avicenna.sch.id/',
            color: 'from-emerald-500 to-teal-500',
            icon: 'ph-baby',
            image: 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=1200'
        }
    ];

    return (
        <div className="min-h-screen bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 font-sans antialiased transition-colors duration-300">
            <Head title="Avicenna Leadership School" />

            {/* Header with Main and Secondary Nav */}
            <header className="absolute top-0 left-0 right-0 z-50">
                {/* Main Nav */}
                <div className="container mx-auto max-w-10xl px-6 py-4 flex items-center justify-between border-b border-white/10">
                    {/* Logo & Title */}
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

            {/* Secondary Nav (Dummy) - Sticky & Dark */}
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
            <div className="relative z-10 -mt-12  lg:-mt-24 mb-20 px-6">
                <div className="container mx-auto max-w-10xl">
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 lg:gap-8 mt-24">
                        {/* Card Cinere */}
                        <PortalCard
                            href="http://cinere.sekolah-avicenna.sch.id/"
                            image="https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            label="Cabang"
                            labelColorClass="text-blue-400"
                            title="Avicenna Cinere"
                            titleHoverClass="group-hover:text-blue-300"
                            description="Jelajahi informasi kegiatan, pendaftaran, dan fasilitas di Sekolah Avicenna cabang Cinere."
                        />

                        {/* Card Jagakarsa */}
                        <PortalCard
                            href="http://jagakarsa.sekolah-avicenna.sch.id/"
                            image="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            label="Cabang"
                            labelColorClass="text-blue-400"
                            title="Avicenna Jagakarsa"
                            titleHoverClass="group-hover:text-blue-300"
                            description="Pusat pendidikan modern dengan lingkungan yang mendukung tumbuh kembang siswa."
                        />

                        {/* Card Pamulang */}
                        <PortalCard
                            href="http://pamulang.sekolah-avicenna.sch.id/"
                            image="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            label="Cabang"
                            labelColorClass="text-blue-400"
                            title="Avicenna Pamulang"
                            titleHoverClass="group-hover:text-blue-300"
                            description="Membangun karakter dan prestasi akademik melalui pendekatan belajar yang inovatif."
                        />

                        {/* Card PPDB */}
                        <PortalCard
                            href="https://ppdb.sekolah-avicenna.sch.id/"
                            image="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            label="Pendaftaran"
                            labelColorClass="text-indigo-400"
                            title="PPDB Online"
                            titleHoverClass="group-hover:text-indigo-300"
                            description="Portal penerimaan peserta didik baru Sekolah Avicenna untuk semua jenjang pendidikan."
                        />

                        {/* Card AQR */}
                        <PortalCard
                            href="/dashboard"
                            image="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            label="Internal Sistem"
                            labelColorClass="text-cyan-400"
                            title="Sistem AQR"
                            titleHoverClass="group-hover:text-cyan-300"
                            description="Dasbor operasional, manajemen laporan, dan pencapaian target Akademik Avicenna."
                        />
                    </div>
                </div>
            </div>

            {/* Cabang Sekolah */}
            <section id="cabang" className="py-20 bg-slate-500 dark:bg-slate-800/50">
                <div className="container mx-auto px-6 max-w-10xl">
                    <div className="text-center mb-16">
                        <h2 className="text-3xl lg:text-4xl font-bold text-slate-200 dark:text-white mb-4">Lokasi Sekolah Kami</h2>
                        <p className="text-slate-300 dark:text-slate-400 max-w-2xl mx-auto">Tiga lokasi strategis dengan fasilitas lengkap yang siap mendidik calon-calon pemimpin masa depan.</p>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-0 rounded-[1.5rem] overflow-hidden shadow-2xl">
                        {/* Left Column (Grey/White) */}
                        <div className="lg:col-span-8 bg-white dark:bg-slate-800 p-8 lg:p-12 transition-all duration-500">
                            <div className="rounded-3xl overflow-hidden mb-8 shadow-lg h-64 lg:h-96 relative bg-slate-200 dark:bg-slate-700">
                                <img
                                    src={branches[activeBranch].image}
                                    alt={branches[activeBranch].name}
                                    className="w-full h-full object-cover transition-opacity duration-500"
                                />
                                <div className="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent flex items-end p-8">
                                    <div>
                                        <h3 className="text-3xl font-bold text-white mb-2">{branches[activeBranch].name}</h3>
                                        <p className="text-blue-300 font-semibold">{branches[activeBranch].levels}</p>
                                    </div>
                                </div>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div className="flex items-start gap-4 text-slate-700 dark:text-slate-300">
                                    <div className="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center shrink-0 shadow-sm text-blue-600 dark:text-blue-400">
                                        <i className="ph ph-map-pin text-2xl"></i>
                                    </div>
                                    <div className="pt-2">
                                        <h4 className="text-sm text-slate-500 dark:text-slate-400 font-medium mb-1">Alamat</h4>
                                        <p className="text-base font-medium">{branches[activeBranch].address}</p>
                                    </div>
                                </div>
                                <div className="space-y-6">
                                    <div className="flex items-start gap-4 text-slate-700 dark:text-slate-300">
                                        <div className="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center shrink-0 shadow-sm text-blue-600 dark:text-blue-400">
                                            <i className="ph ph-envelope text-2xl"></i>
                                        </div>
                                        <div className="pt-3">
                                            <p className="text-base font-medium">{branches[activeBranch].email}</p>
                                        </div>
                                    </div>
                                    <div className="flex items-start gap-4 text-slate-700 dark:text-slate-300">
                                        <div className="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center shrink-0 shadow-sm text-blue-600 dark:text-blue-400">
                                            <i className="ph ph-phone text-2xl"></i>
                                        </div>
                                        <div className="pt-3">
                                            <p className="text-base font-medium">{branches[activeBranch].phones.join(' / ')}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="mt-8 pt-8 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                                <a href={branches[activeBranch].website} target="_blank" rel="noreferrer" className="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-blue-600/30">
                                    Kunjungi Website <i className="ph ph-arrow-up-right"></i>
                                </a>
                            </div>
                        </div>

                        {/* Right Column (Blue) */}
                        <div className="lg:col-span-4 bg-blue-800 dark:bg-blue-800 p-8 lg:p-12 flex flex-col justify-center">
                            <h3 className="text-2xl font-bold text-white mb-8 text-center lg:text-left">Pilih Sekolah</h3>
                            <div className="flex flex-col gap-4">
                                {branches.map((branch, index) => (
                                    <button
                                        key={index}
                                        onMouseEnter={() => setActiveBranch(index)}
                                        onClick={() => setActiveBranch(index)}
                                        className={`w-full text-left p-6 rounded-2xl transition-all duration-300 flex items-center justify-between group ${activeBranch === index
                                            ? 'bg-white text-blue-600 shadow-xl scale-105'
                                            : 'bg-blue-700/50 hover:bg-blue-700 text-blue-100 hover:text-white border border-blue-500/30'
                                            }`}
                                    >
                                        <div className="flex items-center gap-4">
                                            <i className={`ph ${branch.icon} text-3xl ${activeBranch === index ? 'text-blue-600' : 'text-blue-300 group-hover:text-white'}`}></i>
                                            <span className="text-lg font-bold">{branch.name}</span>
                                        </div>
                                        <i className={`ph ph-caret-right text-xl transition-transform ${activeBranch === index ? 'translate-x-1' : 'opacity-50'}`}></i>
                                    </button>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Ruang Belajar & Peta Alumni */}
            <section className="py-20">
                <div className="container mx-auto px-6 max-w-10xl">
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
                        <div className="order-2 lg:order-1 space-y-6">
                            <div className="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-6">
                                <i className="ph ph-laptop text-3xl"></i>
                            </div>
                            <h2 className="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white">Ruang Belajar Digital Terintegrasi</h2>
                            <p className="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                                Ruang Belajar Sekolah Avicenna adalah sumber belajar digital yang tersedia untuk seluruh warga sekolah. Akses ke LMS Avicenna Pasti Bisa, Perpustakaan Digital, dan sumber belajar eksternal dalam satu pintu.
                            </p>
                            <a href="https://ruangbelajar.sekolah-avicenna.sch.id/" target="_blank" rel="noreferrer" className="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold hover:gap-3 transition-all">
                                Menuju Ruang Belajar <i className="ph ph-arrow-right"></i>
                            </a>
                        </div>
                        <div className="order-1 lg:order-2">
                            <div className="aspect-[4/3] rounded-3xl bg-gradient-to-br from-slate-200 to-slate-100 dark:from-slate-800 dark:to-slate-700 flex flex-col items-center justify-center p-8 border border-slate-200 dark:border-slate-700 shadow-2xl overflow-hidden relative group">
                                <i className="ph ph-play-circle text-7xl text-slate-400 dark:text-slate-500 group-hover:scale-110 transition-transform duration-500 mb-4 z-10"></i>
                                <span className="text-slate-500 dark:text-slate-400 font-medium z-10">Video Pembelajaran & Dokumentasi</span>
                                <div className="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                            </div>
                        </div>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <div className="aspect-[4/3] rounded-3xl bg-slate-900 dark:bg-black p-8 shadow-2xl relative overflow-hidden group">
                                <div className="absolute inset-0 opacity-40 group-hover:opacity-60 transition-opacity bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
                                <div className="relative z-10 h-full flex flex-col items-center justify-center text-center">
                                    <i className="ph ph-map-trifold text-6xl text-cyan-400 mb-4"></i>
                                    <div className="w-full max-w-xs mx-auto">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Map_pin_icon.svg/512px-Map_pin_icon.svg.png" className="w-16 h-16 mx-auto opacity-50 absolute right-10 top-10 animate-bounce" alt="" />
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Map_pin_icon.svg/512px-Map_pin_icon.svg.png" className="w-12 h-12 mx-auto opacity-30 absolute left-10 bottom-20 animate-pulse" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="space-y-6">
                            <div className="w-14 h-14 rounded-2xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600 dark:text-cyan-400 mb-6">
                                <i className="ph ph-globe-hemisphere-west text-3xl"></i>
                            </div>
                            <h2 className="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white">Peta Sebaran Alumni</h2>
                            <p className="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                                Lihat peta interaktif persebaran alumni SMA Avicenna yang telah melanjutkan pendidikan ke berbagai perguruan tinggi ternama, baik di dalam maupun di luar negeri.
                            </p>
                            <a href="https://sekolah-avicenna.sch.id/test_alumni.html" target="_blank" rel="noreferrer" className="inline-flex items-center gap-2 text-cyan-600 dark:text-cyan-400 font-bold hover:gap-3 transition-all">
                                Lihat Peta Alumni <i className="ph ph-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

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
