@extends('layouts.guest')

@section('title', 'Login - KonsistenKu')
@section('body-class', 'auth-page')
@section('container-class', 'container-fluid p-0')

@section('content')
<div class="row g-0 auth-split-shell">
    <div class="col-lg-6 auth-hero-pane">
        <div class="auth-hero-content">
            <h1 class="auth-brand">KonsistenKu</h1>
            <p class="auth-hero-copy">A habit tracking platform to help you stay consistent every day.</p>
            <ul class="auth-feature-list">
                <li>Automatic email reminders</li>
                <li>Streak counter and heatmap</li>
                <li>Achievement and badge system</li>
                <li>Real-time consistency score</li>
            </ul>
        </div>
    </div>

    <div class="col-lg-6 auth-form-pane">
        <div class="auth-form-wrap">
            <h2 class="auth-title">Sign In</h2>
            <p class="auth-subtitle">Don't have an account? <a href="{{ route('register') }}" class="auth-link">Create one</a></p>

            @if (session('status'))
                <div class="alert alert-success auth-status-alert">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter your password"
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" @checked(old('remember'))>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    Sign In <i class="bi bi-arrow-right ms-1"></i>
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