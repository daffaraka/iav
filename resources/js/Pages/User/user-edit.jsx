import React, { useState, useEffect } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function UserEdit({ user, roles, jabatans, departemens, title, permissions, userPermissions }) {
    const [showDataSekarang, setShowDataSekarang] = useState(false);
    const [isWaliKelas, setIsWaliKelas] = useState(!!user.jenjang || !!user.kelas);

    const { data, setData, put, processing, errors } = useForm({
        name: user.name || '',
        email: user.email || '',
        password: '',
        role: user.roles && user.roles.length > 0 ? user.roles[0].name : '',
        unit: user.unit || '',
        jenjang: user.jenjang || '',
        kelas: user.kelas || '',
        sub_kelas: user.sub_kelas || ''
    });

    const { data: permData, setData: setPermData, put: putPerm, processing: processingPerm } = useForm({
        update_permissions: 1,
        direct_permission: Object.values(userPermissions) || []
    });

    const kelasMap = {
        'SD': { start: 1, end: 6 },
        'SMP': { start: 7, end: 9 },
        'SMA': { start: 10, end: 12 }
    };

    const submitIdentity = (e) => {
        e.preventDefault();
        const submitData = { ...data };
        if (!isWaliKelas) {
            submitData.jenjang = '';
            submitData.kelas = '';
            submitData.sub_kelas = '';
        }
        put(`/user/${user.id}`, { data: submitData });
    };

    const submitPermissions = (e) => {
        e.preventDefault();
        putPerm(`/user/${user.id}`);
    };

    const handlePermissionToggle = (permName) => {
        const perms = [...permData.direct_permission];
        if (perms.includes(permName)) {
            setPermData('direct_permission', perms.filter(p => p !== permName));
        } else {
            setPermData('direct_permission', [...perms, permName]);
        }
    };

    const handleCheckAllPerm = () => {
        setPermData('direct_permission', permissions.map(p => p.name));
    };

    const handleUncheckAllPerm = () => {
        setPermData('direct_permission', []);
    };

    const toggleGroupPerms = (modules) => {
        const groupPerms = [];
        modules.forEach(mod => {
            ['view', 'create', 'edit', 'delete'].forEach(act => {
                groupPerms.push(`${act}-${mod}`);
            });
        });

        const currentPerms = [...permData.direct_permission];
        const allGroupChecked = groupPerms.every(p => currentPerms.includes(p));

        if (allGroupChecked) {
            setPermData('direct_permission', currentPerms.filter(p => !groupPerms.includes(p)));
        } else {
            const newPerms = new Set([...currentPerms, ...groupPerms]);
            setPermData('direct_permission', Array.from(newPerms));
        }
    };

    const moduleGroups = [
        { label: 'Dashboard', color: '#696cff', modules: ['dashboard'] },
        { label: 'Sekolah & Prestasi', color: '#28c76f', modules: ['sekolah', 'data-prestasi'] },
        { label: 'Lowongan', color: '#ff6f61', modules: ['lowongan-pekerjaan', 'lowongan-apply', 'lowongan-progress'] },
        { label: 'Departemen & SDM', color: '#ff9f43', modules: ['departement', 'wig', 'lead-measure', 'task-process', 'wig-progress'] },
        { label: 'AQR (Aduan & Tiket)', color: '#00cfe8', modules: ['aqr-dashboard', 'tiket', 'aduan', 'progres-tiket', 'rating-tiket'] },
        { label: 'User Management', color: '#7367f0', modules: ['user'] },
    ];

    const actions = ['view', 'create', 'edit', 'delete'];
    
    // Calculate specific permissions (those not in moduleGroups)
    const moduleBasedNames = [];
    moduleGroups.forEach(g => {
        g.modules.forEach(m => {
            actions.forEach(a => moduleBasedNames.push(`${a}-${m}`));
        });
    });
    const specificPermissions = permissions.filter(p => !moduleBasedNames.includes(p.name));

    return (
        <AuthenticatedLayout>
            <Head title={title || "Edit User"} />

            <div className="mb-6 flex items-center justify-between">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">{title || "Edit User"}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Ubah data pengguna dan pengaturan hak akses</p>
                </div>
                <Link 
                    href="/user" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-arrow-left mr-2"></i>
                    Kembali
                </Link>
            </div>

            {/* Data Sekarang Accordion */}
            <div className="mb-6">
                <button 
                    onClick={() => setShowDataSekarang(!showDataSekarang)}
                    className="px-4 py-2 bg-warning-500 hover:bg-warning-600 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm"
                >
                    {showDataSekarang ? 'Tutup Data Sekarang' : 'Lihat Data Sekarang'}
                </button>
                
                {showDataSekarang && (
                    <div className="mt-4 bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 p-6 shadow-soft transition-all duration-300">
                        <h3 className="text-lg font-bold text-slate-800 dark:text-white mb-4">Data Saat Ini</h3>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div className="space-y-4">
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase">Nama</label>
                                    <div className="mt-1 text-sm text-slate-800 dark:text-slate-200 font-medium">{user.name}</div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase">Email</label>
                                    <div className="mt-1 text-sm text-slate-800 dark:text-slate-200 font-medium">{user.email}</div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase">NIP</label>
                                    <div className="mt-1 text-sm text-slate-800 dark:text-slate-200 font-medium">{user.nip || '-'}</div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase">Unit</label>
                                    <div className="mt-1 text-sm text-slate-800 dark:text-slate-200 font-medium">{user.unit || '-'}</div>
                                </div>
                            </div>
                            <div className="space-y-4">
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase">Jenjang</label>
                                    <div className="mt-1 text-sm text-slate-800 dark:text-slate-200 font-medium">{user.jenjang || '-'}</div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase">Departemen</label>
                                    <div className="mt-1 text-sm text-slate-800 dark:text-slate-200 font-medium">{user.departemen || '-'}</div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase">Jabatan</label>
                                    <div className="mt-1 text-sm text-slate-800 dark:text-slate-200 font-medium">{user.jabatan || '-'}</div>
                                </div>
                                <div>
                                    <label className="block text-xs font-medium text-slate-500 uppercase">Wali Kelas</label>
                                    <div className="mt-1 text-sm text-slate-800 dark:text-slate-200 font-medium">
                                        {user.kelas ? `${user.kelas}${user.sub_kelas || ''}` : '-'}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {/* Form Data User */}
                <div className="lg:col-span-1 space-y-6">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50">
                            <h2 className="font-semibold text-slate-800 dark:text-white">Identitas & Akses</h2>
                        </div>
                        <div className="p-6">
                            <form onSubmit={submitIdentity} className="space-y-5">
                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Nama <span className="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        value={data.name}
                                        onChange={(e) => setData('name', e.target.value)}
                                        className={`w-full px-4 py-2.5 rounded-xl border ${errors.name ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all`}
                                        required
                                    />
                                    {errors.name && <p className="mt-1 text-sm text-red-500">{errors.name}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Email <span className="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        value={data.email}
                                        onChange={(e) => setData('email', e.target.value)}
                                        className={`w-full px-4 py-2.5 rounded-xl border ${errors.email ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all`}
                                        required
                                    />
                                    {errors.email && <p className="mt-1 text-sm text-red-500">{errors.email}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Password <span className="text-xs text-slate-500 font-normal">(Isi jika ingin mengubah)</span>
                                    </label>
                                    <input
                                        type="password"
                                        value={data.password}
                                        onChange={(e) => setData('password', e.target.value)}
                                        className={`w-full px-4 py-2.5 rounded-xl border ${errors.password ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all`}
                                    />
                                    {errors.password && <p className="mt-1 text-sm text-red-500">{errors.password}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Role <span className="text-red-500">*</span>
                                    </label>
                                    <select
                                        value={data.role}
                                        onChange={(e) => setData('role', e.target.value)}
                                        className={`w-full px-4 py-2.5 rounded-xl border ${errors.role ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all`}
                                        required
                                    >
                                        <option value="">Pilih Role</option>
                                        {roles && roles.map(r => (
                                            <option key={r.id} value={r.name}>{r.name}</option>
                                        ))}
                                    </select>
                                    {errors.role && <p className="mt-1 text-sm text-red-500">{errors.role}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Unit</label>
                                    <select
                                        value={data.unit}
                                        onChange={(e) => setData('unit', e.target.value)}
                                        className={`w-full px-4 py-2.5 rounded-xl border ${errors.unit ? 'border-red-500' : 'border-surface-200 dark:border-surface-600'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500 transition-all`}
                                    >
                                        <option value="">Pilih Unit</option>
                                        <option value="Cinere">Cinere</option>
                                        <option value="Jagakarsa">Jagakarsa</option>
                                        <option value="Pamulang">Pamulang</option>
                                        <option value="BPS">BPS</option>
                                    </select>
                                </div>

                                <div className="p-4 bg-surface-50 dark:bg-surface-900/50 rounded-xl border border-surface-200 dark:border-surface-700 space-y-4">
                                    <label className="flex items-center gap-2 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            checked={isWaliKelas}
                                            onChange={() => setIsWaliKelas(!isWaliKelas)}
                                            className="rounded border-surface-300 text-brand-600 focus:ring-brand-500 w-4 h-4"
                                        />
                                        <span className="text-sm font-medium text-slate-700 dark:text-slate-300">Apakah wali kelas?</span>
                                    </label>

                                    {isWaliKelas && (
                                        <div className="space-y-4 pt-2 border-t border-surface-200 dark:border-surface-700">
                                            <div>
                                                <label className="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Jenjang</label>
                                                <select
                                                    value={data.jenjang}
                                                    onChange={(e) => setData('jenjang', e.target.value)}
                                                    className="w-full px-3 py-2 rounded-lg border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                                >
                                                    <option value="">Pilih Jenjang</option>
                                                    <option value="KB">KB</option>
                                                    <option value="TK">TK</option>
                                                    <option value="SD">SD</option>
                                                    <option value="SMP">SMP</option>
                                                    <option value="SMA">SMA</option>
                                                </select>
                                            </div>
                                            
                                            {data.jenjang && kelasMap[data.jenjang] && (
                                                <div className="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label className="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Kelas</label>
                                                        <select
                                                            value={data.kelas}
                                                            onChange={(e) => setData('kelas', e.target.value)}
                                                            className="w-full px-3 py-2 rounded-lg border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                                        >
                                                            <option value="">Pilih</option>
                                                            {Array.from({ length: kelasMap[data.jenjang].end - kelasMap[data.jenjang].start + 1 }, (_, i) => i + kelasMap[data.jenjang].start).map(k => (
                                                                <option key={k} value={k}>{k}</option>
                                                            ))}
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label className="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Sub</label>
                                                        <select
                                                            value={data.sub_kelas}
                                                            onChange={(e) => setData('sub_kelas', e.target.value)}
                                                            className="w-full px-3 py-2 rounded-lg border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:ring-brand-500"
                                                        >
                                                            <option value="">Pilih</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    )}
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full inline-flex items-center justify-center px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors disabled:opacity-50"
                                >
                                    {processing ? 'Menyimpan...' : 'Simpan Perubahan'}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {/* Direct Permissions */}
                <div className="lg:col-span-2 space-y-6">
                    <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden flex flex-col h-full">
                        <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50 flex items-center justify-between">
                            <div>
                                <h2 className="font-semibold text-slate-800 dark:text-white">Direct Permissions</h2>
                                <p className="text-xs text-slate-500">Izin tambahan di luar hak akses Role.</p>
                            </div>
                            <div className="flex gap-2">
                                <button 
                                    onClick={handleCheckAllPerm}
                                    type="button" 
                                    className="px-3 py-1.5 text-xs font-semibold bg-brand-50 text-brand-600 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 rounded-lg transition-colors"
                                >
                                    Pilih Semua
                                </button>
                                <button 
                                    onClick={handleUncheckAllPerm}
                                    type="button" 
                                    className="px-3 py-1.5 text-xs font-semibold bg-surface-100 text-surface-600 hover:bg-surface-200 dark:bg-surface-700 dark:text-surface-300 dark:hover:bg-surface-600 rounded-lg transition-colors"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                        <div className="p-6 flex-grow overflow-y-auto custom-scrollbar" style={{ maxHeight: 'calc(100vh - 250px)' }}>
                            <form onSubmit={submitPermissions} className="space-y-6">
                                {moduleGroups.map((group, index) => (
                                    <div key={index} className="rounded-xl border border-surface-200 dark:border-surface-700 overflow-hidden" style={{ borderLeftColor: group.color, borderLeftWidth: '4px' }}>
                                        <div className="px-4 py-3 bg-surface-50 dark:bg-surface-800/80 border-b border-surface-200 dark:border-surface-700 flex justify-between items-center" style={{ backgroundColor: `${group.color}10` }}>
                                            <h3 className="font-bold text-sm" style={{ color: group.color }}>{group.label}</h3>
                                            <button 
                                                type="button"
                                                onClick={() => toggleGroupPerms(group.modules)}
                                                className="text-xs px-2 py-1 bg-white dark:bg-surface-700 rounded shadow-sm hover:bg-surface-50 dark:hover:bg-surface-600 transition-colors font-medium text-slate-600 dark:text-slate-300 border border-surface-200 dark:border-surface-600"
                                            >
                                                Toggle All
                                            </button>
                                        </div>
                                        <div className="p-0 overflow-x-auto">
                                            <table className="w-full text-left text-sm whitespace-nowrap">
                                                <thead>
                                                    <tr className="bg-white dark:bg-surface-900/50 border-b border-surface-100 dark:border-surface-800 text-slate-500">
                                                        <th className="px-4 py-2 font-medium w-1/3">Modul</th>
                                                        {actions.map(act => <th key={act} className="px-2 py-2 font-medium text-center capitalize">{act}</th>)}
                                                    </tr>
                                                </thead>
                                                <tbody className="divide-y divide-surface-100 dark:divide-surface-800 bg-white dark:bg-surface-800/30">
                                                    {group.modules.map(mod => (
                                                        <tr key={mod} className="hover:bg-surface-50/50 dark:hover:bg-surface-700/30 transition-colors">
                                                            <td className="px-4 py-2.5 font-medium text-slate-700 dark:text-slate-300">
                                                                {mod.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                                            </td>
                                                            {actions.map(act => {
                                                                const permName = `${act}-${mod}`;
                                                                const permObj = permissions.find(p => p.name === permName);
                                                                return (
                                                                    <td key={permName} className="px-2 py-2.5 text-center">
                                                                        {permObj ? (
                                                                            <label className="inline-flex items-center cursor-pointer p-1">
                                                                                <input 
                                                                                    type="checkbox"
                                                                                    checked={permData.direct_permission.includes(permName)}
                                                                                    onChange={() => handlePermissionToggle(permName)}
                                                                                    className="rounded border-surface-300 text-brand-600 focus:ring-brand-500 w-4 h-4 cursor-pointer"
                                                                                />
                                                                            </label>
                                                                        ) : (
                                                                            <span className="text-slate-300 dark:text-slate-600">-</span>
                                                                        )}
                                                                    </td>
                                                                );
                                                            })}
                                                        </tr>
                                                    ))}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                ))}

                                {specificPermissions.length > 0 && (
                                    <div className="rounded-xl border border-danger-200 dark:border-danger-900 overflow-hidden" style={{ borderLeftColor: '#ef4444', borderLeftWidth: '4px' }}>
                                        <div className="px-4 py-3 bg-danger-50 dark:bg-danger-900/20 border-b border-danger-200 dark:border-danger-900">
                                            <h3 className="font-bold text-sm text-danger-600 dark:text-danger-400">Permission Khusus</h3>
                                        </div>
                                        <div className="p-4 bg-white dark:bg-surface-800/30">
                                            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                                {specificPermissions.map(perm => (
                                                    <label key={perm.id} className="flex items-center gap-2 cursor-pointer group">
                                                        <input 
                                                            type="checkbox"
                                                            checked={permData.direct_permission.includes(perm.name)}
                                                            onChange={() => handlePermissionToggle(perm.name)}
                                                            className="rounded border-surface-300 text-danger-600 focus:ring-danger-500 w-4 h-4"
                                                        />
                                                        <span className="text-sm text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">{perm.name}</span>
                                                    </label>
                                                ))}
                                            </div>
                                        </div>
                                    </div>
                                )}

                                <div className="pt-4 flex justify-end">
                                    <button
                                        type="submit"
                                        disabled={processingPerm}
                                        className="inline-flex items-center justify-center px-6 py-2.5 bg-slate-800 hover:bg-slate-900 dark:bg-brand-600 dark:hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors disabled:opacity-50 shadow-sm"
                                    >
                                        {processingPerm ? 'Menyimpan...' : 'Simpan Permissions'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
