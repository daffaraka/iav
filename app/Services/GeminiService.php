<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    private $apiKey;
    private $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key') ?? env('GEMINI_API_KEY');

        if (!$this->apiKey) {
            throw new \Exception('GEMINI_API_KEY tidak ditemukan');
        }
    }

    public function analyzeTicket(string $judul, string $detail)
    {
        $judul = html_entity_decode($judul, ENT_QUOTES, 'UTF-8');
        $detail = html_entity_decode($detail, ENT_QUOTES, 'UTF-8');

        $prompt = "Analisis tiket kritik dan saran berikut dan berikan output dalam format JSON:

Judul: {$judul}
Detail: {$detail}

Berikan analisis dalam format JSON dengan struktur:
{
  \"kategori\": \"pilih salah satu: Fasilitas, Akademik, Administrasi, Kebersihan, Keamanan, Pelayanan, Teknologi, Lainnya\",
  \"sub_kategori\": \"sub kategori lebih spesifik\",
  \"prioritas\": \"pilih: Rendah, Sedang, Tinggi, Urgent\",
  \"sentiment\": \"pilih: Positif, Netral, Negatif\",
  \"ringkasan\": \"ringkasan singkat 1-2 kalimat\"
}

Hanya berikan JSON tanpa penjelasan tambahan.";

        $response = Http::timeout(30)
            ->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.3,
                    'maxOutputTokens' => 1000
                ]
            ]);

        $result = $response->json();

        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            throw new \Exception('Invalid response structure: ' . json_encode($result));
        }

        $text = $result['candidates'][0]['content']['parts'][0]['text'];

        $text = trim($text);
        $text = preg_replace('/```json\n?/', '', $text);
        $text = preg_replace('/```\n?/', '', $text);
        $text = trim($text);

        $decoded = json_decode($text, true);

        if (!$decoded) {
            throw new \Exception('JSON decode failed. Raw: ' . $text);
        }

        return $decoded;
    }

    public function generateTrendSummary(array $tickets, string $period)
    {
        $ticketSummary = collect($tickets)->map(function($ticket) {
            return "- {$ticket['judul_kendala']} (Status: {$ticket['status']}, Lokasi: {$ticket['lokasi_sekolah']})";
        })->take(20)->implode("\n");

        $prompt = "Analisis trend tiket AQR periode {$period}:

{$ticketSummary}

Berikan analisis dalam format JSON:
{
  \"trend_utama\": \"trend atau pola yang terlihat\",
  \"masalah_terbanyak\": \"masalah yang paling sering muncul\",
  \"rekomendasi\": [\"rekomendasi 1\", \"rekomendasi 2\", \"rekomendasi 3\"],
  \"insight\": \"insight penting untuk management\"
}

Hanya berikan JSON tanpa penjelasan tambahan.";

        $response = Http::timeout(30)
            ->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.5,
                    'maxOutputTokens' => 800
                ]
            ]);

        $result = $response->json();
        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        $text = trim($text);
        $text = preg_replace('/```json\n?/', '', $text);
        $text = preg_replace('/```\n?/', '', $text);

        return json_decode($text, true);
    }
}
