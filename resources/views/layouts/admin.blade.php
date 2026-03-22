<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ── Base ──────────────────────────────────── */
        body.hold-transition { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

        /* ── Sidebar ───────────────────────────────── */
        .main-sidebar {
            background: #1a1f2e !important;
            box-shadow: 4px 0 20px rgba(0,0,0,.2) !important;
        }
        .brand-link {
            background: #13172280 !important;
            border-bottom: 1px solid rgba(255,255,255,.07) !important;
            padding: 14px 20px !important;
        }
        .brand-link:hover { background: #131722 !important; }
        .brand-text {
            font-weight: 700 !important;
            font-size: 1.05rem !important;
            letter-spacing: .3px;
            color: #fff !important;
        }
        .brand-link .fas { color: #6366f1 !important; }

        /* Sidebar user panel */
        .sidebar .user-panel {
            border-bottom: 1px solid rgba(255,255,255,.07) !important;
            padding: 16px 20px 14px !important;
            margin-top: 8px;
        }
        .sidebar .user-panel .user-avatar-circle {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .9rem; color: #fff;
            flex-shrink: 0; margin-right: 10px;
        }
        .sidebar .user-panel .info a {
            color: #e2e8f0 !important;
            font-weight: 600 !important;
            font-size: .875rem !important;
        }
        .sidebar .user-panel .info small {
            color: #6366f1 !important;
            font-size: .72rem !important;
            font-weight: 600 !important;
            letter-spacing: .03em;
        }

        /* Nav items */
        .nav-sidebar .nav-link {
            border-radius: 8px !important;
            margin: 1px 10px !important;
            padding: 9px 14px !important;
            color: #8892a4 !important;
            font-size: .86rem !important;
            font-weight: 500 !important;
            transition: all .18s !important;
        }
        .nav-sidebar .nav-link:hover {
            background: rgba(255,255,255,.07) !important;
            color: #e2e8f0 !important;
        }
        .nav-sidebar .nav-link.active {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
            color: #fff !important;
            box-shadow: 0 4px 14px rgba(79,70,229,.35) !important;
        }
        .nav-sidebar .nav-icon { color: inherit !important; width: 1.4rem !important; font-size: .9rem !important; }
        .nav-header {
            color: #3d4659 !important;
            font-size: .68rem !important;
            font-weight: 700 !important;
            letter-spacing: .1em !important;
            padding: 16px 24px 5px !important;
        }
        .nav-sidebar .badge { border-radius: 10px !important; font-size: .68rem !important; }

        /* ── Top navbar ────────────────────────────── */
        .main-header.navbar {
            background: #fff !important;
            border-bottom: 1px solid #edf0f7 !important;
            box-shadow: 0 1px 8px rgba(0,0,0,.06) !important;
            padding: 0 20px !important;
            min-height: 56px !important;
        }
        .main-header .nav-link {
            color: #4a5568 !important;
            font-size: .875rem !important;
            font-weight: 500 !important;
            padding: 16px 12px !important;
        }
        .main-header .nav-link:hover { color: #4f46e5 !important; }
        .main-header .nav-link [data-widget] { color: #4a5568; }

        /* ── Content wrapper ───────────────────────── */
        .content-wrapper { background: #f0f3f9 !important; }
        .content-header {
            background: #fff !important;
            border-bottom: 1px solid #edf0f7 !important;
            padding: 14px 24px !important;
            box-shadow: 0 1px 4px rgba(0,0,0,.04) !important;
        }
        .content-header h1 {
            font-size: 1.3rem !important;
            font-weight: 700 !important;
            color: #1a202c !important;
        }
        .content { padding: 24px !important; }

        /* ── Cards ─────────────────────────────────── */
        .card {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 12px rgba(0,0,0,.06) !important;
            margin-bottom: 24px !important;
        }
        .card-header {
            background: #fff !important;
            border-bottom: 1px solid #f0f3f9 !important;
            border-radius: 12px 12px 0 0 !important;
            padding: 15px 20px !important;
        }
        .card-header .card-title {
            font-size: .95rem !important;
            font-weight: 700 !important;
            color: #1a202c !important;
            margin: 0 !important;
        }
        .card-body { padding: 20px !important; }
        .card-footer {
            background: #fafbfe !important;
            border-top: 1px solid #f0f3f9 !important;
            border-radius: 0 0 12px 12px !important;
            padding: 12px 20px !important;
        }

        /* ── Tables ────────────────────────────────── */
        .table thead th {
            background: #f7f8fc !important;
            border-bottom: 2px solid #edf0f7 !important;
            border-top: none !important;
            color: #718096 !important;
            font-size: .72rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: .07em !important;
            padding: 10px 16px !important;
            white-space: nowrap;
        }
        .table td {
            padding: 11px 16px !important;
            color: #2d3748 !important;
            vertical-align: middle !important;
            border-color: #f0f3f9 !important;
            font-size: .875rem !important;
        }
        .table-hover tbody tr:hover { background: #f7f9fe !important; }

        /* ── Buttons ───────────────────────────────── */
        .btn { border-radius: 8px !important; font-size: .85rem !important; font-weight: 500 !important; transition: all .18s !important; }
        .btn-primary  { background: #4f46e5 !important; border-color: #4f46e5 !important; }
        .btn-primary:hover  { background: #4338ca !important; border-color: #4338ca !important; box-shadow: 0 4px 12px rgba(79,70,229,.35) !important; }
        .btn-secondary { background: #64748b !important; border-color: #64748b !important; color: #fff !important; }
        .btn-secondary:hover { background: #475569 !important; border-color: #475569 !important; }
        .btn-info    { background: #0ea5e9 !important; border-color: #0ea5e9 !important; color: #fff !important; }
        .btn-info:hover { background: #0284c7 !important; border-color: #0284c7 !important; }
        .btn-warning { background: #f59e0b !important; border-color: #f59e0b !important; color: #fff !important; }
        .btn-warning:hover { background: #d97706 !important; border-color: #d97706 !important; }
        .btn-danger  { background: #ef4444 !important; border-color: #ef4444 !important; }
        .btn-danger:hover  { background: #dc2626 !important; border-color: #dc2626 !important; }
        .btn-outline-secondary { color: #64748b !important; border-color: #cbd5e1 !important; background: transparent !important; }
        .btn-outline-secondary:hover { background: #f1f5f9 !important; color: #334155 !important; }
        .btn-xs { padding: 4px 10px !important; font-size: .78rem !important; border-radius: 6px !important; }
        .btn-sm { padding: 6px 14px !important; font-size: .82rem !important; }

        /* ── Forms ─────────────────────────────────── */
        .form-control {
            border-color: #e2e8f0 !important;
            border-radius: 8px !important;
            color: #2d3748 !important;
            font-size: .875rem !important;
            padding: 8px 12px !important;
        }
        .form-control:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 3px rgba(79,70,229,.12) !important;
        }
        label { font-weight: 600 !important; font-size: .82rem !important; color: #4a5568 !important; margin-bottom: 5px !important; }

        /* ── Badges ────────────────────────────────── */
        .badge { border-radius: 6px !important; font-size: .72rem !important; font-weight: 600 !important; padding: 4px 8px !important; }
        .badge-info      { background: #0ea5e9 !important; color: #fff !important; }
        .badge-success   { background: #10b981 !important; color: #fff !important; }
        .badge-warning   { background: #f59e0b !important; color: #fff !important; }
        .badge-danger    { background: #ef4444 !important; color: #fff !important; }
        .badge-primary   { background: #4f46e5 !important; color: #fff !important; }
        .badge-secondary { background: #94a3b8 !important; color: #fff !important; }

        /* ── Alerts ────────────────────────────────── */
        .alert { border: none !important; border-radius: 10px !important; font-size: .875rem !important; border-left: 4px solid !important; }
        .alert-success { background: #f0fdf4 !important; color: #166534 !important; border-left-color: #10b981 !important; }
        .alert-danger  { background: #fef2f2 !important; color: #991b1b !important; border-left-color: #ef4444 !important; }
        .alert-warning { background: #fffbeb !important; color: #92400e !important; border-left-color: #f59e0b !important; }

        /* ── Footer ────────────────────────────────── */
        .main-footer {
            background: #fff !important;
            border-top: 1px solid #edf0f7 !important;
            color: #94a3b8 !important;
            font-size: .8rem !important;
            padding: 12px 24px !important;
        }

        /* ── Pagination ────────────────────────────── */
        .pagination { gap: 3px; }
        .pagination .page-item .page-link {
            border: 1px solid #e2e8f0 !important;
            color: #4f46e5 !important;
            border-radius: 7px !important;
            margin: 0 2px !important;
            font-size: .82rem !important;
            font-weight: 500 !important;
            padding: 6px 12px !important;
            background: #fff !important;
            transition: all .15s !important;
            box-shadow: none !important;
        }
        .pagination .page-item .page-link:hover {
            background: #eef2ff !important;
            border-color: #c7d2fe !important;
            color: #4338ca !important;
        }
        .pagination .page-item.active .page-link {
            background: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: #fff !important;
            font-weight: 700 !important;
            box-shadow: 0 3px 10px rgba(79,70,229,.3) !important;
        }
        .pagination .page-item.disabled .page-link {
            background: #f8fafc !important;
            border-color: #e2e8f0 !important;
            color: #cbd5e1 !important;
        }

        /* ── Stat cards (dashboard) ────────────────── */
        .admin-stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px 22px;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            transition: transform .18s, box-shadow .18s;
        }
        .admin-stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.1); }
        .admin-stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .admin-stat-icon.blue   { background: #eff6ff; color: #3b82f6; }
        .admin-stat-icon.indigo { background: #eef2ff; color: #4f46e5; }
        .admin-stat-icon.amber  { background: #fffbeb; color: #f59e0b; }
        .admin-stat-icon.green  { background: #f0fdf4; color: #10b981; }
        .admin-stat-num  { font-size: 1.65rem; font-weight: 800; color: #1a202c; line-height: 1; }
        .admin-stat-lbl  { font-size: .78rem; color: #94a3b8; font-weight: 600; margin-top: 3px; text-transform: uppercase; letter-spacing: .05em; }
        .admin-stat-link { font-size: .78rem; color: #4f46e5; text-decoration: none; margin-top: 6px; display: inline-flex; align-items: center; gap: 4px; font-weight: 500; }
        .admin-stat-link:hover { color: #4338ca; }

        /* ── Filter bar ────────────────────────────── */
        .admin-filter-bar {
            background: #f7f8fc;
            border: 1px solid #edf0f7;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: flex-end;
        }
        .admin-filter-bar .form-control,
        .admin-filter-bar .form-control-sm { background: #fff; }
        .admin-filter-bar label { color: #718096 !important; font-size: .75rem !important; margin-bottom: 4px !important; }

        /* ── code tags ─────────────────────────────── */
        code { background: #f1f5f9; color: #4f46e5; border-radius: 4px; padding: 2px 6px; font-size: .82rem; }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @include('admin.partials.navbar')
    @include('admin.partials.sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <h1 class="m-0">@yield('title', 'Dashboard')</h1>
                <small class="text-muted">WildCart Admin</small>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('partials.alerts')
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <strong>WildCart Admin</strong> &copy; {{ date('Y') }} &mdash; All rights reserved.
    </footer>

</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>
