import React from 'react';
import { Target, Briefcase, Filter, ChevronDown, Search, X } from 'lucide-react';

export default function DashboardFilter({
  activeTab,
  setActiveTab,
  filterDepartment,
  setFilterDepartment,
  isDeptDropdownOpen,
  setIsDeptDropdownOpen,
  searchKpi,
  setSearchKpi,
  departments = [],
}) {
  return (
    <>
      <div className="flex p-1.5 bg-gray-100 border border-gray-200 rounded-xl mb-8 w-fit shadow-inner mx-auto sm:mx-0">
        <button
          className={`py-2.5 px-6 sm:px-10 text-sm sm:text-base font-bold transition-all duration-300 rounded-lg flex items-center gap-2 ${
            activeTab === 'wig'
              ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5 scale-100'
              : 'text-gray-500 hover:text-gray-900 hover:bg-gray-200/60 scale-95 opacity-80 hover:opacity-100'
          }`}
          onClick={() => setActiveTab('wig')}
        >
          <Target
            size={18}
            className={activeTab === 'wig' ? 'text-indigo-500' : 'opacity-70'}
          />
          WIG (Main Project)
        </button>
        <button
          className={`py-2.5 px-6 sm:px-10 text-sm sm:text-base font-bold transition-all duration-300 rounded-lg flex items-center gap-2 ${
            activeTab === 'program_kerja'
              ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5 scale-100'
              : 'text-gray-500 hover:text-gray-900 hover:bg-gray-200/60 scale-95 opacity-80 hover:opacity-100'
          }`}
          onClick={() => setActiveTab('program_kerja')}
        >
          <Briefcase
            size={18}
            className={
              activeTab === 'program_kerja' ? 'text-indigo-500' : 'opacity-70'
            }
          />
          Program Kerja
        </button>
      </div>

      {activeTab === 'wig' && (
        <div className="flex items-center gap-3 mb-6">
          <div className="relative">
            <button
              onClick={() => setIsDeptDropdownOpen(!isDeptDropdownOpen)}
              className={`flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium border transition-all shadow-sm ${
                filterDepartment !== 'all'
                  ? 'bg-indigo-50 border-indigo-300 text-indigo-600'
                  : 'bg-white border-gray-200 text-gray-500 hover:text-gray-900 hover:bg-gray-50'
              }`}
            >
              <Filter size={16} />
              <span>
                {filterDepartment === 'all'
                  ? 'Semua Departemen'
                  : departments.find((d) => String(d.id) === String(filterDepartment))?.nama_departement || 'Departemen'}
              </span>
              <ChevronDown
                size={14}
                className={`transition-transform ${isDeptDropdownOpen ? 'rotate-180' : ''}`}
              />
            </button>

            {isDeptDropdownOpen && (
              <>
                <div
                  className="fixed inset-0 z-40"
                  onClick={() => setIsDeptDropdownOpen(false)}
                />
                <div className="absolute left-0 mt-2 w-64 bg-white border border-gray-200 rounded-xl shadow-xl z-50 py-1 max-h-72 overflow-y-auto">
                  <button
                    onClick={() => {
                      setFilterDepartment('all');
                      setIsDeptDropdownOpen(false);
                    }}
                    className={`w-full text-left px-4 py-2.5 text-sm transition-colors ${
                      filterDepartment === 'all'
                        ? 'bg-indigo-50 text-indigo-600 font-medium'
                        : 'text-gray-700 hover:bg-gray-50'
                    }`}
                  >
                    Semua Departemen
                  </button>
                  {departments.map((dept) => (
                    <button
                      key={dept.id}
                      onClick={() => {
                        setFilterDepartment(String(dept.id));
                        setIsDeptDropdownOpen(false);
                      }}
                      className={`w-full text-left px-4 py-2.5 text-sm transition-colors border-t border-gray-100 ${
                        String(filterDepartment) === String(dept.id)
                          ? 'bg-indigo-50 text-indigo-600 font-medium'
                          : 'text-gray-700 hover:bg-gray-50'
                      }`}
                    >
                      {dept.nama_departement}
                    </button>
                  ))}
                </div>
              </>
            )}
          </div>
          {filterDepartment !== 'all' && (
            <button
              onClick={() => setFilterDepartment('all')}
              className="text-xs text-gray-500 hover:text-red-500 transition-colors"
            >
              Reset
            </button>
          )}

          <div className="relative flex-1 max-w-sm ml-auto">
            <Search
              className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
              size={16}
            />
            <input
              type="text"
              placeholder="Cari project, board..."
              value={searchKpi}
              onChange={(e) => setSearchKpi(e.target.value)}
              className="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-400 transition-all shadow-sm"
            />
            {searchKpi && (
              <button
                onClick={() => setSearchKpi('')}
                className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-800 transition-colors"
              >
                <X size={14} />
              </button>
            )}
          </div>
        </div>
      )}
    </>
  );
}
