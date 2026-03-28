@extends('layouts.guest')

@section('title', 'Lupa Password - KonsistenKu')
@section('body-class', 'd-flex align-items-center')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 col-xl-4">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <p class="text-muted small mb-3">
                    Masukkan email kamu dan kami akan kirimkan link untuk reset password.
                </p>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="contoh@email.com"
                                required
                                autofocus
                            >
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-send me-1"></i> Kirim Link Reset
                    </button>
                </form>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="d-grid gap-2 mt-3">
            <a href="{{ route('login') }}" class="btn btn-outline-secondary py-2 fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary py-2">
                <i class="bi bi-x-lg me-1"></i> Batal
            </a>
        </div>

    </div>
</div>
@endsection