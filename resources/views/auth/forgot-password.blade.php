@extends('layouts.guest')

@section('title', 'Forgot Password - KonsistenKu')
@section('body-class', 'auth-page')
@section('container-class', 'container-fluid p-0')

@section('content')
<div class="row g-0 auth-split-shell">
    <div class="col-lg-6 auth-hero-pane">
        <div class="auth-hero-content">
            <h1 class="auth-brand">KonsistenKu</h1>
            <p class="auth-hero-copy">Don't worry, it happens to the best of us. Let's get you back on track.</p>
            <ul class="auth-feature-list">
                <li>Secure password recovery</li>
                <li>Keep your habits safe</li>
                <li>Quick access restoration</li>
            </ul>
        </div>
    </div>

    <div class="col-lg-6 auth-form-pane">
        <div class="auth-form-wrap">
            <a href="{{ route('login') }}" class="auth-back-link">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Sign In</span>
            </a>

            <h2 class="auth-title">Forgot Password?</h2>
            <p class="auth-subtitle">Enter the email address associated with your account and we'll send you a link to reset your password.</p>

            @if (session('status'))
                <div class="alert alert-success auth-status-alert">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
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

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Send Reset Link</button>
            </form>
        </div>

    </div>
</div>
@endsection