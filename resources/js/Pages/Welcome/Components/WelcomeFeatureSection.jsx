import React from 'react';

export default function WelcomeFeatureSection() {
    return (
        <section className="py-20">
            <div className="container mx-auto px-6 max-w-10xl">
                {/* Ruang Belajar Digital Terintegrasi */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
                    <div className="order-2 lg:order-1 space-y-6">
                        <div className="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-6">
                            <i className="ph ph-laptop text-3xl"></i>
                        </div>
                        <h2 className="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white">
                            Ruang Belajar Digital Terintegrasi
                        </h2>
                        <p className="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            Ruang Belajar Sekolah Avicenna adalah sumber belajar digital yang tersedia untuk seluruh warga sekolah. Akses ke LMS Avicenna Pasti Bisa, Perpustakaan Digital, dan sumber belajar eksternal dalam satu pintu.
                        </p>
                        <a
                            href="https://ruangbelajar.sekolah-avicenna.sch.id/"
                            target="_blank"
                            rel="noreferrer"
                            className="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold hover:gap-3 transition-all"
                        >
                            Menuju Ruang Belajar <i className="ph ph-arrow-right"></i>
                        </a>
                    </div>
                    <div className="order-1 lg:order-2">
                        <div className="aspect-[4/3] rounded-3xl border border-slate-200 dark:border-slate-700 shadow-2xl overflow-hidden relative group bg-slate-100 dark:bg-slate-800">
                            <img
                                src="/image/welcome/ruang-belajar-digital.jpg"
                                alt="Ruang Belajar Digital Terintegrasi Sekolah Avicenna"
                                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            />
                            <div className="absolute inset-0 bg-gradient-to-t from-slate-900/75 via-slate-900/15 to-transparent flex items-end p-6 lg:p-8">
                                <div className="flex items-center gap-3 text-white">
                                    <span className="w-11 h-11 rounded-2xl bg-blue-600/90 backdrop-blur-sm flex items-center justify-center shadow-lg">
                                        <i className="ph ph-play-circle text-2xl"></i>
                                    </span>
                                    <div>
                                        <p className="text-xs font-semibold uppercase tracking-wider text-blue-200">
                                            E-Learning & Perpustakaan Digital
                                        </p>
                                        <p className="text-base font-bold">Video Pembelajaran & Dokumentasi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Peta Sebaran Alumni */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div className="aspect-[4/3] rounded-3xl bg-slate-900 dark:bg-black shadow-2xl relative overflow-hidden group border border-slate-800">
                            <img
                                src="/image/welcome/peta-sebaran-alumni.jpg"
                                alt="Peta Sebaran Alumni SMA Avicenna di Perguruan Tinggi Dalam dan Luar Negeri"
                                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            />
                            <div className="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6 lg:p-8">
                                <div className="flex items-center gap-3 text-white">
                                    <span className="w-11 h-11 rounded-2xl bg-cyan-500/20 border border-cyan-400/40 backdrop-blur-sm flex items-center justify-center text-cyan-300">
                                        <i className="ph ph-map-trifold text-2xl"></i>
                                    </span>
                                    <div>
                                        <p className="text-xs font-semibold uppercase tracking-wider text-cyan-300">
                                            Jejaring Perguruan Tinggi
                                        </p>
                                        <p className="text-base font-bold">Sebaran Alumni Nasional & Internasional</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="space-y-6">
                        <div className="w-14 h-14 rounded-2xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600 dark:text-cyan-400 mb-6">
                            <i className="ph ph-globe-hemisphere-west text-3xl"></i>
                        </div>
                        <h2 className="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white">
                            Peta Sebaran Alumni
                        </h2>
                        <p className="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            Lihat peta interaktif persebaran alumni SMA Avicenna yang telah melanjutkan pendidikan ke berbagai perguruan tinggi ternama, baik di dalam maupun di luar negeri.
                        </p>
                        <a
                            href="https://sekolah-avicenna.sch.id/test_alumni.html"
                            target="_blank"
                            rel="noreferrer"
                            className="inline-flex items-center gap-2 text-cyan-600 dark:text-cyan-400 font-bold hover:gap-3 transition-all"
                        >
                            Lihat Peta Alumni <i className="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    );
}
