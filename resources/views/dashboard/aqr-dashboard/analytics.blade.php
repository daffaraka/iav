@extends('dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📊 Analytics AQR - AI Powered</h2>
        <div>
            <form method="POST" action="{{ route('dashboard.aqr.analytics.bulk') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary">
                    🤖 Analisis 10 Tiket Terbaru
                </button>
            </form>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Periode</label>
                    <select name="period" class="form-select">
                        <option value="week" {{ $period == 'week' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="month" {{ $period == 'month' ? 'selected' : '' }}>30 Hari Terakhir</option>
                        <option value="year" {{ $period == 'year' ? 'selected' : '' }}>1 Tahun Terakhir</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lokasi Sekolah</label>
                    <select name="lokasi" class="form-select">
                        <option value="">Semua Lokasi</option>
                        <option value="Cinere" {{ $lokasi == 'Cinere' ? 'selected' : '' }}>Cinere</option>
                        <option value="Jagakarsa" {{ $lokasi == 'Jagakarsa' ? 'selected' : '' }}>Jagakarsa</option>
                        <option value="Pamulang" {{ $lokasi == 'Pamulang' ? 'selected' : '' }}>Pamulang</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- AI Summary -->
    @if($aiSummary)
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">🤖 AI Insight & Rekomendasi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>📈 Trend Utama</h6>
                    <p>{{ $aiSummary['trend_utama'] ?? '-' }}</p>

                    <h6 class="mt-3">⚠️ Masalah Terbanyak</h6>
                    <p>{{ $aiSummary['masalah_terbanyak'] ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6>💡 Rekomendasi</h6>
                    <ul>
                        @foreach($aiSummary['rekomendasi'] ?? [] as $rekomendasi)
                        <li>{{ $rekomendasi }}</li>
                        @endforeach
                    </ul>

                    <h6 class="mt-3">🎯 Insight Management</h6>
                    <p class="text-muted">{{ $aiSummary['insight'] ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>{{ $tickets->count() }}</h3>
                    <p class="text-muted mb-0">Total Tiket</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>{{ $tickets->where('ai_analyzed_at', '!=', null)->count() }}</h3>
                    <p class="text-muted mb-0">Sudah Dianalisis AI</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-warning text-white">
                <div class="card-body">
                    <h3>{{ $tickets->where('ai_prioritas', 'Urgent')->count() }}</h3>
                    <p class="mb-0">Prioritas Urgent</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-danger text-white">
                <div class="card-body">
                    <h3>{{ $tickets->where('ai_sentiment', 'Negatif')->count() }}</h3>
                    <p class="mb-0">Sentiment Negatif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <!-- Kategori -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>📂 Kategori Otomatis (AI)</h5>
                </div>
                <div class="card-body">
                    @forelse($kategoriStats as $kategori => $count)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>{{ $kategori ?: 'Belum Dikategorikan' }}</span>
                            <strong>{{ $count }}</strong>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar" style="width: {{ ($count / $tickets->count()) * 100 }}%">
                                {{ number_format(($count / $tickets->count()) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Status Trend -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>📊 Status Tiket</h5>
                </div>
                <div class="card-body">
                    @forelse($statusTrend as $status => $count)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>{{ $status }}</span>
                            <strong>{{ $count }}</strong>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: {{ ($count / $tickets->count()) * 100 }}%">
                                {{ number_format(($count / $tickets->count()) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sentiment -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>😊 Sentiment Analysis</h5>
                </div>
                <div class="card-body">
                    @forelse($sentimentStats as $sentiment => $count)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>
                                @if($sentiment == 'Positif') 😊
                                @elseif($sentiment == 'Negatif') 😠
                                @else 😐
                                @endif
                                {{ $sentiment ?: 'Belum Dianalisis' }}
                            </span>
                            <strong>{{ $count }}</strong>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar
                                @if($sentiment == 'Positif') bg-success
                                @elseif($sentiment == 'Negatif') bg-danger
                                @else bg-secondary
                                @endif"
                                style="width: {{ ($count / $tickets->count()) * 100 }}%">
                                {{ number_format(($count / $tickets->count()) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Priority -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>⚡ Prioritas</h5>
                </div>
                <div class="card-body">
                    @forelse($priorityStats as $priority => $count)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>{{ $priority ?: 'Belum Dianalisis' }}</span>
                            <strong>{{ $count }}</strong>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar
                                @if($priority == 'Urgent') bg-danger
                                @elseif($priority == 'Tinggi') bg-warning
                                @elseif($priority == 'Sedang') bg-info
                                @else bg-secondary
                                @endif"
                                style="width: {{ ($count / $tickets->count()) * 100 }}%">
                                {{ number_format(($count / $tickets->count()) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Lokasi Trend -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>🏫 Trend per Lokasi Sekolah</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($lokasiTrend as $lok => $count)
                        <div class="col-md-4">
                            <div class="text-center p-3 border rounded">
                                <h3>{{ $count }}</h3>
                                <p class="mb-0">{{ $lok }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted">Belum ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
