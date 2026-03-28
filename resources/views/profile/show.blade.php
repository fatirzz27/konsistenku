@extends('layouts.app')

@section('page-title', 'Profile')

@section('content')
<div class="container my-5">
    <!-- Profile Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <i class="bi bi-person-circle text-primary" style="font-size: 60px;"></i>
                </div>
                <div class="col-md-8">
                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                    @if($user->bio)
                    <p class="mt-2 mb-0">{{ $user->bio }}</p>
                    @endif
                </div>
                <div class="col-md-2 text-end">
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card text-center p-3">
                <h4 class="fw-bold mb-0 text-primary">{{ $totalHabits }}</h4>
                <small class="text-muted">Total Habits</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center p-3">
                <h4 class="fw-bold mb-0 text-success">{{ $activeHabits }}</h4>
                <small class="text-muted">Active</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center p-3">
                <h4 class="fw-bold mb-0 text-warning">🔥 {{ $bestStreak }}</h4>
                <small class="text-muted">Best Streak</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center p-3">
                <h4 class="fw-bold mb-0 text-danger">{{ $achievementCount }}</h4>
                <small class="text-muted">Achievements</small>
            </div>
        </div>
    </div>

    <!-- Recent Habits -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">My Habits</h6>
        </div>
        <div class="card-body">
            @if($habits->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($habits->take(5) as $habit)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $habit->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $habit->category }}</small>
                        </div>
                        <div>
                            @if($habit->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <a href="{{ route('habits.index') }}" class="btn btn-sm btn-primary">View All Habits</a>
                </div>
            @else
                <p class="text-muted mb-0">No habits yet</p>
            @endif
        </div>
    </div>
</div>

@endsection
