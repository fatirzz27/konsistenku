@extends('layouts.app')

@section('page-title', 'Achievements')
@section('body-class', 'achievements-page')

@push('styles')
<style>
    .achievements-page::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: -2;
        pointer-events: none;
        background-image: linear-gradient(120deg, rgba(13, 110, 253, 0.45), rgba(255, 193, 7, 0.42)), url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
    }

    .achievements-page::after {
        content: "";
        position: fixed;
        inset: 0;
        z-index: -1;
        pointer-events: none;
        background: rgba(33, 37, 41, 0.3);
    }

    .achievements-page .app-content-wrap {
        background: rgba(255, 255, 255, 0.94);
    }

    .achievement-card {
        border: 1px solid var(--bs-border-color);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08);
    }
</style>
@endpush

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
            <div class="card achievement-card text-center h-100 {{ $item['unlocked'] ? '' : 'opacity-50' }}">
                <div class="card-body">
                    <div class="display-4 mb-2">
                        {{ $item['unlocked'] ? $item['achievement']->icon : 'Lock' }}
                    </div>
                    <h6 class="card-title fw-bold">{{ $item['achievement']->name }}</h6>
                    <p class="card-text small text-muted">{{ $item['achievement']->description }}</p>

                    @if($item['unlocked'])
                        <span class="badge bg-success">Unlocked</span>
                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($item['unlocked_at'])->diffForHumans() }}</small>
                    @else
                        <span class="badge bg-secondary">Locked</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection