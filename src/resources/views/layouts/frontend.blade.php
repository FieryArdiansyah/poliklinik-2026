<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PoliQueue' }}</title>

    @stack('head')

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #dbeafe;
            --secondary: #eef2f7;
            --text-dark: #0f172a;
            --text-muted: #475569;
            --white: #ffffff;
            --border: #e2e8f0;
            --danger: #ef4444;
            --success: #16a34a;
            --warning: #f59e0b;
            --shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            --radius-lg: 28px;
            --radius-md: 18px;
            --radius-sm: 12px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(100% - 32px, 1180px);
            margin: 0 auto;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
        }

        .navbar-inner {
            height: 74px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            font-size: 26px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.6px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            transition: 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .nav-link.admin {
            color: var(--white);
            background: var(--primary);
        }

        .nav-link.admin:hover {
            color: var(--white);
            background: var(--primary-dark);
        }

        .page {
            padding: 48px 0 70px;
        }

        .section-title {
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.15;
            letter-spacing: -1.2px;
            margin-bottom: 12px;
        }

        .section-desc {
            color: var(--text-muted);
            font-size: 17px;
            max-width: 720px;
        }

        .card {
            background: var(--white);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 20px;
            border-radius: var(--radius-sm);
            border: 1px solid transparent;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-primary {
            color: var(--white);
            background: var(--primary);
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.22);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            color: var(--text-dark);
            background: var(--secondary);
            border-color: var(--border);
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .alert {
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 18px;
            font-weight: 700;
        }

        .alert-success {
            color: #14532d;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            color: #7f1d1d;
            background: #fee2e2;
            border: 1px solid #fecaca;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            display: grid;
            gap: 8px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            font-weight: 800;
            color: var(--text-dark);
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 13px 14px;
            font-size: 15px;
            color: var(--text-dark);
            background: var(--white);
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: 3px solid rgba(37, 99, 235, 0.18);
            border-color: var(--primary);
        }

        .error-text {
            color: var(--danger);
            font-size: 13px;
            font-weight: 700;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
        }

        .status-waiting {
            color: #334155;
            background: #e2e8f0;
        }

        .status-called {
            color: #92400e;
            background: #fef3c7;
        }

        .status-done {
            color: #166534;
            background: #dcfce7;
        }

        .status-cancelled {
            color: #991b1b;
            background: #fee2e2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 14px;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        th {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-muted);
            background: #f8fafc;
        }

        .footer {
            padding: 24px 0;
            border-top: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.75);
            color: var(--text-muted);
            text-align: center;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .navbar-inner {
                height: auto;
                padding: 18px 0;
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .nav-menu {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 4px;
            }

            .nav-link {
                white-space: nowrap;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            table {
                min-width: 780px;
            }

            .table-wrap {
                overflow-x: auto;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
<header class="navbar">
    <div class="container navbar-inner">
        <a href="{{ route('home') }}" class="brand">PoliQueue</a>

        <nav class="nav-menu">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('queues.create') }}" class="nav-link {{ request()->routeIs('queues.create') ? 'active' : '' }}">Ambil Antrian</a>
            <a href="{{ route('queues.index') }}" class="nav-link {{ request()->routeIs('queues.index') ? 'active' : '' }}">Monitoring</a>
            <a href="/admin" class="nav-link admin">Admin</a>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="footer">
    <div class="container">
        © {{ date('Y') }} PoliQueue. Sistem Informasi Antrian Poliklinik.
    </div>
</footer>

@stack('scripts')
</body>
</html>