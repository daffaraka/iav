import React, { useState } from 'react';

const BRANCHES = [
    {
        name: 'Avicenna Jagakarsa',
        levels: 'TK - SD - SMP - SMA',
        address: 'Jl. M Kahfi II No.66, Jagakarsa, Jakarta Selatan, 12610, DKI Jakarta.',
        email: 'jagakarsa@sekolah-avicenna.sch.id',
        phones: ['(021) - 7888 4887', '(021) - 7888 4942'],
        website: 'http://jagakarsa.sekolah-avicenna.sch.id/',
        icon: 'ph-buildings',
        image: '/image/welcome/avicenna-jagakarsa.jpg',
    },
    {
        name: 'Avicenna Cinere',
        levels: 'SD - SMP - SMA',
        address: 'Jl. Flamboyan Blok F, Cinere, Depok, 16514, Jawa Barat. Jl. H. Rosyid No. 21, Cinere, Depok.',
        email: 'cinere@sekolah-avicenna.sch.id',
        phones: ['(021) - 754 7516', '(021) - 754 6953'],
        website: 'http://cinere.sekolah-avicenna.sch.id/',
        icon: 'ph-graduation-cap',
        image: '/image/welcome/avicenna-cinere.jpg',
    },
    {
        name: 'Avicenna Pamulang',
        levels: 'Kelompok Bermain',
        address: 'JL. Villa Pamulang Blok AJ (Sektor 1), Pondok Benda Pamulang, Tangerang Selatan, 15416, Banten.',
        email: 'pamulang@sekolah-avicenna.sch.id',
        phones: ['(021) - 7470 5045', '(021) - 743 1847'],
        website: 'http://pamulang.sekolah-avicenna.sch.id/',
        icon: 'ph-baby',
        image: '/image/welcome/avicenna-pamulang.jpg',
    },
];

export default function WelcomeBranchSection() {
    const [activeBranch, setActiveBranch] = useState(0);
    const current = BRANCHES[activeBranch];

    return (
        <section id="cabang" className="py-20 bg-slate-500 dark:bg-slate-800/50">
            <div className="container mx-auto px-6 max-w-10xl">
                <div className="text-center mb-16">
                    <h2 className="text-3xl lg:text-4xl font-bold text-slate-200 dark:text-white mb-4">Lokasi Sekolah Kami</h2>
                    <p className="text-slate-300 dark:text-slate-400 max-w-2xl mx-auto">
                        Tiga lokasi strategis dengan fasilitas lengkap yang siap mendidik calon-calon pemimpin masa depan.
                    </p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-12 gap-0 rounded-[1.5rem] overflow-hidden shadow-2xl">
                    {/* Left Column */}
                    <div className="lg:col-span-8 bg-white dark:bg-slate-800 p-8 lg:p-12 transition-all duration-500">
                        <div className="rounded-3xl overflow-hidden mb-8 shadow-lg h-64 lg:h-96 relative bg-slate-200 dark:bg-slate-700">
                            <img
                                src={current.image}
                                alt={current.name}
                                className="w-full h-full object-cover transition-opacity duration-500"
                            />
                            <div className="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent flex items-end p-8">
                                <div>
                                    <h3 className="text-3xl font-bold text-white mb-2">{current.name}</h3>
                                    <p className="text-blue-300 font-semibold">{current.levels}</p>
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
                                    <p className="text-base font-medium">{current.address}</p>
                                </div>
                            </div>
                            <div className="space-y-6">
                                <div className="flex items-start gap-4 text-slate-700 dark:text-slate-300">
                                    <div className="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center shrink-0 shadow-sm text-blue-600 dark:text-blue-400">
                                        <i className="ph ph-envelope text-2xl"></i>
                                    </div>
                                    <div className="pt-3">
                                        <p className="text-base font-medium">{current.email}</p>
                                    </div>
                                </div>
                                <div className="flex items-start gap-4 text-slate-700 dark:text-slate-300">
                                    <div className="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center shrink-0 shadow-sm text-blue-600 dark:text-blue-400">
                                        <i className="ph ph-phone text-2xl"></i>
                                    </div>
                                    <div className="pt-3">
                                        <p className="text-base font-medium">{current.phones.join(' / ')}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="mt-8 pt-8 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                            <a
                                href={current.website}
                                target="_blank"
                                rel="noreferrer"
                                className="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-blue-600/30"
                            >
                                Kunjungi Website <i className="ph ph-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>

                    {/* Right Column */}
                    <div className="lg:col-span-4 bg-blue-800 dark:bg-blue-800 p-8 lg:p-12 flex flex-col justify-center">
                        <h3 className="text-2xl font-bold text-white mb-8 text-center lg:text-left">Pilih Sekolah</h3>
                        <div className="flex flex-col gap-4">
                            {BRANCHES.map((branch, index) => (
                                <button
                                    key={branch.name}
                                    onMouseEnter={() => setActiveBranch(index)}
                                    onClick={() => setActiveBranch(index)}
                                    className={`w-full text-left p-6 rounded-2xl transition-all duration-300 flex items-center justify-between group ${
                                        activeBranch === index
                                            ? 'bg-white text-blue-600 shadow-xl scale-105'
                                            : 'bg-blue-700/50 hover:bg-blue-700 text-blue-100 hover:text-white border border-blue-500/30'
                                    }`}
                                >
                                    <div className="flex items-center gap-4">
                                        <i
                                            className={`ph ${branch.icon} text-3xl ${
                                                activeBranch === index ? 'text-blue-600' : 'text-blue-300 group-hover:text-white'
                                            }`}
                                        ></i>
                                        <span className="text-lg font-bold">{branch.name}</span>
                                    </div>
                                    <i
                                        className={`ph ph-caret-right text-xl transition-transform ${
                                            activeBranch === index ? 'translate-x-1' : 'opacity-50'
                                        }`}
                                    ></i>
                                </button>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
