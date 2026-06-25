import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';
import SearchableSelect from '../../Components/SearchableSelect';

export default function PtEdit({ persebaran, ptns, siswas }) {
    const { data, setData, put, processing, errors } = useForm({
        pt_id: persebaran.pt_id || '',
        siswa_id: persebaran.siswa_id || '',
        fakultas: persebaran.fakultas || '',
        jurusan: persebaran.jurusan || '',
        rumpun_ilmu: persebaran.rumpun_ilmu || '',
        program_studi: persebaran.program_studi || '',
        starta: persebaran.starta || '',
        akreditasi: persebaran.akreditasi || '',
        jalur_masuk: persebaran.jalur_masuk || '',
    });

    const submit = (e) => {
        e.preventDefault();
        put(`/persebaran-ptn/${persebaran.id}`);
    };

    const ptnOptions = ptns.map(pt => ({ value: pt.id, label: pt.nama_pt }));
    const siswaOptions = siswas.map(s => ({ value: s.id, label: `${s.nama} (${s.sekolah?.sekolah || 'Tidak ada sekolah'})` }));

    return (
        <AuthenticatedLayout>
            <Head title="Edit Data Persebaran PTN/PTS" />

            <div className="p-4 sm:p-8">
                <div className="max-w-4xl mx-auto">
                    <div className="flex items-center justify-between mb-6">
                        <div>
                            <h1 className="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Edit Persebaran</h1>
                            <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Ubah data persebaran siswa ke Perguruan Tinggi</p>
                        </div>
                        <Link
                            href="/persebaran-ptn"
                            className="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-surface-800 border border-slate-200 dark:border-surface-700 rounded-xl hover:bg-slate-50 dark:hover:bg-surface-700 text-slate-700 dark:text-slate-300 transition-colors text-sm font-medium"
                        >
                            <i className="ph ph-arrow-left text-lg"></i>
                            Kembali
                        </Link>
                    </div>

                    <div className="bg-white dark:bg-surface-900 rounded-2xl shadow-sm border border-slate-200 dark:border-surface-800 overflow-hidden">
                        <form onSubmit={submit} className="p-6 sm:p-8">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <div className="space-y-2 md:col-span-2">
                                    <label className="text-sm font-medium text-slate-700 dark:text-slate-300">Pilih Siswa <span className="text-rose-500">*</span></label>
                                    <SearchableSelect
                                        options={siswaOptions}
                                        value={data.siswa_id}
                                        onChange={(val) => setData('siswa_id', val)}
                                        placeholder="Cari nama siswa..."
                                        error={errors.siswa_id}
                                    />
                                    {errors.siswa_id && <p className="text-sm text-rose-500">{errors.siswa_id}</p>}
                                </div>

                                <div className="space-y-2 md:col-span-2">
                                    <label className="text-sm font-medium text-slate-700 dark:text-slate-300">Pilih Perguruan Tinggi <span className="text-rose-500">*</span></label>
                                    <SearchableSelect
                                        options={ptnOptions}
                                        value={data.pt_id}
                                        onChange={(val) => setData('pt_id', val)}
                                        placeholder="Cari nama PTN/PTS..."
                                        error={errors.pt_id}
                                    />
                                    {errors.pt_id && <p className="text-sm text-rose-500">{errors.pt_id}</p>}
                                </div>

                                <div className="space-y-2">
                                    <label className="text-sm font-medium text-slate-700 dark:text-slate-300">Jalur Masuk</label>
                                    <input
                                        type="text"
                                        value={data.jalur_masuk}
                                        onChange={e => setData('jalur_masuk', e.target.value)}
                                        className="w-full rounded-xl border-slate-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Contoh: SNBP, SNBT, Mandiri"
                                    />
                                    {errors.jalur_masuk && <p className="text-sm text-rose-500">{errors.jalur_masuk}</p>}
                                </div>

                                <div className="space-y-2">
                                    <label className="text-sm font-medium text-slate-700 dark:text-slate-300">Fakultas</label>
                                    <input
                                        type="text"
                                        value={data.fakultas}
                                        onChange={e => setData('fakultas', e.target.value)}
                                        className="w-full rounded-xl border-slate-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Contoh: Teknik"
                                    />
                                    {errors.fakultas && <p className="text-sm text-rose-500">{errors.fakultas}</p>}
                                </div>

                                <div className="space-y-2">
                                    <label className="text-sm font-medium text-slate-700 dark:text-slate-300">Jurusan</label>
                                    <input
                                        type="text"
                                        value={data.jurusan}
                                        onChange={e => setData('jurusan', e.target.value)}
                                        className="w-full rounded-xl border-slate-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Contoh: Teknik Informatika"
                                    />
                                    {errors.jurusan && <p className="text-sm text-rose-500">{errors.jurusan}</p>}
                                </div>

                                <div className="space-y-2">
                                    <label className="text-sm font-medium text-slate-700 dark:text-slate-300">Rumpun Ilmu</label>
                                    <select
                                        value={data.rumpun_ilmu}
                                        onChange={e => setData('rumpun_ilmu', e.target.value)}
                                        className="w-full rounded-xl border-slate-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500"
                                    >
                                        <option value="">Pilih Rumpun Ilmu</option>
                                        <option value="Saintek">Saintek</option>
                                        <option value="Soshum">Soshum</option>
                                        <option value="Campuran">Campuran</option>
                                    </select>
                                    {errors.rumpun_ilmu && <p className="text-sm text-rose-500">{errors.rumpun_ilmu}</p>}
                                </div>

                                <div className="space-y-2">
                                    <label className="text-sm font-medium text-slate-700 dark:text-slate-300">Program Studi</label>
                                    <input
                                        type="text"
                                        value={data.program_studi}
                                        onChange={e => setData('program_studi', e.target.value)}
                                        className="w-full rounded-xl border-slate-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Contoh: Ilmu Komputer"
                                    />
                                    {errors.program_studi && <p className="text-sm text-rose-500">{errors.program_studi}</p>}
                                </div>

                                <div className="space-y-2">
                                    <label className="text-sm font-medium text-slate-700 dark:text-slate-300">Strata</label>
                                    <select
                                        value={data.starta}
                                        onChange={e => setData('starta', e.target.value)}
                                        className="w-full rounded-xl border-slate-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500"
                                    >
                                        <option value="">Pilih Strata</option>
                                        <option value="D1">D1</option>
                                        <option value="D2">D2</option>
                                        <option value="D3">D3</option>
                                        <option value="D4">D4</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                    {errors.starta && <p className="text-sm text-rose-500">{errors.starta}</p>}
                                </div>

                                <div className="space-y-2">
                                    <label className="text-sm font-medium text-slate-700 dark:text-slate-300">Akreditasi</label>
                                    <select
                                        value={data.akreditasi}
                                        onChange={e => setData('akreditasi', e.target.value)}
                                        className="w-full rounded-xl border-slate-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500"
                                    >
                                        <option value="">Pilih Akreditasi</option>
                                        <option value="Unggul">Unggul</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="Baik Sekali">Baik Sekali</option>
                                        <option value="Baik">Baik</option>
                                    </select>
                                    {errors.akreditasi && <p className="text-sm text-rose-500">{errors.akreditasi}</p>}
                                </div>
                            </div>

                            <div className="mt-8 flex justify-end gap-3 pt-6 border-t border-slate-100 dark:border-surface-800">
                                <Link
                                    href="/persebaran-ptn"
                                    className="px-5 py-2.5 bg-slate-100 dark:bg-surface-800 hover:bg-slate-200 dark:hover:bg-surface-700 text-slate-700 dark:text-slate-300 text-sm font-medium rounded-xl transition-colors"
                                >
                                    Batal
                                </Link>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-xl transition-colors shadow-sm shadow-emerald-500/20 disabled:opacity-70 disabled:cursor-not-allowed flex items-center gap-2"
                                >
                                    {processing ? (
                                        <>
                                            <i className="ph ph-spinner animate-spin text-lg"></i>
                                            Menyimpan...
                                        </>
                                    ) : (
                                        <>
                                            <i className="ph ph-check-circle text-lg"></i>
                                            Simpan Perubahan
                                        </>
                                    )}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
