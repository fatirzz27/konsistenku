@extends('layouts.guest')

@section('title', 'KonsistenKu - Track Your Habits')
@section('body-class', 'd-flex flex-column')
@section('container-class', '')

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <i class="bi bi-bullseye me-1"></i> KonsistenKu
        </a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-light btn-sm px-3 fw-semibold">Daftar</a>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="bg-primary text-white">
    <div class="container py-5">
        <div class="row align-items-center py-lg-5">
            <div class="col-lg-7">
                <h1 class="display-4 fw-bold mb-3">Bangun Kebiasaan Baik, <br>Satu Hari Dalam Satu Waktu</h1>
                <p class="lead opacity-75 mb-4">
                    Track kebiasaan harianmu, ukur konsistensi, dan bangun versi terbaik dari dirimu.
                    Sederhana, visual, dan memotivasi.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-semibold px-4">
                        <i class="bi bi-rocket-takeoff me-1"></i> Mulai Gratis
                    </a>
                    <a href="#fitur" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-arrow-down-circle me-1"></i> Pelajari
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <div class="display-1 opacity-50">
                    <i class="bi bi-bullseye"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fitur -->
<section id="fitur" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Fitur Utama</h2>
            <p class="text-muted">Semua yang kamu butuhkan untuk membangun konsistensi</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                    <div class="card-body">
                        <div class="bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-bar-chart-line fs-3 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Heatmap Visual</h5>
                        <p class="text-muted small mb-0">Lihat aktivitas 365 hari dalam satu pandangan, seperti GitHub contribution graph.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                    <div class="card-body">
                        <div class="bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-fire fs-3 text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Streak Counter</h5>
                        <p class="text-muted small mb-0">Jaga streak harianmu agar tetap konsisten. Jangan sampai putus!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                    <div class="card-body">
                        <div class="bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-trophy fs-3 text-success"></i>
                        </div>
                        <h5 class="fw-bold">Achievement Badge</h5>
                        <p class="text-muted small mb-0">Unlock badge saat mencapai milestone tertentu. Koleksi semuanya!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cara Kerja -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Cara Kerja</h2>
            <p class="text-muted">Tiga langkah sederhana menuju konsistensi</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="border border-2 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary fw-bold fs-4" style="width: 56px; height: 56px;">
                    1
                </div>
                <h5 class="fw-bold">Buat Habit</h5>
                <p class="text-muted small">Tambahkan kebiasaan yang ingin kamu lacak setiap hari.</p>
            </div>
            <div class="col-md-4">
                <div class="border border-2 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary fw-bold fs-4" style="width: 56px; height: 56px;">
                    2
                </div>
                <h5 class="fw-bold">Check-in Harian</h5>
                <p class="text-muted small">Klik check-in setiap kali kamu menyelesaikan habit.</p>
            </div>
            <div class="col-md-4">
                <div class="border border-2 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary fw-bold fs-4" style="width: 56px; height: 56px;">
                    3
                </div>
                <h5 class="fw-bold">Lihat Progress</h5>
                <p class="text-muted small">Pantau skor konsistensi, raih streak terpanjang, dan kumpulkan badge.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5">
    <div class="container">
        <div class="card border-0 bg-primary text-white rounded-4 shadow">
            <div class="card-body text-center py-5 px-4">
                <h3 class="fw-bold mb-2">Siap Jadi Lebih Konsisten?</h3>
                <p class="opacity-75 mb-4">Gratis, tanpa kartu kredit. Mulai tracking kebiasaanmu sekarang.</p>
                <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-semibold px-5">
                    <i class="bi bi-person-plus me-1"></i> Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-4 mt-auto">
    <div class="container">
        <div class="text-center text-muted">
            <small><i class="bi bi-bullseye me-1"></i> &copy; {{ date('Y') }} KonsistenKu. Bangun konsistensimu hari ini.</small>
        </div>
    </div>
</footer>
@endsection