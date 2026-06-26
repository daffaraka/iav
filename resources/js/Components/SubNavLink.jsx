import React from 'react';

const SubNavLink = ({ href = "#", children }) => (
    <a href={href} className="text-slate-300 hover:text-white transition-colors relative group">
        {children}
        <span className="absolute -bottom-1.5 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
    </a>
);

export default SubNavLink;
