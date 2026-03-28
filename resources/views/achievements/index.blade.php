@extends('layouts.app')

@section('page-title', '🏆 Achievements')

@section('content')
<!-- Stats -->
<div class="alert alert-info">
    Kamu telah mengumpulkan <strong>{{ $totalUnlocked }}</strong> dari <strong>{{ $totalAll }}</strong> achievements!
    <div class="progress mt-2" style="height: 8px;">
        <div class="progress-bar bg-info" style="width: {{ $totalAll > 0 ? ($totalUnlocked / $totalAll) * 100 : 0 }}%"></div>
    </div>
</div>

<!-- Achievement Grid -->
<div class="row g-4">
    @foreach($achievements as $item)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100 {{ $item['unlocked'] ? 'shadow-sm' : 'opacity-50' }}">
                <div class="card-body">
                    <div class="display-4 mb-2">
                        {{ $item['unlocked'] ? $item['achievement']->icon : '🔒' }}
                    </div>
                    <h6 class="card-title fw-bold">{{ $item['achievement']->name }}</h6>
                    <p class="card-text small text-muted">{{ $item['achievement']->description }}</p>

                    @if($item['unlocked'])
                        <span class="badge bg-success">✅ Unlocked</span>
                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($item['unlocked_at'])->diffForHumans() }}</small>
                    @else
                        <span class="badge bg-secondary">🔒 Locked</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection