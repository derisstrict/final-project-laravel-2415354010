<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ERP App')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #f8f8f8;
            --surface: #FFFFFF;
            --surface2: #f1f1f1;
            --border: #DFDFDF;
            --accent: oklch(37.4% 0.01 67.558)  ;
            --accent-light: #252525;
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --text: #252525;
            --text-muted: #4C4C4C;
            --radius: 12px;
            --shadow: 0 4px 24px rgba(0,0,0,0.4);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--surface);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }
        .sidebar-logo {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-right: 1px solid var(--border);
        }
        .sidebar-logo .logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--accent), #a855f7);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar-logo span { font-size: 18px; font-weight: 700; }

        .sidebar-nav { padding: 16px 12px; flex: 1; border-right: 1px solid var(--border); }
        .nav-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            color: var(--text-muted);
            text-transform: uppercase;
            padding: 8px 8px 4px;
            margin-top: 8px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 14px; font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }
        .nav-item:hover, .nav-item.active {
            background: var(--surface2);
            color: var(--text);
        }
        .nav-item.active { color: var(--accent-light); }
        .nav-item .icon { display: flex; align-items: center; width: 20px; }

        .main { margin-left: 240px; flex: 1; padding: 32px; min-height: 100vh; }

        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px;
        }
        .page-header h1 {
            font-size: 24px; font-weight: 700;
            display: flex; align-items: center; gap: 10px;
        }
        .page-header p { font-size: 14px; color: var(--text-muted); margin-top: 4px; }

        .alert {
            padding: 12px 16px; border-radius: var(--radius);
            margin-bottom: 20px; font-size: 14px;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-success { background: #ffffff; border: 1px solid var(--border); color: oklch(79.2% 0.209 151.711); }
        .alert-error   { background: #ffffff;  border: 1px solid var(--border);  color: oklch(70.4% 0.191 22.216); }
        .alert-close { margin-left: auto; cursor: pointer; opacity: 0.7; background: none; border: none; color: inherit; display: flex; align-items: center; }
        .alert-close:hover { opacity: 1; }

        .card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            
        }
        .card-header {
            padding: 20px 24px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title { font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        .card-body { padding: 24px; }

        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        thead th {
            text-align: left; padding: 12px 16px;
            color: var(--text-muted); font-size: 11px;
            font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px;
        }
        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: var(--surface); }
        tbody td { padding: 14px 16px; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 999px;
            font-size: 11px; font-weight: 600;
        }
        .badge-success { background: oklch(98.2% 0.018 155.826); color: oklch(79.2% 0.209 151.711); }
        .badge-danger  { background: oklch(97.1% 0.013 17.38);  color: oklch(70.4% 0.191 22.216); }
        .badge-warning { background: rgba(245,158,11,0.15); color: oklch(85.2% 0.199 91.936)    ; }
        .badge-info    { background: rgba(59,130,246,0.15); color: oklch(70.7% 0.165 254.624); }
        .badge-secondary { background: rgba(148,163,184,0.15); color: oklch(55.4% 0.046 257.417); }

        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: 16px;
            font-size: 13px; font-weight: 500;
            text-decoration: none; border: none; cursor: pointer;
            transition: all 0.2s; white-space: nowrap;
        }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: var(--accent-light); transform: translateY(-1px); }
        .btn-success { background: var(--surface); color: oklch(79.2% 0.209 151.711); border: 1px solid var(--border); }
        .btn-success:hover { background: rgba(34,197,94,0.3); }
        .btn-danger  { background: var(--surface);  color: oklch(70.4% 0.191 22.216); border: 1px solid var(--border); }
        .btn-danger:hover { background: rgba(239,68,68,0.3); }
        .btn-warning { background: var(--surface); color: oklch(82.8% 0.189 84.429); border: 1px solid var(--border); }
        .btn-warning:hover { background: rgba(245,158,11,0.3); }
        .btn-ghost { background: var(--surface); color: var(--text-muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: oklch(87.1% 0.006 286.286) }
        .btn-secondary { background: var(--surface); color: oklch(74.6% 0.16 232.661); border: 1px solid var(--border); }
        .btn-secondary:hover { background: oklch(90.1% 0.058 230.902); }
        .btn-sm { padding: 8px 12px; font-size: 12px; }

        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 13px; font-weight: 500; color: var(--text-muted); margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 10px 14px;
            background: var(--surface2);
            border-radius: 8px; color: var(--text);
            font-size: 14px; font-family: 'Inter', sans-serif;
            transition: border-color 0.2s;
            box-shadow: none;
            border: 1px solid var(--surface2);
            outline: 0;
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(108,99,255,0.15); }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { color: #fca5a5; font-size: 12px; margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        .filter-bar {
            display: flex; align-items: center; gap: 10px;
            background: var(--surface);
            border-radius: var(--radius); padding: 12px 16px;
            margin-bottom: 20px;
            border: 1px solid var(--border);
        }

        .action-group { display: flex; gap: 6px; align-items: center; }

        .empty-state { text-align: center; padding: 48px 24px; color: var(--text-muted); }
        .empty-state .icon { display: flex; justify-content: center; margin-bottom: 12px; opacity: 0.4; }
        .empty-state p { font-size: 14px; }

        .detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .detail-item label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.7px; }
        .detail-item .value { font-size: 15px; font-weight: 500; margin-top: 4px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; padding: 16px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <span>Dashboard</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <a href="{{ route('customers.index') }}" class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <span class="icon"><x-icon name="users" size="18" /></span> Customers
        </a>
        <a href="{{ route('services.index') }}" class="nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
            <span class="icon"><x-icon name="wrench" size="18" /></span> Services
        </a>
        <a href="{{ route('subscriptions.index') }}" class="nav-item {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
            <span class="icon"><x-icon name="clipboard" size="18" /></span> Subscriptions
        </a>
    </nav>
</aside>

<div class="main">
    @if(session('success'))
        <div class="alert alert-success" id="flash-alert">
            <x-icon name="check-circle" size="16" />
            {{ session('success') }}
            <button class="alert-close" onclick="document.getElementById('flash-alert').remove()">
                <x-icon name="x" size="14" />
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error" id="flash-alert-err">
            <x-icon name="x-circle" size="16" />
            {{ session('error') }}
            <button class="alert-close" onclick="document.getElementById('flash-alert-err').remove()">
                <x-icon name="x" size="14" />
            </button>
        </div>
    @endif

    @yield('content')
</div>

<script>
    setTimeout(() => {
        ['flash-alert','flash-alert-err'].forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.style.opacity = '0'; el.style.transition = 'opacity 0.5s'; setTimeout(() => el.remove(), 500); }
        });
    }, 4000);
</script>
@stack('scripts')
</body>
</html>
