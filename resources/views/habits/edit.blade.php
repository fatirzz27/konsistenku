@extends('layouts.app')

@section('page-title', 'Edit Habit')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('habits.update', $habit) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Habit</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $habit->name) }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $habit->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category" class="form-select" required>
                            @foreach(['health' => 'Kesehatan', 'study' => 'Belajar', 'work' => 'Pekerjaan', 'personal' => 'Personal', 'other' => 'Lainnya'] as $val => $label)
                                <option value="{{ $val }}" {{ $habit->category == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Waktu Reminder</label>
                        <input type="time" name="reminder_time" class="form-control"
                               value="{{ old('reminder_time', $habit->reminder_time?->format('H:i')) }}">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="reminder_enabled" class="form-check-input" id="reminder_enabled"
                                   {{ $habit->reminder_enabled ? 'checked' : '' }}>
                            <label class="form-check-label" for="reminder_enabled">Aktifkan Email Reminder</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                   {{ $habit->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Habit Aktif</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Habit</button>
                        <a href="{{ route('habits.show', $habit) }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete -->
        <div class="card shadow-sm mt-4 border-danger">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <strong class="text-danger">Hapus Habit</strong>
                    <p class="mb-0 text-muted small">Semua data log dan streak akan ikut terhapus.</p>
                </div>
                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteHabitModal">
                    Hapus
                </button>
            </div>
        </div>

        <div class="modal fade app-modal" id="deleteHabitModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center gap-2">
                            <span class="text-danger"><i class="bi bi-exclamation-triangle-fill"></i></span>
                            Konfirmasi Hapus Habit
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">Yakin ingin menghapus habit <strong>{{ $habit->name }}</strong>?</p>
                        <div class="alert alert-warning mb-0 small">
                            Tindakan ini bersifat permanen dan semua data log serta streak terkait akan hilang.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('habits.destroy', $habit) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i> Ya, Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection