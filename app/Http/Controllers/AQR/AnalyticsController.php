<?php

namespace App\Http\Controllers\AQR;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function index(Request $request)
    {
        $period = $request->get('period', 'month');
        $lokasi = $request->get('lokasi');

        $query = Tiket::query();

        switch ($period) {
            case 'week':
                $query->where('created_at', '>=', now()->subWeek());
                break;
            case 'month':
                $query->where('created_at', '>=', now()->subMonth());
                break;
            case 'year':
                $query->where('created_at', '>=', now()->subYear());
                break;
        }

        if ($lokasi) {
            $query->where('lokasi_sekolah', $lokasi);
        }

        $tickets = $query->get();

        // Kategorisasi otomatis
        $kategoriStats = $tickets->groupBy('ai_kategori')->map->count();

        // Trend by status
        $statusTrend = $tickets->groupBy('status')->map->count();

        // Sentiment analysis
        $sentimentStats = $tickets->groupBy('ai_sentiment')->map->count();

        // Priority distribution
        $priorityStats = $tickets->groupBy('ai_prioritas')->map->count();

        // Trend per lokasi
        $lokasiTrend = $tickets->groupBy('lokasi_sekolah')->map->count();

        // Generate AI summary
        $aiSummary = null;
        if ($tickets->count() > 0) {
            $aiSummary = $this->gemini->generateTrendSummary(
                $tickets->toArray(),
                $this->getPeriodLabel($period)
            );
        }

        return view('dashboard.aqr-dashboard.analytics', compact(
            'tickets',
            'kategoriStats',
            'statusTrend',
            'sentimentStats',
            'priorityStats',
            'lokasiTrend',
            'aiSummary',
            'period',
            'lokasi'
        ));
    }

    public function analyzeTicket($id)
    {
        $tiket = Tiket::findOrFail($id);

        if ($tiket->ai_analyzed_at) {
            return redirect()->back()->with('info', 'Tiket sudah dianalisis sebelumnya');
        }

        $analysis = $this->gemini->analyzeTicket(
            $tiket->judul_kendala,
            $tiket->detail_kendala
        );


        // dd($analysis);

        if (!$analysis || !is_array($analysis)) {
            throw new \Exception('AI gagal decode JSON: ' . json_encode($analysis));
        }

        $tiket->update([
            'ai_kategori' => $analysis['kategori'] ?? null,
            'ai_sub_kategori' => $analysis['sub_kategori'] ?? null,
            'ai_prioritas' => $analysis['prioritas'] ?? null,
            'ai_sentiment' => $analysis['sentiment'] ?? null,
            'ai_ringkasan' => $analysis['ringkasan'] ?? null,
            'ai_analyzed_at' => now()
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil dianalisis oleh AI');
    }

    public function bulkAnalyze(Request $request)
    {
        $limit = $request->get('limit', 10);

        $tickets = Tiket::whereNull('ai_analyzed_at')
            ->latest()
            ->limit($limit)
            ->get();

        $analyzed = 0;
        foreach ($tickets as $tiket) {
            $analysis = $this->gemini->analyzeTicket(
                $tiket->judul_kendala,
                $tiket->detail_kendala
            );

            if ($analysis) {
                $tiket->update([
                    'ai_kategori' => $analysis['kategori'] ?? null,
                    'ai_sub_kategori' => $analysis['sub_kategori'] ?? null,
                    'ai_prioritas' => $analysis['prioritas'] ?? null,
                    'ai_sentiment' => $analysis['sentiment'] ?? null,
                    'ai_ringkasan' => $analysis['ringkasan'] ?? null,
                    'ai_analyzed_at' => now()
                ]);
                $analyzed++;
            }

            sleep(1); // Rate limiting
        }

        return redirect()->back()->with('success', "Berhasil menganalisis {$analyzed} tiket");
    }

    private function getPeriodLabel($period)
    {
        return match($period) {
            'week' => '7 hari terakhir',
            'month' => '30 hari terakhir',
            'year' => '1 tahun terakhir',
            default => '30 hari terakhir'
        };
    }
}
