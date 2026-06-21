import React, { useState, useMemo } from 'react';
import {
  useReactTable,
  getCoreRowModel,
  getPaginationRowModel,
  getFilteredRowModel,
  getSortedRowModel,
  flexRender,
} from '@tanstack/react-table';
import Skeleton from './Skeleton';

export default function DataTable({ columns, data, searchable = true, loading = false }) {
  const [globalFilter, setGlobalFilter] = useState('');
  const [pagination, setPagination] = useState({
    pageIndex: 0,
    pageSize: 10,
  });

  // Automatically add an index column at the beginning
  const tableColumns = React.useMemo(() => {
    return [
      {
        id: 'index',
        header: '#',
        cell: (info) => {
          return info.row.index + 1;
        },
        // We can't easily do global pagination index without accessing table state,
        // but TanStack exposes it via `info.table.getState().pagination`.
      },
      ...columns,
    ];
  }, [columns]);

  // Fix index based on pagination
  const modifiedColumns = tableColumns.map(col => {
      if(col.id === 'index'){
          return {
              ...col,
              cell: (info) => {
                  const paginationState = info.table.getState().pagination;
                  return (paginationState.pageIndex * paginationState.pageSize) + info.row.index + 1;
              }
          }
      }
      return col;
  });

  const table = useReactTable({
    data,
    columns: modifiedColumns,
    state: {
      globalFilter,
      pagination,
    },
    onGlobalFilterChange: setGlobalFilter,
    onPaginationChange: setPagination,
    getCoreRowModel: getCoreRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    autoResetPageIndex: false,
  });

  return (
    <div className="w-full flex flex-col space-y-4">
      {/* Top Controls: Search & Page Size */}
      <div className="flex flex-col sm:flex-row justify-between items-center gap-4">
        <div className="flex items-center gap-2">
          <span className="text-sm text-slate-600 dark:text-slate-400">Tampilkan</span>
          <select
            value={table.getState().pagination.pageSize}
            onChange={(e) => {
              table.setPageSize(Number(e.target.value));
            }}
            className="border-surface-200 dark:border-surface-700 bg-white dark:bg-surface-900 text-slate-700 dark:text-slate-300 rounded-lg text-sm focus:ring-brand-500 focus:border-brand-500"
          >
            {[10, 20, 50, 100].map((pageSize) => (
              <option key={pageSize} value={pageSize}>
                {pageSize}
              </option>
            ))}
          </select>
          <span className="text-sm text-slate-600 dark:text-slate-400">baris</span>
        </div>

        {searchable && (
          <div className="relative w-full sm:w-64">
            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i className="ph ph-magnifying-glass text-slate-400"></i>
            </div>
            <input
              type="text"
              value={globalFilter ?? ''}
              onChange={(e) => setGlobalFilter(e.target.value)}
              placeholder="Cari data..."
              className="pl-10 w-full border-surface-200 dark:border-surface-700 bg-white dark:bg-surface-900 text-slate-700 dark:text-slate-300 rounded-xl text-sm focus:ring-brand-500 focus:border-brand-500 transition-shadow shadow-sm"
            />
          </div>
        )}
      </div>

      {/* Table Content */}
      <div className="overflow-x-auto custom-scrollbar rounded-xl border border-surface-200 dark:border-surface-700 shadow-sm bg-white dark:bg-surface-800">
        {loading ? (
          <div className="p-4">
            <Skeleton.Table rows={5} cols={columns.length + 1} />
          </div>
        ) : (
          <table className="w-full text-left text-sm whitespace-nowrap">
            <thead className="bg-surface-50 dark:bg-surface-900/50 border-b border-surface-200 dark:border-surface-700 text-slate-600 dark:text-slate-300">
              {table.getHeaderGroups().map((headerGroup) => (
                <tr key={headerGroup.id}>
                  {headerGroup.headers.map((header) => (
                    <th
                      key={header.id}
                      onClick={header.column.getToggleSortingHandler()}
                      className={`px-6 py-4 font-semibold ${
                        header.column.getCanSort() ? 'cursor-pointer select-none hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors' : ''
                      }`}
                    >
                      <div className="flex items-center gap-2">
                        {flexRender(header.column.columnDef.header, header.getContext())}
                        {{
                          asc: <i className="ph ph-caret-up text-brand-500"></i>,
                          desc: <i className="ph ph-caret-down text-brand-500"></i>,
                        }[header.column.getIsSorted()] ?? null}
                      </div>
                    </th>
                  ))}
                </tr>
              ))}
            </thead>
            <tbody className="divide-y divide-surface-100 dark:divide-surface-700">
              {table.getRowModel().rows.length > 0 ? (
                table.getRowModel().rows.map((row) => (
                  <tr
                    key={row.id}
                    className="hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors"
                  >
                    {row.getVisibleCells().map((cell) => (
                      <td key={cell.id} className="px-6 py-4 text-slate-700 dark:text-slate-300">
                        {flexRender(cell.column.columnDef.cell, cell.getContext())}
                      </td>
                    ))}
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan={columns.length + 1} className="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                    <div className="flex flex-col items-center justify-center">
                      <i className="ph ph-folder-open text-4xl mb-2 text-slate-300 dark:text-slate-600"></i>
                      <p>Data tidak ditemukan</p>
                    </div>
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        )}
      </div>

      {/* Bottom Controls: Pagination */}
      <div className="flex flex-col sm:flex-row items-center justify-between gap-4 mt-2">
        <div className="text-sm text-slate-600 dark:text-slate-400">
          Menampilkan baris <span className="font-semibold text-slate-800 dark:text-slate-200">{table.getState().pagination.pageIndex * table.getState().pagination.pageSize + 1}</span> hingga <span className="font-semibold text-slate-800 dark:text-slate-200">{Math.min((table.getState().pagination.pageIndex + 1) * table.getState().pagination.pageSize, table.getFilteredRowModel().rows.length)}</span> dari <span className="font-semibold text-slate-800 dark:text-slate-200">{table.getFilteredRowModel().rows.length}</span> data
        </div>
        
        <div className="flex items-center gap-1">
          <button
            onClick={() => table.setPageIndex(0)}
            disabled={!table.getCanPreviousPage()}
            className="p-2 rounded-lg border border-surface-200 dark:border-surface-700 text-slate-600 dark:text-slate-400 hover:bg-surface-50 dark:hover:bg-surface-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            title="Halaman Pertama"
          >
            <i className="ph ph-caret-double-left"></i>
          </button>
          <button
            onClick={() => table.previousPage()}
            disabled={!table.getCanPreviousPage()}
            className="p-2 rounded-lg border border-surface-200 dark:border-surface-700 text-slate-600 dark:text-slate-400 hover:bg-surface-50 dark:hover:bg-surface-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            title="Halaman Sebelumnya"
          >
            <i className="ph ph-caret-left"></i>
          </button>
          
          <span className="flex items-center gap-1 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300">
            <div>Halaman</div>
            <strong className="text-brand-600 dark:text-brand-400">
              {table.getState().pagination.pageIndex + 1}
            </strong>
            <div>dari</div>
            <strong>{table.getPageCount()}</strong>
          </span>

          <button
            onClick={() => table.nextPage()}
            disabled={!table.getCanNextPage()}
            className="p-2 rounded-lg border border-surface-200 dark:border-surface-700 text-slate-600 dark:text-slate-400 hover:bg-surface-50 dark:hover:bg-surface-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            title="Halaman Selanjutnya"
          >
            <i className="ph ph-caret-right"></i>
          </button>
          <button
            onClick={() => table.setPageIndex(table.getPageCount() - 1)}
            disabled={!table.getCanNextPage()}
            className="p-2 rounded-lg border border-surface-200 dark:border-surface-700 text-slate-600 dark:text-slate-400 hover:bg-surface-50 dark:hover:bg-surface-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            title="Halaman Terakhir"
          >
            <i className="ph ph-caret-double-right"></i>
          </button>
        </div>
      </div>
    </div>
  );
}
