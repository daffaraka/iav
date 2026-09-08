import React, { useEffect } from "react";
import { X, ChevronDown } from "lucide-react";
import { useForm } from "@inertiajs/react";

export default function BoardModal({
  isOpen,
  onClose,
  editingBoard,
  kpis = [],
  kategoriPrograms = [],
  initialTargetKpiId = null,
}) {
  const { data, setData, post, put, processing, errors, reset, clearErrors } = useForm({
    title: "",
    description: "",
    boardType: "kpi",
    kpi_id: initialTargetKpiId || "",
    kategori_program_id: "",
    start_date: "",
    target_date: "",
    prioritas: "",
    bobot_board: "",
    kondisi_aktual: "",
    target_akhir_tahun: "",
    output_akhir: ""
  });

  useEffect(() => {
    if (isOpen) {
      if (editingBoard) {
        setData({
          title: editingBoard.title || "",
          description: editingBoard.description || "",
          boardType: editingBoard.boardable_type === 'App\\Models\\NewMigration\\Project' ? "kpi" : "non-kpi",
          kpi_id: editingBoard.boardable_type === 'App\\Models\\NewMigration\\Project' ? editingBoard.boardable_id : "",
          kategori_program_id: editingBoard.kategori_program_id || "",
          start_date: editingBoard.start_date ? editingBoard.start_date.substring(0, 10) : "",
          target_date: editingBoard.target_date ? editingBoard.target_date.substring(0, 10) : "",
          prioritas: editingBoard.prioritas || "",
          bobot_board: editingBoard.bobot_board || "",
          kondisi_aktual: editingBoard.kondisi_aktual || "",
          target_akhir_tahun: editingBoard.target_akhir_tahun || "",
          output_akhir: editingBoard.output_akhir || ""
        });
      } else {
        reset();
        setData("kpi_id", initialTargetKpiId || "");
      }
      clearErrors();
    }
  }, [isOpen, editingBoard, initialTargetKpiId]);

  if (!isOpen) return null;

  const handleSubmit = (e) => {
    e.preventDefault();
    if (editingBoard) {
      put(`/kanban/lead-measure/${editingBoard.id}`, {
        onSuccess: () => onClose(),
      });
    } else {
      post(`/kanban/lead-measure`, {
        onSuccess: () => onClose(),
      });
    }
  };

  return (
    <div className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div className="bg-white rounded-3xl w-full max-w-4xl shadow-2xl border border-gray-100 m-4 max-h-[90vh] flex flex-col">
        <div className="flex justify-between items-center p-6 bg-gray-50 border-b border-gray-100 shrink-0">
          <h2 className="text-xl font-bold text-gray-800">
            {editingBoard ? "Edit Program Kerja" : "Buat Program Kerja Baru"}
          </h2>
          <button onClick={onClose} className="p-2 bg-gray-200 rounded-full text-gray-500 hover:text-gray-800 transition-all">
            <X size={18} />
          </button>
        </div>

        <form onSubmit={handleSubmit} className="p-7 space-y-5 overflow-y-auto custom-scrollbar">
          {/* Type Switcher */}
          <div className="flex bg-gray-100 border border-gray-200 rounded-xl p-1">
            <button
              type="button"
              onClick={() => setData("boardType", "non-kpi")}
              className={`flex-1 py-2 text-sm font-semibold rounded-lg transition-all duration-200 ${
                data.boardType === "non-kpi"
                  ? "bg-white text-indigo-600 shadow-sm"
                  : "text-gray-500 hover:text-gray-800"
              }`}
            >
              Non Project
            </button>
            <button
              type="button"
              onClick={() => setData("boardType", "kpi")}
              className={`flex-1 py-2 text-sm font-semibold rounded-lg transition-all duration-200 ${
                data.boardType === "kpi"
                  ? "bg-white text-indigo-600 shadow-sm"
                  : "text-gray-500 hover:text-gray-800"
              }`}
            >
              Terikat Main Project
            </button>
          </div>

          {/* KPI Selection */}
          {data.boardType === "kpi" && (
            <div>
              <label className="block text-sm font-semibold text-gray-600 mb-2">
                Pilih Main Project <span className="text-red-400">*</span>
              </label>
              <select
                value={data.kpi_id}
                onChange={(e) => setData("kpi_id", e.target.value)}
                className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400"
                required
              >
                <option value="">-- Pilih Main Project --</option>
                {kpis.map(kpi => (
                  <option key={kpi.id} value={kpi.id}>{kpi.title}</option>
                ))}
              </select>
              {errors.kpi_id && <p className="text-red-500 text-xs mt-1">{errors.kpi_id}</p>}
            </div>
          )}

          {/* Kategori Program */}
          <div>
            <label className="block text-sm font-semibold text-gray-600 mb-2">Kategori Program</label>
            <select
              value={data.kategori_program_id}
              onChange={(e) => setData("kategori_program_id", e.target.value)}
              className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400"
            >
              <option value="">-- Tanpa Kategori --</option>
              {kategoriPrograms.map(cat => (
                <option key={cat.id} value={cat.id}>{cat.name}</option>
              ))}
            </select>
            {errors.kategori_program_id && <p className="text-red-500 text-xs mt-1">{errors.kategori_program_id}</p>}
          </div>

          {/* 2-Column Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="space-y-5">
              <div>
                <label className="block text-sm font-semibold text-gray-600 mb-2">
                  Judul Program Kerja <span className="text-red-400">*</span>
                </label>
                <input
                  type="text"
                  required
                  value={data.title}
                  onChange={(e) => setData("title", e.target.value)}
                  className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400"
                />
                {errors.title && <p className="text-red-500 text-xs mt-1">{errors.title}</p>}
              </div>

              <div>
                <label className="block text-sm font-semibold text-gray-600 mb-2">Tujuan Program</label>
                <textarea
                  value={data.description}
                  onChange={(e) => setData("description", e.target.value)}
                  className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 min-h-[100px] resize-none"
                />
              </div>

              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-semibold text-gray-600 mb-2">
                    Mulai <span className="text-red-400">*</span>
                  </label>
                  <input
                    type="date"
                    required
                    value={data.start_date}
                    onChange={(e) => setData("start_date", e.target.value)}
                    className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400"
                  />
                  {errors.start_date && <p className="text-red-500 text-xs mt-1">{errors.start_date}</p>}
                </div>
                <div>
                  <label className="block text-sm font-semibold text-gray-600 mb-2">
                    Target <span className="text-red-400">*</span>
                  </label>
                  <input
                    type="date"
                    required
                    value={data.target_date}
                    onChange={(e) => setData("target_date", e.target.value)}
                    className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400"
                  />
                  {errors.target_date && <p className="text-red-500 text-xs mt-1">{errors.target_date}</p>}
                </div>
              </div>

              <div>
                <label className="block text-sm font-semibold text-gray-600 mb-2">Prioritas</label>
                <div className="flex gap-2">
                  {["low", "medium", "high"].map((p) => (
                    <button
                      key={p}
                      type="button"
                      onClick={() => setData("prioritas", data.prioritas === p ? "" : p)}
                      className={`flex-1 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all ${
                        data.prioritas === p
                          ? p === "high"
                            ? "bg-red-50 text-red-600 border-2 border-red-200 shadow-sm"
                            : p === "medium"
                              ? "bg-indigo-50 text-indigo-600 border-2 border-indigo-200 shadow-sm"
                              : "bg-gray-100 text-gray-700 border-2 border-gray-300 shadow-sm"
                          : "bg-white text-gray-500 border-2 border-gray-200 hover:bg-gray-50"
                      }`}
                    >
                      {p === "high" ? "Tinggi" : p === "medium" ? "Sedang" : "Rendah"}
                    </button>
                  ))}
                </div>
              </div>

              {data.boardType === "kpi" && (
                <div>
                  <label className="block text-sm font-semibold text-gray-600 mb-2">Bobot Lead Measure</label>
                  <input
                    type="number"
                    step="any"
                    min="0"
                    value={data.bobot_board}
                    onChange={(e) => setData("bobot_board", e.target.value)}
                    className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400"
                  />
                </div>
              )}
            </div>

            <div className="space-y-5">
              <div>
                <label className="block text-sm font-semibold text-gray-600 mb-2">Kondisi Aktual</label>
                <textarea
                  value={data.kondisi_aktual}
                  onChange={(e) => setData("kondisi_aktual", e.target.value)}
                  className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 min-h-[100px] resize-none"
                />
              </div>

              <div>
                <label className="block text-sm font-semibold text-gray-600 mb-2">Target Akhir Tahun</label>
                <textarea
                  value={data.target_akhir_tahun}
                  onChange={(e) => setData("target_akhir_tahun", e.target.value)}
                  className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 min-h-[100px] resize-none"
                />
              </div>

              <div>
                <label className="block text-sm font-semibold text-gray-600 mb-2">Output Akhir</label>
                <textarea
                  value={data.output_akhir}
                  onChange={(e) => setData("output_akhir", e.target.value)}
                  className="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 min-h-[100px] resize-none"
                />
              </div>
            </div>
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
              disabled={!data.title.trim() || processing}
              className={`px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-indigo-700 hover:bg-indigo-700 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 ${
                !data.title.trim() || processing ? "opacity-50 cursor-not-allowed" : ""
              }`}
            >
              {processing ? (
                <>
                  <div className="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin" />
                  <span>Menyimpan...</span>
                </>
              ) : (
                editingBoard ? "Simpan Perubahan" : "Buat Program Kerja"
              )}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
