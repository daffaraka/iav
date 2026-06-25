import React from 'react';

export const JabatanBadge = ({ jabatan }) => {
    if (!jabatan) return <span>-</span>;
    const lowerVal = jabatan.toLowerCase();
    let colorClass = 'bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300';
    if (lowerVal.includes('kepala sekolah')) colorClass = 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400';
    else if (lowerVal.includes('wakil')) colorClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400';
    else if (lowerVal.includes('guru')) colorClass = 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400';
    else if (lowerVal.includes('admin')) colorClass = 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400';
    
    return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-medium ${colorClass}`}>{jabatan}</span>;
};

export const DepartemenBadge = ({ departemen, jabatan }) => {
    if (!departemen) return <span>-</span>;
    const jabatanVal = (jabatan || '').toLowerCase();
    let colorClass = 'border-surface-300 text-surface-700 dark:border-surface-500/40 dark:text-surface-300';
    if (jabatanVal.includes('kepala sekolah')) colorClass = 'border-blue-400 text-blue-700 dark:border-blue-500/40 dark:text-blue-400';
    else if (jabatanVal.includes('wakil')) colorClass = 'border-emerald-400 text-emerald-700 dark:border-emerald-500/40 dark:text-emerald-400';
    else if (jabatanVal.includes('guru')) colorClass = 'border-cyan-400 text-cyan-700 dark:border-cyan-500/40 dark:text-cyan-400';
    else if (jabatanVal.includes('admin')) colorClass = 'border-red-400 text-red-700 dark:border-red-500/40 dark:text-red-400';
    
    return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-bold border bg-transparent ${colorClass}`}>{departemen}</span>;
};

export const UnitBadge = ({ unit }) => {
    if (!unit) return <span>-</span>;
    const lowerVal = typeof unit === 'string' ? unit.toLowerCase() : String(unit).toLowerCase();
    let colorClass = 'bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300';
    if(lowerVal.includes('jagakarsa')) colorClass = 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400';
    if(lowerVal.includes('pamulang')) colorClass = 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400';
    if(lowerVal.includes('cinere')) colorClass = 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400';
    if(lowerVal.includes('bps')) colorClass = 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400';
    return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-medium ${colorClass}`}>{unit}</span>;
};

export const JenjangBadge = ({ jenjang }) => {
    if (!jenjang) return <span>-</span>;
    const val = typeof jenjang === 'string' ? jenjang.toUpperCase() : String(jenjang).toUpperCase();
    let colorClass = 'border-indigo-200 bg-indigo-50 text-indigo-700 dark:border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-400';
    if(val == 'TK' || val == 'KB') colorClass = 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-400';
    if(val == 'SD') colorClass = 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400';
    if(val == 'SMP') colorClass = 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400';
    if(val == 'SMA') colorClass = 'border-red-200 bg-red-50 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400';
    return <span className={`inline-flex px-2 py-0.5 rounded text-xs font-medium border ${colorClass}`}>{jenjang}</span>;
};

export const RoleBadge = ({ roles }) => {
    if (!roles || !Array.isArray(roles) || roles.length === 0) return <span>-</span>;
    
    return (
        <div className="flex flex-wrap gap-1">
            {roles.map(role => {
                let colorClass = 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400';
                if(role.name === 'kepala-psikolog' || role.name === 'super-admin') colorClass = 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400';
                if(role.name === 'psikolog' || role.name === 'admin') colorClass = 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400';
                if(role.name === 'kepala-tata-usaha' || role.name === 'kepala-sekolah') colorClass = 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400';
                if(role.name === 'guru' || role.name === 'wali-kelas') colorClass = 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400';
                
                return (
                    <span key={role.id || role.name || Math.random()} className={`inline-flex px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wider ${colorClass}`}>
                        {role.name}
                    </span>
                );
            })}
        </div>
    );
};
