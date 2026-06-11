import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function PrestasiCreate({ siswa }) {
    const { data, setData, post, processing, errors } = useForm({
        master_siswa_id: '',
        nama_lomba: '',
        kategori_lomba: '',
        tipe_lomba: '',
        tingkat_lomba: '',
        status_lomba: '',
        tahun_pelajaran: '',
        guru_eskul: '',
        guru_pendamping: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/data-prestasi');
    };

    return (
        <AuthenticatedLayout>
            <Head title="Tambah Data Prestasi" />

            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Tambah Data Prestasi</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Masukkan data prestasi baru siswa.</p>
                </div>
                <Link
                    href="/data-prestasi"
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 dark:bg-surface-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium hover:bg-surface-200 dark:hover:bg-surface-600 transition-all"
                >
                    <i className="ph ph-arrow-left mr-2 text-lg"></i>
                    Kembali
                </Link>
            </div>

            <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 overflow-hidden max-w-3xl">
                <div className="p-6">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        
                        {/* SECTION 1: SISWA */}
                        <div className="mb-8">
                            <h3 className="text-lg font-semibold text-slate-800 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-2 mb-4">
                                1. Data Siswa
                            </h3>
                            <div className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Siswa <span className="text-red-500">*</span></label>
                                    <select
                                        value={data.master_siswa_id}
                                        onChange={e => setData('master_siswa_id', e.target.value)}
                                        className={`w-full px-4 py-2.5 rounded-xl border ${errors.master_siswa_id ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all`}
                                        required
                                    >
                                        <option value="">-- Pilih Siswa --</option>
                                        {siswa.map(s => (
                                            <option key={s.id} value={s.id}>{s.nama} - {s.sekolah?.unit}</option>
                                        ))}
                                    </select>
                                    {errors.master_siswa_id && <p className="mt-1.5 text-sm text-red-500">{errors.master_siswa_id}</p>}
                                </div>
                            </div>
                        </div>

                        {/* SECTION 2: LOMBA */}
                        <div className="mb-8">
                            <h3 className="text-lg font-semibold text-slate-800 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-2 mb-4">
                                2. Data Lomba
                            </h3>
                            <div className="space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Lomba <span className="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    value={data.nama_lomba}
                                    onChange={e => setData('nama_lomba', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.nama_lomba ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all`}
                                    placeholder="Masukkan nama lomba"
                                    required
                                />
                                {errors.nama_lomba && <p className="mt-1.5 text-sm text-red-500">{errors.nama_lomba}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kategori Lomba</label>
                                <select
                                    value={data.kategori_lomba}
                                    onChange={e => {
                                        setData(data => ({
                                            ...data,
                                            kategori_lomba: e.target.value,
                                            tipe_lomba: ''
                                        }));
                                    }}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.kategori_lomba ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all`}
                                >
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Akademik">Akademik</option>
                                    <option value="Non Akademik">Non Akademik</option>
                                </select>
                                {errors.kategori_lomba && <p className="mt-1.5 text-sm text-red-500">{errors.kategori_lomba}</p>}
                            </div>
                        </div>

                        {data.kategori_lomba && (
                            <div className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tipe Lomba</label>
                                    <select
                                        value={data.tipe_lomba}
                                        onChange={e => setData('tipe_lomba', e.target.value)}
                                        className={`w-full px-4 py-2.5 rounded-xl border ${errors.tipe_lomba ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all`}
                                    >
                                        <option value="">-- Pilih Tipe Lomba --</option>
                                        {data.kategori_lomba === 'Akademik' ? (
                                            <>
                                                <option value="Sains">Sains</option>
                                                <option value="Matematika">Matematika</option>
                                                <option value="Bahasa">Bahasa</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </>
                                        ) : (
                                            <>
                                                <option value="Olahraga">Olahraga</option>
                                                <option value="Seni">Seni</option>
                                                <option value="Keagamaan">Keagamaan</option>
                                                <option value="Pramuka/Kepemimpinan">Pramuka/Kepemimpinan</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </>
                                        )}
                                    </select>
                                    {errors.tipe_lomba && <p className="mt-1.5 text-sm text-red-500">{errors.tipe_lomba}</p>}
                                </div>
                            </div>
                        )}

                        <div className="space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tingkat Lomba <span className="text-red-500">*</span></label>
                                <select
                                    value={data.tingkat_lomba}
                                    onChange={e => setData('tingkat_lomba', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.tingkat_lomba ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all`}
                                    required
                                >
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="Internasional">Internasional</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Provinsi">Provinsi</option>
                                    <option value="Kota/Kabupaten">Kota/Kabupaten</option>
                                    <option value="Kecamatan">Kecamatan</option>
                                    <option value="Sekolah">Sekolah</option>
                                </select>
                                {errors.tingkat_lomba && <p className="mt-1.5 text-sm text-red-500">{errors.tingkat_lomba}</p>}
                            </div>
                        </div>

                        <div className="space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Status Lomba <span className="text-red-500">*</span></label>
                                <select
                                    value={data.status_lomba}
                                    onChange={e => setData('status_lomba', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.status_lomba ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all`}
                                    required
                                >
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Terkurasi">Terkurasi</option>
                                    <option value="Belum Terkurasi">Belum Terkurasi</option>
                                </select>
                                {errors.status_lomba && <p className="mt-1.5 text-sm text-red-500">{errors.status_lomba}</p>}
                            </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tahun Pelajaran</label>
                                    <input
                                        type="text"
                                        value={data.tahun_pelajaran}
                                        onChange={e => setData('tahun_pelajaran', e.target.value)}
                                        className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20 bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all"
                                        placeholder="Contoh: 2023/2024"
                                    />
                                </div>
                            </div>
                        </div>

                        {/* SECTION 3: GURU */}
                        <div className="mb-8">
                            <h3 className="text-lg font-semibold text-slate-800 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-2 mb-4">
                                3. Data Guru
                            </h3>
                            <div className="space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Guru Eskul</label>
                                <input
                                    type="text"
                                    value={data.guru_eskul}
                                    onChange={e => setData('guru_eskul', e.target.value)}
                                    className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20 bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all"
                                    placeholder="Nama Guru Eskul (Opsional)"
                                />
                            </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Guru Pendamping</label>
                                    <input
                                        type="text"
                                        value={data.guru_pendamping}
                                        onChange={e => setData('guru_pendamping', e.target.value)}
                                        className="w-full px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-600 focus:border-brand-500 focus:ring-brand-500/20 bg-white dark:bg-surface-900 text-slate-800 dark:text-white transition-all"
                                        placeholder="Nama Guru Pendamping (Opsional)"
                                    />
                                </div>
                            </div>
                        </div>

                        <div className="flex items-center justify-end gap-3 pt-6 border-t border-surface-100 dark:border-surface-700">
                            <Link
                                href="/data-prestasi"
                                className="px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="px-5 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-medium shadow-soft shadow-brand-500/30 hover:bg-brand-700 disabled:opacity-70 disabled:cursor-not-allowed transition-all flex items-center"
                            >
                                {processing && <i className="ph ph-spinner animate-spin mr-2"></i>}
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
