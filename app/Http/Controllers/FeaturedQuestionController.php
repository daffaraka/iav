<?php

namespace App\Http\Controllers;

use App\Models\FeaturedQuestion;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class FeaturedQuestionController extends Controller
{
    /**
     * Tampilkan daftar Featured Question.
     */
    public function index()
    {
        $featuredQuestions = FeaturedQuestion::with('createdBy')
            ->orderBy('order', 'asc')
            ->get();

        $title = 'Featured Question';

        return view('dashboard.featured-question.index', compact('featuredQuestions', 'title'));
    }

    /**
     * Form tambah Featured Question.
     */
    public function create()
    {
        $title = 'Tambah Featured Question';

        return view('dashboard.featured-question.create', compact('title'));
    }

    /**
     * Simpan Featured Question baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'jawaban' => 'required',
            'kategori' => 'required',
        ]);

        FeaturedQuestion::create([
            'judul' => $request->judul,
            'jawaban' => $request->jawaban,
            'kategori' => $request->kategori,
            'tiket_id' => $request->tiket_id,
            'is_pinned' => $request->is_pinned ?? false,
            'is_published' => $request->is_published ?? false,
            'order' => $request->order ?? 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('featured-question.index')->with('success', 'Featured Question berhasil ditambahkan.');
    }

    /**
     * Form edit Featured Question.
     */
    public function edit($id)
    {
        $fq = FeaturedQuestion::findOrFail($id);
        $title = 'Edit Featured Question';

        return view('dashboard.featured-question.edit', compact('fq', 'title'));
    }

    /**
     * Update Featured Question.
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'jawaban' => 'required',
            'kategori' => 'required',
        ]);

        $fq = FeaturedQuestion::findOrFail($id);
        $fq->update([
            'judul' => $request->judul,
            'jawaban' => $request->jawaban,
            'kategori' => $request->kategori,
            'tiket_id' => $request->tiket_id,
            'is_pinned' => $request->is_pinned ?? false,
            'is_published' => $request->is_published ?? false,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('featured-question.index')->with('success', 'Featured Question berhasil diperbarui.');
    }

    /**
     * Hapus Featured Question.
     */
    public function destroy($id)
    {
        $fq = FeaturedQuestion::findOrFail($id);
        $fq->delete();

        return redirect()->route('featured-question.index')->with('success', 'Featured Question berhasil dihapus.');
    }

    /**
     * Promote tiket yang sudah selesai menjadi Featured Question.
     */
    public function promoteFromTiket($tiketId)
    {
        $tiket = Tiket::where('id', $tiketId)
            ->where('status', 'Selesai')
            ->firstOrFail();

        $fq = FeaturedQuestion::create([
            'judul' => $tiket->judul_kendala,
            'jawaban' => '',
            'kategori' => $tiket->masalah_dept ?? '',
            'tiket_id' => $tiket->id,
            'is_published' => false,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('featured-question.edit', $fq->id)->with('success', 'Tiket berhasil dipromosikan. Silakan lengkapi jawaban.');
    }
}
