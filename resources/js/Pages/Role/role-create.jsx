import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout';

export default function RoleCreate({ title, permissions }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        permission: []
    });

    const moduleGroups = [
        { label: 'Dashboard', color: '#696cff', modules: ['dashboard'] },
        { label: 'Sekolah & Prestasi', color: '#28c76f', modules: ['sekolah', 'data-prestasi'] },
        { label: 'Lowongan', color: '#ff6f61', modules: ['lowongan-pekerjaan', 'lowongan-apply', 'lowongan-progress'] },
        { label: 'Departemen & SDM', color: '#ff9f43', modules: ['departement', 'wig', 'lead-measure', 'task-process', 'wig-progress'] },
        { label: 'AQR (Aduan & Tiket)', color: '#00cfe8', modules: ['aqr-dashboard', 'tiket', 'aduan', 'progres-tiket', 'rating-tiket'] },
        { label: 'User Management', color: '#7367f0', modules: ['user'] },
    ];

    const actions = ['view', 'create', 'edit', 'delete'];
    
    const moduleBasedNames = [];
    moduleGroups.forEach(g => {
        g.modules.forEach(m => {
            actions.forEach(a => moduleBasedNames.push(`${a}-${m}`));
        });
    });
    
    // permissions is an array of objects: {id, name, guard_name, ...}
    const specificPermissions = permissions.filter(p => !moduleBasedNames.includes(p.name));

    const submit = (e) => {
        e.preventDefault();
        post('/role');
    };

    const handlePermissionToggle = (permName) => {
        const perms = [...data.permission];
        if (perms.includes(permName)) {
            setData('permission', perms.filter(p => p !== permName));
        } else {
            setData('permission', [...perms, permName]);
        }
    };

    const handleCheckAll = () => {
        setData('permission', permissions.map(p => p.name));
    };

    const handleUncheckAll = () => {
        setData('permission', []);
    };

    const toggleGroupPerms = (modules) => {
        const groupPerms = [];
        modules.forEach(mod => {
            actions.forEach(act => {
                groupPerms.push(`${act}-${mod}`);
            });
        });

        const currentPerms = [...data.permission];
        const allGroupChecked = groupPerms.every(p => currentPerms.includes(p));

        if (allGroupChecked) {
            setData('permission', currentPerms.filter(p => !groupPerms.includes(p)));
        } else {
            const newPerms = new Set([...currentPerms, ...groupPerms]);
            setData('permission', Array.from(newPerms));
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title={title || "Tambah Role"} />

            <div className="mb-6 flex items-center justify-between">
                <div>
                    <h1 className="text-2xl font-bold text-slate-800 dark:text-white">{title || "Tambah Role"}</h1>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Buat role baru beserta hak aksesnya</p>
                </div>
                <Link 
                    href="/role" 
                    className="inline-flex items-center justify-center px-4 py-2 bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition-colors"
                >
                    <i className="ph ph-arrow-left mr-2"></i>
                    Kembali
                </Link>
            </div>

            <form onSubmit={submit}>
                <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    {/* Left Column: Role Name */}
                    <div className="lg:col-span-1">
                        <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft p-6 sticky top-6">
                            <h2 className="text-lg font-bold text-slate-800 dark:text-white mb-4">Informasi Role</h2>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                    Nama Role <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className={`w-full px-4 py-2.5 rounded-xl border ${errors.name ? 'border-red-500 focus:ring-red-500' : 'border-surface-200 dark:border-surface-600 focus:ring-brand-500'} bg-white dark:bg-surface-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm`}
                                    placeholder="Contoh: admin-keuangan"
                                    required
                                />
                                {errors.name && <p className="mt-1 text-sm text-red-500">{errors.name}</p>}
                                <p className="mt-2 text-xs text-slate-500">
                                    Gunakan huruf kecil dan pisahkan dengan strip (-) untuk nama role.
                                </p>
                            </div>

                            <div className="mt-8 pt-6 border-t border-surface-100 dark:border-surface-700">
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full inline-flex items-center justify-center px-4 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors disabled:opacity-50 shadow-md shadow-brand-500/20"
                                >
                                    <i className="ph ph-save text-lg mr-2"></i>
                                    {processing ? 'Menyimpan...' : 'Simpan Role'}
                                </button>
                            </div>
                        </div>
                    </div>

                    {/* Right Column: Permissions */}
                    <div className="lg:col-span-3">
                        <div className="bg-white dark:bg-surface-800 rounded-2xl border border-surface-100 dark:border-surface-700 shadow-soft overflow-hidden">
                            <div className="px-6 py-4 border-b border-surface-100 dark:border-surface-700 bg-surface-50/50 dark:bg-surface-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <h2 className="font-semibold text-slate-800 dark:text-white">Hak Akses (Permissions)</h2>
                                    <p className="text-xs text-slate-500">Pilih modul apa saja yang dapat diakses oleh role ini.</p>
                                </div>
                                <div className="flex gap-2">
                                    <button 
                                        type="button" 
                                        onClick={handleCheckAll}
                                        className="px-3 py-1.5 text-xs font-semibold bg-brand-50 text-brand-600 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 rounded-lg transition-colors"
                                    >
                                        Pilih Semua
                                    </button>
                                    <button 
                                        type="button" 
                                        onClick={handleUncheckAll}
                                        className="px-3 py-1.5 text-xs font-semibold bg-surface-100 text-surface-600 hover:bg-surface-200 dark:bg-surface-700 dark:text-surface-300 dark:hover:bg-surface-600 rounded-lg transition-colors"
                                    >
                                        Reset
                                    </button>
                                </div>
                            </div>
                            <div className="p-6 space-y-6">
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
                                                                                    checked={data.permission.includes(permName)}
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
                                                            checked={data.permission.includes(perm.name)}
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
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </AuthenticatedLayout>
    );
}
