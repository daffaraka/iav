import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function PrestasiSiswaEdit({ prestasi, users }) {
    const { data, setData, put, processing, errors } = useForm({
        tahun_pelajaran: prestasi.tahun_pelajaran || '',
        tanggal_pelaksanaan_lomba: prestasi.tanggal_pelaksanaan_lomba || '',
        nama_siswa: prestasi.nama_siswa || '',
        kelas: prestasi.kelas || '',
        wilayah: prestasi.wilayah || '',
        nama_lomba: prestasi.nama_lomba || '',
        jenis_lomba: prestasi.jenis_lomba || 'Akademik',
        mata_bidang_lomba: prestasi.mata_bidang_lomba || '',
        raihan_prestasi: prestasi.raihan_prestasi || '',
        tanggal_perolehan_lomba: prestasi.tanggal_perolehan_lomba || '',
        penyelenggara: prestasi.penyelenggara || '',
        level_lomba: prestasi.level_lomba || 'Kota/Kabupaten',
        nama_pelatih: prestasi.nama_pelatih || [],
        nama_pembina: prestasi.nama_pembina || [],
        tahapan_lomba: prestasi.tahapan_lomba || 'Event',
        kategori_lomba: prestasi.kategori_lomba || 'Individual',
        status_kurasi: prestasi.status_kurasi || 'Terkurasi',
        lanjutan_status_kurasi: prestasi.lanjutan_status_kurasi || 'Sudah diajukan kurasi',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put(`/prestasi-siswa/${prestasi.id}`);
    };

    const handleSelectChange = (e, field) => {
        const value = Array.from(e.target.selectedOptions, option => option.value);
        setData(field, value);
    };

    return (
        <AuthenticatedLayout>
            <Head title="Edit Prestasi Siswa" />

            <div className="mb-6">
                <Link href="/prestasi-siswa" className="text-brand-600 hover:text-brand-700 flex items-center text-sm font-medium transition-colors">
                    <i className="ph ph-arrow-left mr-2"></i>
                    Kembali ke Data Prestasi Siswa
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-soft border border-surface-200 dark:border-surface-700 p-6">
                <h2 className="text-xl font-bold text-slate-800 dark:text-white mb-6">Edit Data Prestasi Siswa</h2>

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Tahun Pelajaran</label>
                            <input
                                type="text"
                                value={data.tahun_pelajaran}
                                onChange={e => setData('tahun_pelajaran', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.tahun_pelajaran && <p className="text-sm text-red-600 mt-1">{errors.tahun_pelajaran}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Siswa</label>
                            <input
                                type="text"
                                value={data.nama_siswa}
                                onChange={e => setData('nama_siswa', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.nama_siswa && <p className="text-sm text-red-600 mt-1">{errors.nama_siswa}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Kelas</label>
                            <input
                                type="text"
                                value={data.kelas}
                                onChange={e => setData('kelas', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.kelas && <p className="text-sm text-red-600 mt-1">{errors.kelas}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Wilayah</label>
                            <input
                                type="text"
                                value={data.wilayah}
                                onChange={e => setData('wilayah', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.wilayah && <p className="text-sm text-red-600 mt-1">{errors.wilayah}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Lomba</label>
                            <input
                                type="text"
                                value={data.nama_lomba}
                                onChange={e => setData('nama_lomba', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.nama_lomba && <p className="text-sm text-red-600 mt-1">{errors.nama_lomba}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Jenis Lomba</label>
                            <select
                                value={data.jenis_lomba}
                                onChange={e => setData('jenis_lomba', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            >
                                <option value="Akademik">Akademik</option>
                                <option value="Non-Akademik">Non-Akademik</option>
                            </select>
                            {errors.jenis_lomba && <p className="text-sm text-red-600 mt-1">{errors.jenis_lomba}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Bidang Lomba</label>
                            <input
                                type="text"
                                value={data.mata_bidang_lomba}
                                onChange={e => setData('mata_bidang_lomba', e.target.value)}
                                placeholder="Contoh: Matematika, Futsal, Tari"
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.mata_bidang_lomba && <p className="text-sm text-red-600 mt-1">{errors.mata_bidang_lomba}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Juara / Raihan Prestasi</label>
                            <input
                                type="text"
                                value={data.raihan_prestasi}
                                onChange={e => setData('raihan_prestasi', e.target.value)}
                                placeholder="Contoh: Juara 1, Finalis"
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.raihan_prestasi && <p className="text-sm text-red-600 mt-1">{errors.raihan_prestasi}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Penyelenggara</label>
                            <input
                                type="text"
                                value={data.penyelenggara}
                                onChange={e => setData('penyelenggara', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.penyelenggara && <p className="text-sm text-red-600 mt-1">{errors.penyelenggara}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Level Lomba</label>
                            <select
                                value={data.level_lomba}
                                onChange={e => setData('level_lomba', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            >
                                <option value="Antar Sekolah">Antar Sekolah</option>
                                <option value="Kecamatan">Kecamatan</option>
                                <option value="Kota/Kabupaten">Kota/Kabupaten</option>
                                <option value="Provinsi">Provinsi</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                            </select>
                            {errors.level_lomba && <p className="text-sm text-red-600 mt-1">{errors.level_lomba}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Pelaksanaan</label>
                            <input
                                type="date"
                                value={data.tanggal_pelaksanaan_lomba}
                                onChange={e => setData('tanggal_pelaksanaan_lomba', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.tanggal_pelaksanaan_lomba && <p className="text-sm text-red-600 mt-1">{errors.tanggal_pelaksanaan_lomba}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Perolehan</label>
                            <input
                                type="date"
                                value={data.tanggal_perolehan_lomba}
                                onChange={e => setData('tanggal_perolehan_lomba', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.tanggal_perolehan_lomba && <p className="text-sm text-red-600 mt-1">{errors.tanggal_perolehan_lomba}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Tahapan Lomba</label>
                            <input
                                type="text"
                                value={data.tahapan_lomba}
                                onChange={e => setData('tahapan_lomba', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.tahapan_lomba && <p className="text-sm text-red-600 mt-1">{errors.tahapan_lomba}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Kategori Lomba</label>
                            <select
                                value={data.kategori_lomba}
                                onChange={e => setData('kategori_lomba', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            >
                                <option value="Individual">Individual</option>
                                <option value="Kelompok">Kelompok</option>
                            </select>
                            {errors.kategori_lomba && <p className="text-sm text-red-600 mt-1">{errors.kategori_lomba}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Status Kurasi</label>
                            <select
                                value={data.status_kurasi}
                                onChange={e => setData('status_kurasi', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            >
                                <option value="Terkurasi">Terkurasi</option>
                                <option value="Tidak Terkurasi">Tidak Terkurasi</option>
                            </select>
                            {errors.status_kurasi && <p className="text-sm text-red-600 mt-1">{errors.status_kurasi}</p>}
                        </div>

                        <div className="space-y-1">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Lanjutan Status Kurasi</label>
                            <input
                                type="text"
                                value={data.lanjutan_status_kurasi}
                                onChange={e => setData('lanjutan_status_kurasi', e.target.value)}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500"
                            />
                            {errors.lanjutan_status_kurasi && <p className="text-sm text-red-600 mt-1">{errors.lanjutan_status_kurasi}</p>}
                        </div>

                        {/* Multi-Select for Pelatih and Pembina */}
                        <div className="space-y-1 col-span-1 md:col-span-2">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Pelatih (Multi Select)</label>
                            <select
                                multiple
                                value={data.nama_pelatih}
                                onChange={(e) => handleSelectChange(e, 'nama_pelatih')}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500 h-32"
                            >
                                {users.map(user => (
                                    <option key={user.id} value={user.name}>{user.name}</option>
                                ))}
                            </select>
                            <p className="text-xs text-slate-500">Tahan tombol Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</p>
                            {errors.nama_pelatih && <p className="text-sm text-red-600 mt-1">{errors.nama_pelatih}</p>}
                        </div>

                        <div className="space-y-1 col-span-1 md:col-span-2">
                            <label className="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Pembina (Multi Select)</label>
                            <select
                                multiple
                                value={data.nama_pembina}
                                onChange={(e) => handleSelectChange(e, 'nama_pembina')}
                                className="w-full rounded-xl border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-slate-200 focus:ring-brand-500 focus:border-brand-500 h-32"
                            >
                                {users.map(user => (
                                    <option key={user.id} value={user.name}>{user.name}</option>
                                ))}
                            </select>
                            <p className="text-xs text-slate-500">Tahan tombol Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</p>
                            {errors.nama_pembina && <p className="text-sm text-red-600 mt-1">{errors.nama_pembina}</p>}
                        </div>

                    </div>

                    <div className="flex justify-end pt-4 border-t border-surface-200 dark:border-surface-700">
                        <button
                            type="submit"
                            disabled={processing}
                            className="px-6 py-2 bg-brand-600 text-white rounded-xl font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 transition-all disabled:opacity-50"
                        >
                            {processing ? 'Menyimpan...' : 'Simpan Perubahan'}
                        </button>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
