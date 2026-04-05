@extends('layouts.guest')

@section('title', 'Register - KonsistenKu')
@section('body-class', 'auth-page')
@section('container-class', 'container-fluid p-0')

@section('content')
<div class="row g-0 auth-split-shell">
    <div class="col-lg-6 auth-hero-pane">
        <div class="auth-hero-content">
            <h1 class="auth-brand">KonsistenKu</h1>
            <p class="auth-hero-copy">Join us today and start building better habits for a better tomorrow.</p>
            <ul class="auth-feature-list">
                <li>Track unlimited habits</li>
                <li>Detailed analytics and charts</li>
                <li>Sync across all your devices</li>
            </ul>
        </div>
    </div>

    <div class="col-lg-6 auth-form-pane">
        <div class="auth-form-wrap">
            <h2 class="auth-title">Create Account</h2>
            <p class="auth-subtitle">Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign in</a></p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="John Doe"
                        required
                        autofocus
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="you@email.com"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Create a password"
                            required
                        >
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')" aria-label="Toggle password visibility">
                            <i class="bi bi-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Confirm your password"
                            required
                        >
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')" aria-label="Toggle password confirmation visibility">
                            <i class="bi bi-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    Sign Up <i class="bi bi-arrow-right ms-1"></i>
                </button>
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