@extends('layouts.app')

@section('page-title')
    {{ $habit->name }}
@endsection

@section('content')
<!-- Overview Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card shadow-sm text-center p-3">
            <div class="display-6 fw-bold streak-fire">{{ $streak?->current_streak ?? 0 }}</div>
            <small class="text-muted">Current Streak</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card shadow-sm text-center p-3">
            <div class="display-6 fw-bold">{{ $score }}%</div>
            <small class="text-muted">Consistency</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card shadow-sm text-center p-3">
            <div class="display-6 fw-bold">{{ $habit->logs()->count() }}</div>
            <small class="text-muted">Total Days</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card shadow-sm text-center p-3">
            <div class="display-6 fw-bold">{{ $streak?->longest_streak ?? 0 }}</div>
            <small class="text-muted">Best Streak</small>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="mb-4 d-flex gap-2">
    @if(!$habit->isLoggedToday())
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkinModal">
            Check In Sekarang
        </button>
    @else
        <button class="btn btn-success" disabled>
            Sudah Check-in Hari Ini
        </button>
    @endif
    <a href="{{ route('habits.edit', $habit) }}" class="btn btn-outline-secondary">
        Edit
    </a>
</div>

<!-- Check-in Calendar (bulan ini) -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white fw-bold">Kalender Bulan Ini</div>
    <div class="card-body">
        @php
            $daysInMonth = now()->daysInMonth;
            $firstDayOfWeek = now()->startOfMonth()->dayOfWeek; // 0=Sun, 1=Mon
        @endphp
        <div class="text-center mb-2 fw-bold">{{ now()->format('F Y') }}</div>
        <div class="d-flex justify-content-center flex-wrap" style="max-width: 350px; margin: 0 auto;">
            @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $day)
                <div class="text-center text-muted small fw-bold" style="width: 44px; padding: 4px;">{{ $day }}</div>
            @endforeach
            @for($i = 0; $i < $firstDayOfWeek; $i++)
                <div style="width: 44px; padding: 4px;"></div>
            @endfor
            @for($d = 1; $d <= $daysInMonth; $d++)
                @php
                    $dateStr = now()->format('Y-m-') . str_pad($d, 2, '0', STR_PAD_LEFT);
                    $isLogged = in_array($dateStr, $monthLogs);
                    $isToday = $dateStr === today()->format('Y-m-d');
                @endphp
                <div class="text-center rounded m-1 {{ $isLogged ? 'bg-success text-white' : ($isToday ? 'border border-primary' : 'bg-light') }}"
                     style="width: 36px; height: 36px; line-height: 36px; font-size: 14px;">
                    {{ $d }}
                </div>
            @endfor
        </div>
        <div class="text-center mt-2">
            <small>
                <span class="badge bg-success">&nbsp;</span> Checked
                <span class="badge bg-light text-dark border">&nbsp;</span> Belum
            </small>
        </div>
    </div>
</div>

<!-- Recent Logs -->
<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold">Riwayat Check-in</div>
    <div class="list-group list-group-flush">
        @forelse($recentLogs as $log)
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>{{ $log->logged_at->format('d M Y') }}</strong>
                        @if($log->mood)
                            <span class="ms-2">
                                {{ ['great' => '😊', 'good' => '🙂', 'okay' => '😐', 'bad' => '😞'][$log->mood] ?? '' }}
                            </span>
                        @endif
                    </div>
                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                </div>
                @if($log->notes)
                    <small class="text-muted">{{ $log->notes }}</small>
                @endif
            </div>
        @empty
            <div class="list-group-item text-center text-muted py-4">
                Belum ada riwayat check-in.
            </div>
        @endforelse
    </div>
</div>

<!-- Check-in Modal -->
@unless($habit->isLoggedToday())
<div class="modal fade" id="checkinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('habits.checkin', $habit) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Check-in: {{ $habit->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Bagaimana perasaanmu?</label>
                        <div class="d-flex gap-2">
                            @foreach(['great' => '😊 Great', 'good' => '🙂 Good', 'okay' => '😐 Okay', 'bad' => '😞 Bad'] as $val => $label)
                                <input type="radio" class="btn-check" name="mood" value="{{ $val }}" id="mood_{{ $val }}">
                                <label class="btn btn-outline-secondary" for="mood_{{ $val }}">{{ $label }}</label>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan (opsional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Apa yang kamu lakukan?"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan Check-in</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endunless
@endsection