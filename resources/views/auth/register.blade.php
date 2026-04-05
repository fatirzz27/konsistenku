@extends('layouts.guest')

@section('title', 'Register - KonsistenKu')
@section('body-class', 'auth-page d-flex align-items-center justify-content-center py-4')
@section('container-class', 'container-fluid p-0')

@push('styles')
<style>
    .auth-page {
        background: radial-gradient(circle at 20% 10%, rgba(37, 99, 235, 0.2), transparent 35%), #101318;
        min-height: 100vh;
    }

    .auth-shell {
        width: min(1100px, 94vw);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
    }

    .auth-brand-pane {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        color: #e2e8f0;
        padding: 2.5rem;
    }

    .auth-form-pane {
        background: #2c2f35;
        color: #d1d5db;
        padding: 2.5rem;
    }

    .auth-form-pane .form-control,
    .auth-form-pane .input-group-text,
    .auth-form-pane .btn-outline-secondary {
        background: transparent;
        border-color: #4b5563;
        color: #e5e7eb;
    }

    .auth-form-pane .form-control::placeholder {
        color: #9ca3af;
    }

    .auth-form-pane .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.2);
    }

    .auth-form-pane .btn-primary {
        background: #f3f4f6;
        color: #1f2937;
        border: 0;
    }

    .auth-form-pane .btn-primary:hover {
        background: #e5e7eb;
        color: #111827;
    }

    .auth-link {
        color: #60a5fa;
        text-decoration: none;
    }

    .auth-link:hover {
        color: #93c5fd;
        text-decoration: underline;
    }

    .auth-muted {
        color: #9ca3af;
    }
</style>
@endpush

@section('content')
<div class="mx-auto auth-shell row g-0">
    <div class="col-lg-5 auth-brand-pane d-none d-lg-flex flex-column justify-content-center">
        <h2 class="fw-bold mb-4">KonsistenKu</h2>
        <p class="mb-4 fs-5">Build healthier routines and stay accountable every single day.</p>
        <ul class="ps-3 mb-0">
            <li class="mb-2">Track habits with one click check-in</li>
            <li class="mb-2">See your progress in visual heatmaps</li>
            <li class="mb-2">Unlock milestones and achievements</li>
            <li>Get a clear consistency score each week</li>
        </ul>
    </div>

    <div class="col-lg-7 auth-form-pane">
        <div class="mx-auto" style="max-width: 430px;">
            <h2 class="fw-bold mb-1">Create Account</h2>
            <p class="auth-muted mb-4">Already have an account? <a href="{{ route('login') }}" class="auth-link fw-semibold">Sign in</a></p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold small">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Enter your full name"
                        required
                        autofocus
                    >
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold small">Email</label>
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
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold small">Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimum 8 characters"
                            required
                        >
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold small">Confirm Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Repeat your password"
                            required
                        >
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                            <i class="bi bi-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    Create Account <i class="bi bi-arrow-right ms-1"></i>
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