@extends('layouts.guest')

@section('title', 'Konfirmasi Password - KonsistenKu')
@section('body-class', 'd-flex align-items-center')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 col-xl-4">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <p class="text-muted small mb-3">
                    Ini adalah area yang aman. Silakan konfirmasi password kamu sebelum melanjutkan.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold small">Password</label>
                        <div class="input-group">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password"
                                required
                            >
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                <i class="bi bi-eye" id="password-icon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Konfirmasi</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(id + '-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endpush