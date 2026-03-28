@extends('layouts.app')

@section('page-title', 'Buat Habit Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('habits.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Habit</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Olahraga Pagi" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi (opsional)</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Jelaskan habitmu...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category" class="form-select" required>
                            <option value="health" {{ old('category') == 'health' ? 'selected' : '' }}>Kesehatan</option>
                            <option value="study" {{ old('category') == 'study' ? 'selected' : '' }}>Belajar</option>
                            <option value="work" {{ old('category') == 'work' ? 'selected' : '' }}>Pekerjaan</option>
                            <option value="personal" {{ old('category') == 'personal' ? 'selected' : '' }}>Personal</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Waktu Reminder</label>
                        <input type="time" name="reminder_time" class="form-control" value="{{ old('reminder_time') }}">
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="reminder_enabled" class="form-check-input" id="reminder_enabled" {{ old('reminder_enabled') ? 'checked' : '' }}>
                            <label class="form-check-label" for="reminder_enabled">
                                Aktifkan Email Reminder
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Habit</button>
                        <a href="{{ route('habits.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection