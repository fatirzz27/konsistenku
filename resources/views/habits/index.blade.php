@extends('layouts.app')

@section('page-title', 'My Habits')

@section('content')
<div class="mb-4">
    <a href="{{ route('habits.create') }}" class="btn btn-primary">
        Tambah Habit Baru
    </a>
</div>

<div class="row g-4">
    @forelse($habits as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 {{ !$item['habit']->is_active ? 'opacity-50' : '' }}">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">{{ $item['habit']->name }}</h5>
                    <span class="badge bg-secondary mb-2">{{ ucfirst($item['habit']->category) }}</span>

                    <div class="d-flex justify-content-around my-3">
                        <div>
                            <div class="fw-bold streak-fire">{{ $item['streak'] }}</div>
                            <small class="text-muted">Streak</small>
                        </div>
                        <div>
                            <div class="fw-bold">{{ $item['score'] }}%</div>
                            <small class="text-muted">Score</small>
                        </div>
                    </div>

                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar {{ $item['score'] >= 75 ? 'bg-success' : ($item['score'] >= 50 ? 'bg-warning' : 'bg-danger') }}"
                             style="width: {{ $item['score'] }}%"></div>
                    </div>

                    @if(!$item['habit']->is_active)
                        <span class="badge bg-secondary">Archived</span>
                    @endif
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('habits.show', $item['habit']) }}" class="btn btn-sm btn-outline-primary me-1">Detail</a>
                    <a href="{{ route('habits.edit', $item['habit']) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted py-5">
            <h5>Belum ada habit</h5>
            <p>Buat habit pertamamu untuk mulai tracking konsistensi!</p>
            <a href="{{ route('habits.create') }}" class="btn btn-primary">Buat Habit Pertama</a>
        </div>
    @endforelse
</div>
@endsection