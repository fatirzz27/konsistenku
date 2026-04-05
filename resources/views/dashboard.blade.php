@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('body-class', 'dashboard-page')

@push('styles')
<style>
    .score-hero {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-info));
        border-radius: 1.25rem;
        box-shadow: 0 0.75rem 1.75rem rgba(0, 0, 0, 0.2);
    }

    .stat-card {
        border-top: 4px solid transparent;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 25px rgba(15, 23, 42, 0.15);
    }

    .stat-card.habits { border-top-color: var(--bs-primary); }
    .stat-card.streak { border-top-color: var(--bs-warning); }
    .stat-card.checkin { border-top-color: var(--bs-success); }
    .stat-card.badges { border-top-color: var(--bs-info); }

    .menu-card {
        border: 1px solid var(--bs-border-color);
        box-shadow: 0 0.4rem 1rem rgba(0, 0, 0, 0.08);
    }

    .menu-card .card-header {
        background: var(--bs-light);
    }

    .habit-item-link {
        color: var(--bs-dark);
    }

    .habit-item-link:hover {
        color: var(--bs-primary);
    }

    #heatmap div[title] {
        border: 1px solid rgba(148, 163, 184, 0.18);
    }

    .modal {
        z-index: 1080;
    }

    .modal-backdrop {
        z-index: 1070;
    }
</style>
@endpush

@section('content')
<!-- Skor Konsistensi -->
<div class="card score-hero text-white mb-4 shadow-sm">
    <div class="card-body text-center py-4">
        <small>Skor Konsistensi Kamu</small>
        <h1 class="display-4 fw-bold my-2">{{ $overallScore }}%</h1>
        <span>{{ $level }}</span>
        <div class="progress mt-3 mx-auto bg-white bg-opacity-25" style="max-width: 300px; height: 8px;">
            <div class="progress-bar bg-warning" style="width: {{ $overallScore }}%"></div>
        </div>
        <small class="d-block mt-1 opacity-75">Berdasarkan 30 hari terakhir</small>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card shadow-sm text-center p-3 stat-card habits">
            <h4 class="fw-bold mb-0">{{ $totalHabits }}</h4>
            <small class="text-muted">Active Habits</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm text-center p-3 stat-card streak">
            <h4 class="fw-bold mb-0">{{ $bestStreak }}</h4>
            <small class="text-muted">Best Streak</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm text-center p-3 stat-card checkin">
            <h4 class="fw-bold mb-0">{{ $totalCheckins }}</h4>
            <small class="text-muted">Total Check-in</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm text-center p-3 stat-card badges">
            <h4 class="fw-bold mb-0">{{ $totalBadges }}</h4>
            <small class="text-muted">Badges</small>
        </div>
    </div>
</div>

<!-- Habit Hari Ini -->
<div class="card menu-card mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Habit Hari Ini</strong>
        <a href="{{ route('habits.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus"></i> Tambah
        </a>
    </div>

    @if($habits->count() > 0)
    <ul class="list-group list-group-flush">
        @foreach($habits as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <span class="me-1">{{ $item['habit']->icon }}</span>
                <a href="{{ route('habits.show', $item['habit']) }}" class="text-decoration-none fw-semibold habit-item-link">
                    {{ $item['habit']->name }}
                </a>
                <br>
                <small class="text-muted">
                    {{ $item['streak'] }} hari &bull; {{ $item['score'] }}%
                </small>
            </div>
            <div>
                @if($item['logged_today'])
                    <span class="badge bg-success">
                        <i class="bi bi-check-lg"></i> Done
                    </span>
                @else
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#checkin{{ $item['habit']->id }}">
                        Check In
                    </button>
                @endif
            </div>
        </li>
        @endforeach
    </ul>

    @foreach($habits as $item)
        @unless($item['logged_today'])
        <div class="modal fade app-modal" id="checkin{{ $item['habit']->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('habits.checkin', $item['habit']) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title">{{ $item['habit']->icon }} {{ $item['habit']->name }}</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Mood</label>
                                <div class="d-flex gap-2">
                                    @foreach(['great' => 'Great', 'good' => 'Good', 'okay' => 'Okay', 'bad' => 'Bad'] as $val => $label)
                                        <div>
                                            <input type="radio" class="btn-check" name="mood" value="{{ $val }}" id="m_{{ $val }}_{{ $item['habit']->id }}">
                                            <label class="btn btn-sm btn-outline-secondary" for="m_{{ $val }}_{{ $item['habit']->id }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan <span class="text-muted">(opsional)</span></label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Simpan Check-in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endunless
    @endforeach
    @else
    <div class="card-body text-center text-muted py-5">
        <p>Belum ada habit.</p>
        <a href="{{ route('habits.create') }}" class="btn btn-primary btn-sm">Buat Habit Pertama</a>
    </div>
    @endif
</div>

<!-- Heatmap -->
<div class="card menu-card mb-4">
    <div class="card-header bg-white">
        <strong>Aktivitas 365 Hari Terakhir</strong>
    </div>
    <div class="card-body" style="overflow-x: auto;">
        <div id="heatmap"></div>
        <div class="mt-2">
            <small class="text-muted">
                <span style="display:inline-block;width:12px;height:12px;background:#ebedf0;border-radius:2px;"></span> 0
                <span style="display:inline-block;width:12px;height:12px;background:#9be9a8;border-radius:2px;margin-left:4px;"></span> 1
                <span style="display:inline-block;width:12px;height:12px;background:#40c463;border-radius:2px;margin-left:4px;"></span> 2
                <span style="display:inline-block;width:12px;height:12px;background:#30a14e;border-radius:2px;margin-left:4px;"></span> 3
                <span style="display:inline-block;width:12px;height:12px;background:#216e39;border-radius:2px;margin-left:4px;"></span> 4+
            </small>
        </div>
    </div>
</div>

<!-- Recent Achievements -->
@if($recentAchievements->isNotEmpty())
<div class="card menu-card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Achievement Terbaru</strong>
        <a href="{{ route('achievements.index') }}" class="small">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="row g-3 text-center">
            @foreach($recentAchievements as $ach)
            <div class="col-4">
                <div class="display-6">{{ $ach->icon }}</div>
                <small class="fw-bold d-block">{{ $ach->name }}</small>
                <small class="text-muted">{{ $ach->description }}</small>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
const data = @json($heatmapData);
const el = document.getElementById('heatmap');
let html = '<div style="display:flex;gap:3px;flex-wrap:wrap;">';
for (const [date, count] of Object.entries(data)) {
    let c = '#ebedf0';
    if (count === 1) c = '#9be9a8';
    else if (count === 2) c = '#40c463';
    else if (count === 3) c = '#30a14e';
    else if (count >= 4) c = '#216e39';
    html += `<div title="${date}: ${count}" style="width:12px;height:12px;background:${c};border-radius:2px;"></div>`;
}
html += '</div>';
el.innerHTML = html;
</script>
@endpush