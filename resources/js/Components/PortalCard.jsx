import React from 'react';
import { Link } from '@inertiajs/react';

const PortalCard = ({ href, image, label, labelColorClass, title, titleHoverClass, description }) => {
    const isInternal = href.startsWith('/');
    const content = (
        <>
            <div className="h-48 sm:h-56 overflow-hidden relative">
                <img src={image} alt={title} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                <div className="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            <div className="p-6 lg:p-8 flex-1 flex flex-col bg-slate-900 border-t border-slate-700">
                <span className={`text-[11px] font-bold ${labelColorClass} mb-3 uppercase tracking-widest`}>{label}</span>
                <h3 className={`text-xl font-bold text-white mb-3 ${titleHoverClass} transition-colors`}>{title}</h3>
                <p className="text-slate-300 text-sm leading-relaxed mb-0">{description}</p>
            </div>
        </>
    );
    const className = "rounded-[2rem] overflow-hidden shadow-2xl shadow-slate-400/40 dark:shadow-black/50 hover:shadow-blue-900/30 hover:-translate-y-2 transition-all duration-300 flex flex-col group border-[3px] border-slate-300 dark:border-slate-600";
    
    if (isInternal) {
        return <Link href={href} className={className}>{content}</Link>;
    }
    return <a href={href} target="_blank" rel="noreferrer" className={className}>{content}</a>;
};

export default PortalCard;
