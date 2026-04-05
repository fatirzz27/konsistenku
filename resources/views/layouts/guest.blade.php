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
            background:
                radial-gradient(circle at 15% 20%, rgba(13, 110, 253, 0.16), transparent 38%),
                radial-gradient(circle at 85% 0%, rgba(22, 163, 74, 0.14), transparent 32%),
                linear-gradient(180deg, #f8fbff 0%, #eef3f9 100%);
            color: #1f2937;
        }

        .auth-surface {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .card {
            border-radius: 1rem;
        }

        .auth-page {
            min-height: 100vh;
            background-color: var(--bs-light);
        }

        .auth-split-shell {
            min-height: 100vh;
        }

        .auth-hero-pane {
            position: relative;
            display: flex;
            align-items: center;
            color: var(--bs-white);
            overflow: hidden;
        }

        .auth-hero-pane::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(var(--bs-primary-rgb), 0.9), rgba(var(--bs-primary-rgb), 0.9)),
                url('https://images.unsplash.com/photo-1452626038306-9aae5e071dd3?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }

        .auth-hero-pane::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 15% 20%, rgba(255, 255, 255, 0.14), transparent 38%);
        }

        .auth-hero-content {
            position: relative;
            z-index: 1;
            width: min(540px, 100%);
            padding: 3rem;
        }

        .auth-brand {
            font-size: clamp(2.2rem, 4vw, 3rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .auth-hero-copy {
            font-size: clamp(1.2rem, 2.4vw, 1.8rem);
            line-height: 1.35;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .auth-feature-list {
            list-style: disc;
            padding-left: 1.35rem;
            margin: 0;
        }

        .auth-feature-list li {
            font-size: clamp(1rem, 1.3vw, 1.25rem);
            line-height: 1.4;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .auth-form-pane {
            background-color: var(--bs-body-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 500px;
        }

        .auth-title {
            font-size: clamp(2rem, 3vw, 2.8rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--bs-dark);
            margin-bottom: 0.3rem;
        }

        .auth-subtitle {
            color: var(--bs-secondary-color);
            margin-bottom: 1.75rem;
            font-size: 1.1rem;
            line-height: 1.5;
        }

        .auth-link {
            color: var(--bs-primary);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .auth-form-wrap .form-label {
            font-size: 1rem;
            color: var(--bs-dark);
            font-weight: 600;
            margin-bottom: 0.45rem;
        }

        .auth-form-wrap .form-control {
            min-height: 2.8rem;
            font-size: 1rem;
        }

        .auth-form-wrap .form-check-label {
            color: var(--bs-secondary-color);
            font-size: 0.95rem;
            font-weight: 600;
        }

        .auth-back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--bs-secondary-color);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .auth-back-link:hover {
            color: var(--bs-primary);
        }

        .auth-status-alert {
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .auth-form-wrap .invalid-feedback {
            display: block;
        }

        @media (max-width: 991.98px) {
            .auth-split-shell {
                min-height: auto;
            }

            .auth-hero-pane {
                min-height: 320px;
            }

            .auth-form-pane {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }

            .auth-subtitle {
                font-size: 1rem;
            }

            .auth-feature-list li {
                font-size: 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .auth-hero-pane {
                min-height: 280px;
            }

            .auth-hero-content {
                padding: 2rem 1.25rem;
            }

            .auth-form-pane {
                padding: 1.5rem 1rem 2rem;
            }

            .auth-form-wrap .form-control {
                min-height: 2.7rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="@yield('body-class')">

    <div class="@yield('container-class', 'container py-4 auth-surface')">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>