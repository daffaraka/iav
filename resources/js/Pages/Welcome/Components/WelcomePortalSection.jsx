import React from 'react';
import PortalCard from '../../../Components/PortalCard';

const PORTAL_CARDS = [
    {
        href: 'http://cinere.sekolah-avicenna.sch.id/',
        image: '/image/welcome/avicenna-cinere.jpg',
        label: 'Cabang',
        labelColorClass: 'text-blue-400',
        title: 'Avicenna Cinere',
        titleHoverClass: 'group-hover:text-blue-300',
        description: 'Jelajahi informasi kegiatan, pendaftaran, dan fasilitas di Sekolah Avicenna cabang Cinere.',
    },
    {
        href: 'http://jagakarsa.sekolah-avicenna.sch.id/',
        image: '/image/welcome/avicenna-jagakarsa.jpg',
        label: 'Cabang',
        labelColorClass: 'text-blue-400',
        title: 'Avicenna Jagakarsa',
        titleHoverClass: 'group-hover:text-blue-300',
        description: 'Pusat pendidikan modern dengan lingkungan yang mendukung tumbuh kembang siswa.',
    },
    {
        href: 'http://pamulang.sekolah-avicenna.sch.id/',
        image: '/image/welcome/avicenna-pamulang.jpg',
        label: 'Cabang',
        labelColorClass: 'text-blue-400',
        title: 'Avicenna Pamulang',
        titleHoverClass: 'group-hover:text-blue-300',
        description: 'Membangun karakter dan prestasi akademik melalui pendekatan belajar yang inovatif.',
    },
    {
        href: 'https://ppdb.sekolah-avicenna.sch.id/',
        image: 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        label: 'Pendaftaran',
        labelColorClass: 'text-indigo-400',
        title: 'PPDB Online',
        titleHoverClass: 'group-hover:text-indigo-300',
        description: 'Portal penerimaan peserta didik baru Sekolah Avicenna untuk semua jenjang pendidikan.',
    },
    {
        href: '/dashboard',
        image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        label: 'Internal Sistem',
        labelColorClass: 'text-cyan-400',
        title: 'Sistem AQR',
        titleHoverClass: 'group-hover:text-cyan-300',
        description: 'Dasbor operasional, manajemen laporan, dan pencapaian target Akademik Avicenna.',
    },
];

export default function WelcomePortalSection() {
    return (
        <div className="relative z-10 -mt-12 lg:-mt-24 mb-20 px-6">
            <div className="container mx-auto max-w-10xl">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 lg:gap-8 mt-24">
                    {PORTAL_CARDS.map((card) => (
                        <PortalCard key={card.title} {...card} />
                    ))}
                </div>
            </div>
        </div>
    );
}
