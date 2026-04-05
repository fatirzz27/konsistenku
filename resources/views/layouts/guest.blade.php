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