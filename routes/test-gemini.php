<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/test-gemini', function() {
    $apiKey = config('services.gemini.api_key');
    
    if (!$apiKey) {
        return response()->json(['error' => 'API Key tidak ditemukan di config']);
    }
    
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey;
    
    try {
        $response = Http::timeout(30)->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => 'Halo, ini test. Jawab dengan "OK"']
                    ]
                ]
            ]
        ]);
        
        return response()->json([
            'status' => $response->successful() ? 'success' : 'failed',
            'response' => $response->json()
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});
