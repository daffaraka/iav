import React, { useEffect } from "react";
import { X } from "lucide-react";
import { useForm } from "@inertiajs/react";

export default function KpiModal({ isOpen, onClose, editingKpi }) {
  const { data, setData, post, put, processing, errors, reset, clearErrors } = useForm({
    title: "",
    description: "",
    target_date: "",
    bobot_kpi: 100,
    type: "wig" // Ensure it saves as WIG
  });

  useEffect(() => {
    if (isOpen) {
      if (editingKpi) {
        setData({
          title: editingKpi.title || "",
          description: editingKpi.description || "",
          target_date: editingKpi.target_date ? editingKpi.target_date.substring(0, 10) : "",
          bobot_kpi: editingKpi.bobot || 100,
          type: "wig"
        });
      } else {
        reset();
      }
      clearErrors();
    }
  }, [isOpen, editingKpi]);

  if (!isOpen) return null;

  const handleSubmit = (e) => {
    e.preventDefault();
    if (editingKpi) {
      put(`/timeline-project/${editingKpi.id}`, {
        onSuccess: () => onClose(),
      });
    } else {
      post(`/timeline-project`, {
        onSuccess: () => onClose(),
      });
    }
  };

  return (
    <div className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div className="bg-white rounded-3xl w-full max-w-lg shadow-2xl border border-gray-100 overflow-hidden">
        <div className="flex justify-between items-center p-6 bg-gray-50 border-b border-gray-100">
          <h2 className="text-xl font-bold text-gray-800">
            {editingKpi ? "Edit KPI" : "Buat KPI Baru"}
          </h2>
          <button
            onClick={onClose}
            className="p-2 bg-gray-200 rounded-full text-gray-500 hover:text-gray-800 transition-all"
          >
            <X size={18} />
          </button>
        </div>

        <form onSubmit={handleSubmit} className="p-7 space-y-5">
          <div>
            <label className="block text-sm font-semibold text-gray-600 mb-2">
              Judul KPI <span className="text-red-400">*</span>
            </label>
            <input
              type="text"
              required
              value={data.title}
              onChange={(e) => setData("title", e.target.value)}
              className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all"
              placeholder="Contoh: Implementasi Website E-Commerce"
            />
            {errors.title && <p className="text-red-500 text-xs mt-1">{errors.title}</p>}
          </div>

          <div>
            <label className="block text-sm font-semibold text-gray-600 mb-2">
              Deskripsi Singkat
            </label>
            <textarea
              value={data.description}
              onChange={(e) => setData("description", e.target.value)}
              className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all min-h-[120px] resize-none"
              placeholder="Jelaskan tujuan dan ruang lingkup KPI ini..."
            />
            {errors.description && <p className="text-red-500 text-xs mt-1">{errors.description}</p>}
          </div>

          <div>
            <label className="block text-sm font-semibold text-gray-600 mb-2">
              Tanggal Target Pencapaian <span className="text-red-400">*</span>
            </label>
            <input
              type="date"
              required
              value={data.target_date}
              onChange={(e) => setData("target_date", e.target.value)}
              className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all"
            />
            {errors.target_date && <p className="text-red-500 text-xs mt-1">{errors.target_date}</p>}
          </div>

          <div>
            <label className="block text-sm font-semibold text-gray-600 mb-2">
              Bobot WIG (%) <span className="text-red-400">*</span>
            </label>
            <input
              type="number"
              step="any"
              min="0"
              required
              value={data.bobot_kpi}
              onChange={(e) => setData("bobot_kpi", e.target.value)}
              className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all"
              placeholder="Contoh: 100"
            />
            {errors.bobot_kpi && <p className="text-red-500 text-xs mt-1">{errors.bobot_kpi}</p>}
          </div>

          <div className="flex justify-end gap-3 pt-6 border-t border-gray-100">
            <button
              type="button"
              onClick={onClose}
              className="px-5 py-2.5 text-sm font-medium text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 hover:text-gray-800 rounded-xl transition-all"
            >
              Batal
            </button>
            <button
              type="submit"
              disabled={processing}
              className="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-indigo-700 hover:bg-indigo-700 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
            >
              {processing ? (
                <>
                  <div className="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin" />
                  <span>Menyimpan...</span>
                </>
              ) : (
                editingKpi ? "Simpan Perubahan" : "Buat KPI"
              )}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
