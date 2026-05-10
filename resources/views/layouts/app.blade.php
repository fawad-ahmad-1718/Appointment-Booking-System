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
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
</html>
