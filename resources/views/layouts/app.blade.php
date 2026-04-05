<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KonsistenKu')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background-color: var(--bs-light);
        }

        .app-shell {
            position: relative;
        }

        .dashboard-page::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -2;
            pointer-events: none;
            background-image: linear-gradient(120deg, rgba(13, 110, 253, 0.62), rgba(33, 37, 41, 0.52)), url('https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }

        .dashboard-page::after {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background: rgba(33, 37, 41, 0.35);
        }

        .app-navbar {
            background-color: var(--bs-primary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.22);
        }

        .app-navbar .navbar-brand {
            letter-spacing: 0.2px;
        }

        .app-navbar .nav-link {
            border-radius: 0;
            padding: 0.65rem 0.85rem;
            color: rgba(255, 255, 255, 0.86);
            transition: all 0.2s ease;
            border-bottom: 3px solid transparent;
            font-weight: 500;
        }

        .app-navbar .nav-link:hover {
            color: #fff;
            border-bottom-color: rgba(255, 255, 255, 0.55);
        }

        .app-navbar .nav-link.active {
            color: #fff;
            background: transparent;
            border-bottom-color: var(--menu-accent);
        }

        .app-content-wrap {
            background: #fff;
            border: 1px solid var(--bs-border-color);
            border-radius: 1.25rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .dashboard-page .app-content-wrap {
            background: rgba(255, 255, 255, 0.94);
        }

        .app-page-title {
            color: var(--bs-dark);
            border-left: 5px solid var(--menu-accent);
            padding-left: 0.75rem;
        }

        .card {
            border: 0;
            border-radius: 1rem;
        }

        .card-header {
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        }

        .app-modal .modal-content {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.28);
            overflow: hidden;
        }

        .app-modal .modal-header {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
            padding: 1rem 1.25rem;
        }

        .app-modal .modal-body {
            padding: 1.15rem 1.25rem;
        }

        .app-modal .modal-footer {
            background: #f8fafc;
            border-top: 1px solid rgba(148, 163, 184, 0.2);
            padding: 0.85rem 1.25rem;
        }

        .theme-dashboard {
            --menu-accent: var(--bs-info);
            --menu-primary: var(--bs-primary);
            --menu-primary-hover: #0b5ed7;
            --menu-primary-border: #0a58ca;
        }

        .theme-habits {
            --menu-accent: var(--bs-success);
            --menu-primary: var(--bs-success);
            --menu-primary-hover: #157347;
            --menu-primary-border: #146c43;
        }

        .theme-achievements {
            --menu-accent: var(--bs-warning);
            --menu-primary: var(--bs-warning);
            --menu-primary-hover: #ffca2c;
            --menu-primary-border: #ffc720;
        }

        .theme-default {
            --menu-accent: var(--bs-primary);
            --menu-primary: var(--bs-primary);
            --menu-primary-hover: #0b5ed7;
            --menu-primary-border: #0a58ca;
        }

        .btn-primary {
            background-color: var(--menu-primary);
            border-color: var(--menu-primary);
        }

        .btn-primary:hover {
            background-color: var(--menu-primary-hover);
            border-color: var(--menu-primary-border);
        }

        .btn-outline-primary {
            color: var(--menu-primary);
            border-color: var(--menu-primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--menu-primary);
            border-color: var(--menu-primary);
            color: #fff;
        }
    </style>
    @stack('styles')
</head>
@php
    $menuTheme = request()->routeIs('dashboard')
        ? 'theme-dashboard'
        : (request()->routeIs('habits.*')
            ? 'theme-habits'
            : (request()->routeIs('achievements.*') ? 'theme-achievements' : 'theme-default'));
@endphp
<body class="app-shell {{ $menuTheme }} @yield('body-class')">

    @auth
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark app-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">KonsistenKu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('habits.*') ? 'active' : '' }}" href="{{ route('habits.index') }}">
                            <i class="bi bi-check2-circle me-1"></i> My Habits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('achievements.*') ? 'active' : '' }}" href="{{ route('achievements.index') }}">
                            <i class="bi bi-trophy me-1"></i> Achievements
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="bi bi-person-circle me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-pencil me-2"></i> Edit Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <div class="app-content-wrap p-3 p-md-4">

        <!-- Page Title -->
        @hasSection('page-title')
        <h4 class="fw-bold mb-4 app-page-title">@yield('page-title')</h4>
        @endif

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
        </div>
    </div>

    @else
        @yield('content')
    @endauth

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.modal').forEach(function (modalEl) {
                if (modalEl.parentElement !== document.body) {
                    document.body.appendChild(modalEl);
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>