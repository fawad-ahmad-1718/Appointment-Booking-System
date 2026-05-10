<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AppointBook') – AppointBook</title>
    <meta name="description" content="Online Appointment Booking System – book, manage, and track your appointments easily.">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
/* =============================================
   AppointBook – Custom CSS (Inline for Railway)
   ============================================= */
 
:root {
    --primary: #4f46e5;
    --primary-dark: #3730a3;
    --primary-light: #818cf8;
    --secondary: #0ea5e9;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --dark: #0f172a;
    --sidebar-bg: #1a1f36;
    --sidebar-width: 260px;
    --topbar-height: 65px;
    --text-muted: #94a3b8;
    --card-bg: #ffffff;
    --body-bg: #f1f5f9;
}
 
* { box-sizing: border-box; margin: 0; padding: 0; }
 
body {
    font-family: 'Inter', sans-serif;
    background: var(--body-bg);
    color: #1e293b;
    min-height: 100vh;
}
 
/* ── SIDEBAR ──────────────────────────────── */
.sidebar {
    position: fixed;
    top: 0; left: 0;
    width: var(--sidebar-width);
    height: 100vh;
    background: var(--sidebar-bg);
    z-index: 1000;
    overflow-y: auto;
    transition: width 0.3s ease, transform 0.3s ease;
    box-shadow: 4px 0 20px rgba(0,0,0,0.15);
}
.sidebar.collapsed { width: 70px; }
.sidebar.collapsed .sidebar-label,
.sidebar.collapsed .sidebar-link span,
.sidebar.collapsed .sidebar-brand span { display: none; }
.sidebar.collapsed .sidebar-link { justify-content: center; }
.sidebar.collapsed .sidebar-link i { margin: 0; }
 
.sidebar-brand {
    display: flex;
    align-items: center;
    padding: 22px 20px;
    color: #fff;
    font-size: 1.2rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    background: rgba(79,70,229,0.3);
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
.sidebar-brand i { font-size: 1.4rem; color: var(--primary-light); }
 
.sidebar-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    padding: 14px 20px 6px;
}
 
.sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 20px;
    color: #cbd5e1;
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 500;
    transition: all 0.2s;
    border-radius: 0;
    cursor: pointer;
}
.sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
.sidebar-link.active { background: linear-gradient(90deg, var(--primary), rgba(79,70,229,0.4)); color: #fff; border-left: 3px solid var(--primary-light); }
.sidebar-link i { font-size: 1.05rem; min-width: 20px; }
.sidebar-divider { border-top: 1px solid rgba(255,255,255,0.08); margin: 12px 0; }
.logout-btn { color: #f87171 !important; }
.logout-btn:hover { background: rgba(239,68,68,0.15) !important; color: #fca5a5 !important; }
 
/* ── MAIN WRAPPER ─────────────────────────── */
.main-wrapper {
    margin-left: var(--sidebar-width);
    min-height: 100vh;
    transition: margin-left 0.3s ease;
}
.main-wrapper.expanded { margin-left: 70px; }
 
/* ── TOPBAR ───────────────────────────────── */
.topbar {
    position: sticky;
    top: 0;
    height: var(--topbar-height);
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    display: flex;
    align-items: center;
    padding: 0 24px;
    z-index: 999;
    box-shadow: 0 4px 20px rgba(79,70,229,0.3);
}
.sidebar-toggle { background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 8px; padding: 4px 10px; }
.sidebar-toggle:hover { background: rgba(255,255,255,0.25); }
.topbar-breadcrumb { color: rgba(255,255,255,0.75); font-size: 0.85rem; }
.user-avatar {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.2);
    border: 2px solid rgba(255,255,255,0.4);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 0.75rem;
    font-weight: 700;
}
.role-badge {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 3px 10px;
    border-radius: 20px;
}
.role-admin    { background: rgba(239,68,68,0.25);   color: #fca5a5; border: 1px solid rgba(239,68,68,0.5); }
.role-staff    { background: rgba(16,185,129,0.25);  color: #6ee7b7; border: 1px solid rgba(16,185,129,0.5); }
.role-customer { background: rgba(14,165,233,0.25);  color: #7dd3fc; border: 1px solid rgba(14,165,233,0.5); }
 
/* ── PAGE CONTENT ─────────────────────────── */
.page-content { padding: 28px; }
 
/* ── STAT CARDS ───────────────────────────── */
.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
    overflow: hidden;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,0.1); }
.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
}
.stat-card.indigo::before  { background: linear-gradient(90deg, #4f46e5, #818cf8); }
.stat-card.sky::before     { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
.stat-card.emerald::before { background: linear-gradient(90deg, #10b981, #34d399); }
.stat-card.amber::before   { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.stat-card.rose::before    { background: linear-gradient(90deg, #ef4444, #f87171); }
.stat-card.violet::before  { background: linear-gradient(90deg, #7c3aed, #a78bfa); }
 
.stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
}
.stat-icon.indigo  { background: #eef2ff; color: #4f46e5; }
.stat-icon.sky     { background: #e0f2fe; color: #0ea5e9; }
.stat-icon.emerald { background: #d1fae5; color: #10b981; }
.stat-icon.amber   { background: #fef3c7; color: #f59e0b; }
.stat-icon.rose    { background: #fee2e2; color: #ef4444; }
.stat-icon.violet  { background: #ede9fe; color: #7c3aed; }
 
.stat-value { font-size: 2rem; font-weight: 800; color: #0f172a; line-height: 1.1; }
.stat-label { font-size: 0.8rem; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
 
/* ── CONTENT CARDS ────────────────────────── */
.content-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
}
.content-card .card-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: #fff;
    padding: 16px 24px;
    font-weight: 700;
    font-size: 1rem;
    border: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.content-card .card-body { padding: 24px; }
 
/* ── TABLES ───────────────────────────────── */
.table-modern { font-size: 0.875rem; }
.table-modern thead th {
    background: #f8fafc;
    color: #475569;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 16px;
}
.table-modern tbody td { padding: 13px 16px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
.table-modern tbody tr:hover { background: #f8fafc; }
.table-modern tbody tr:last-child td { border-bottom: none; }
 
/* ── STATUS BADGES ────────────────────────── */
.badge-pending   { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.badge-approved  { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
.badge-completed { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.badge-cancelled { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
.badge-active    { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.badge-inactive  { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
.status-badge    { padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
 
/* ── BUTTONS ──────────────────────────────── */
.btn-primary   { background: var(--primary); border-color: var(--primary); font-weight: 600; }
.btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
.btn-gradient  { background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none; color: #fff; font-weight: 600; }
.btn-gradient:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }
.btn-sm { padding: 5px 12px; font-size: 0.8rem; }
 
/* ── FORMS ────────────────────────────────── */
.form-label { font-weight: 600; font-size: 0.85rem; color: #374151; margin-bottom: 6px; }
.form-control, .form-select {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
}
.form-control.is-invalid { border-color: var(--danger); }
 
/* ── AUTH PAGES ───────────────────────────── */
.auth-body {
    background: linear-gradient(135deg, #1a1f36 0%, #2d3561 50%, #1a1f36 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.auth-wrapper { width: 100%; max-width: 440px; padding: 20px; }
.auth-card {
    background: rgba(255,255,255,0.97);
    border-radius: 24px;
    padding: 40px 36px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.3);
}
.auth-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary);
}
.auth-logo i { font-size: 2rem; }
.auth-title { font-size: 1.4rem; font-weight: 800; color: #0f172a; text-align: center; }
.auth-subtitle { color: #64748b; font-size: 0.85rem; text-align: center; }
 
/* ── BOOKING WIZARD ───────────────────────── */
.booking-step {
    background: #fff;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    margin-bottom: 20px;
}
.step-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
.step-number {
    width: 36px; height: 36px;
    background: var(--primary);
    color: #fff;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800;
    font-size: 0.9rem;
    flex-shrink: 0;
}
.step-title { font-weight: 700; font-size: 1rem; color: #0f172a; }
 
.slot-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px; }
.slot-option {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}
.slot-option:hover { border-color: var(--primary); background: #eef2ff; }
.slot-option.selected { border-color: var(--primary); background: #eef2ff; }
.slot-option input[type="radio"] { display: none; }
 
/* ── RESPONSIVE ───────────────────────────── */
@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.mobile-open { transform: translateX(0); }
    .main-wrapper { margin-left: 0 !important; }
    .page-content { padding: 16px; }
    .stat-value { font-size: 1.5rem; }
}
 
/* ── PAGE HEADER ──────────────────────────── */
.page-header {
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.page-title { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; }
.page-title small { font-size: 0.85rem; font-weight: 400; color: #64748b; display: block; }
 
/* ── LOADING SPINNER ──────────────────────── */
.slot-loader { text-align: center; padding: 30px; color: #94a3b8; }
.empty-state { text-align: center; padding: 40px; color: #94a3b8; }
.empty-state i { font-size: 3rem; margin-bottom: 12px; display: block; opacity: 0.4; }
 
/* ── TOASTS ───────────────────────────────── */
.toast-container { z-index: 11000; }
 
/* ── UPCOMING APPOINTMENT CARD ────────────── */
.appt-card {
    background: linear-gradient(135deg, #f0f4ff, #e8edff);
    border: 1px solid #c7d2fe;
    border-radius: 14px;
    padding: 16px 20px;
    margin-bottom: 12px;
    transition: transform 0.15s;
}
.appt-card:hover { transform: translateX(4px); }
.appt-card .appt-time { font-size: 0.8rem; color: #4f46e5; font-weight: 700; }
.appt-card .appt-service { font-weight: 700; font-size: 0.95rem; color: #0f172a; }
.appt-card .appt-provider { font-size: 0.8rem; color: #64748b; }
 
/* ── SERVICE CARD ─────────────────────────── */
.service-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
    height: 100%;
}
.service-card:hover { border-color: var(--primary); box-shadow: 0 4px 20px rgba(79,70,229,0.1); transform: translateY(-2px); }
.service-icon {
    width: 48px; height: 48px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 1.3rem;
    margin-bottom: 14px;
}
.service-duration { font-size: 0.75rem; color: #64748b; }
.service-price { font-size: 1.1rem; font-weight: 800; color: var(--primary); }
    </style>
    @stack('styles')
</head>
<body>
 
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-calendar-check-fill me-2"></i>
        <span>AppointBook</span>
    </div>
 
    <nav class="sidebar-nav mt-3">
        @if(auth()->user()->isAdmin())
            <div class="sidebar-label">Admin Panel</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('services.index') }}" class="sidebar-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap"></i> Services
            </a>
            <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
            <a href="{{ route('admin.appointments') }}" class="sidebar-link {{ request()->routeIs('admin.appointments') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> All Appointments
            </a>
 
        @elseif(auth()->user()->isStaff())
            <div class="sidebar-label">Staff Panel</div>
            <a href="{{ route('staff.dashboard') }}" class="sidebar-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('staff.slots.index') }}" class="sidebar-link {{ request()->routeIs('staff.slots*') ? 'active' : '' }}">
                <i class="bi bi-clock"></i> My Slots
            </a>
            <a href="{{ route('staff.appointments') }}" class="sidebar-link {{ request()->routeIs('staff.appointments') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> My Appointments
            </a>
 
        @elseif(auth()->user()->isCustomer())
            <div class="sidebar-label">Customer Panel</div>
            <a href="{{ route('customer.dashboard') }}" class="sidebar-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('customer.book') }}" class="sidebar-link {{ request()->routeIs('customer.book') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Book Appointment
            </a>
            <a href="{{ route('customer.appointments') }}" class="sidebar-link {{ request()->routeIs('customer.appointments') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> My Appointments
            </a>
        @endif
 
        <div class="sidebar-divider"></div>
        <div class="sidebar-label">Account</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link logout-btn w-100 text-start border-0 bg-transparent">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </nav>
</div>
 
<!-- Main Content -->
<div class="main-wrapper" id="mainWrapper">
    <!-- Topbar -->
    <header class="topbar">
        <button class="btn btn-sm sidebar-toggle me-3" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        <div class="topbar-breadcrumb">
            <span class="text-muted small">@yield('breadcrumb', 'Dashboard')</span>
        </div>
        <div class="topbar-right ms-auto d-flex align-items-center gap-3">
            <div class="role-badge role-{{ auth()->user()->role }}">
                {{ ucfirst(auth()->user()->role) }}
            </div>
            <div class="user-avatar" title="{{ auth()->user()->name }}">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <span class="d-none d-md-inline text-white fw-500">{{ auth()->user()->name }}</span>
        </div>
    </header>
 
    <!-- Page Content -->
    <main class="page-content">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
 
        @yield('content')
    </main>
</div>
 
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Sidebar toggle
    $('#sidebarToggle').on('click', function() {
        $('#sidebar').toggleClass('collapsed');
        $('#mainWrapper').toggleClass('expanded');
    });
 
    // Auto-dismiss alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@stack('scripts')
</body>
</html>   
 