@extends('layouts.guest')

@section('title', 'Reset Password - KonsistenKu')
@section('body-class', 'auth-page')
@section('container-class', 'container-fluid p-0')

@section('content')
<div class="row g-0 auth-split-shell">
    <div class="col-lg-6 auth-hero-pane">
        <div class="auth-hero-content">
            <h1 class="auth-brand">KonsistenKu</h1>
            <p class="auth-hero-copy">Create a new password to secure your account and continue your consistency journey.</p>
            <ul class="auth-feature-list">
                <li>Secure password update process</li>
                <li>Protected account and habit history</li>
                <li>Fast access back to your dashboard</li>
            </ul>
        </div>
    </div>

    <div class="col-lg-6 auth-form-pane">
        <div class="auth-form-wrap">
            <a href="{{ route('login') }}" class="auth-back-link">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Sign In</span>
            </a>

            <h2 class="auth-title">Reset Password</h2>
            <p class="auth-subtitle">Enter your email and create a new password to finish account recovery.</p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter"
                            required
                        >
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')" aria-label="Toggle new password visibility">
                            <i class="bi bi-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="Ulangi password baru"
                            required
                        >
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')" aria-label="Toggle password confirmation visibility">
                            <i class="bi bi-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(id + '-icon');

        if (!input || !icon) {
            return;
        }

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