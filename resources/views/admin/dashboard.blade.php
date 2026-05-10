@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('breadcrumb', 'Admin / Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Admin Dashboard
            <small>System overview and statistics</small>
        </h1>
    </div>
    <a href="{{ route('services.create') }}" class="btn btn-gradient">
        <i class="bi bi-plus-circle me-2"></i>Add Service
    </a>
</div>

<!-- Stats Row 1 -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card indigo">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon indigo"><i class="bi bi-people-fill"></i></div>
                <span class="badge bg-indigo text-white" style="background:#4f46e5">All</span>
            </div>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-label mt-1">Total Users</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card sky">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon sky"><i class="bi bi-grid-3x3-gap-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_services'] }}</div>
            <div class="stat-label mt-1">Services</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card emerald">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon emerald"><i class="bi bi-calendar-check-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_appointments'] }}</div>
            <div class="stat-label mt-1">Total Appointments</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card amber">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon amber"><i class="bi bi-hourglass-split"></i></div>
            </div>
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label mt-1">Pending</div>
        </div>
    </div>
</div>

<!-- Stats Row 2 -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card violet">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon violet"><i class="bi bi-check-circle-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['approved'] }}</div>
            <div class="stat-label mt-1">Approved</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card emerald">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon emerald"><i class="bi bi-trophy-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['completed'] }}</div>
            <div class="stat-label mt-1">Completed</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card sky">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon sky"><i class="bi bi-person-badge-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['staff_count'] }}</div>
            <div class="stat-label mt-1">Staff Members</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card rose">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon rose"><i class="bi bi-x-circle-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['cancelled'] }}</div>
            <div class="stat-label mt-1">Cancelled</div>
        </div>
    </div>
</div>

<!-- Recent Appointments -->
<div class="content-card">
    <div class="card-header">
        <span><i class="bi bi-clock-history me-2"></i>Recent Appointments</span>
        <a href="{{ route('admin.appointments') }}" class="btn btn-sm btn-light">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Staff</th>
                        <th>Date / Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_appointments as $appt)
                    <tr>
                        <td class="text-muted">#{{ $appt->id }}</td>
                        <td>
                            <div class="fw-600">{{ $appt->customer->name }}</div>
                            <small class="text-muted">{{ $appt->customer->email }}</small>
                        </td>
                        <td>{{ $appt->service->title ?? '-' }}</td>
                        <td>{{ $appt->staff->name ?? '-' }}</td>
                        <td>
                            @if($appt->slot)
                                {{ $appt->slot->date->format('M d, Y') }}<br>
                                <small class="text-muted">{{ date('h:i A', strtotime($appt->slot->start_time)) }}</small>
                            @else — @endif
                        </td>
                        <td>
                            <span class="status-badge badge-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No appointments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
