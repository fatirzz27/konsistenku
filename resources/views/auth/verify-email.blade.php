@extends('layouts.guest')

@section('title', 'Verifikasi Email - KonsistenKu')
@section('body-class', 'd-flex align-items-center')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 col-xl-4">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-center">
                <h5 class="fw-bold">Verifikasi Email Kamu</h5>
                <p class="text-muted small">
                    Kami sudah mengirim link verifikasi ke email kamu.
                    Silakan cek inbox dan klik link tersebut.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success small">
                        Link verifikasi baru telah dikirim!
                    </div>
                @endif

                <div class="d-grid gap-2">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-send me-1"></i> Kirim Ulang Email
                        </button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection