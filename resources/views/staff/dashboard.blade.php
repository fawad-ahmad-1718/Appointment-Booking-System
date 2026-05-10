@extends('layouts.app')
@section('title', 'Staff Dashboard')
@section('breadcrumb', 'Staff / Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Staff Dashboard
            <small>Welcome back, {{ auth()->user()->name }}</small>
        </h1>
    </div>
    <a href="{{ route('staff.slots.create') }}" class="btn btn-gradient">
        <i class="bi bi-plus-circle me-2"></i>Add Time Slots
    </a>
</div>

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card indigo">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon indigo"><i class="bi bi-clock-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_slots'] }}</div>
            <div class="stat-label mt-1">Total Slots</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card emerald">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon emerald"><i class="bi bi-check-circle-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['available_slots'] }}</div>
            <div class="stat-label mt-1">Available Slots</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card amber">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon amber"><i class="bi bi-hourglass-split"></i></div>
            </div>
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label mt-1">Pending Bookings</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card sky">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon sky"><i class="bi bi-calendar-check-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total_bookings'] }}</div>
            <div class="stat-label mt-1">Total Bookings</div>
        </div>
    </div>
</div>

<!-- Upcoming Appointments -->
<div class="content-card">
    <div class="card-header">
        <span><i class="bi bi-calendar-week me-2"></i>Upcoming Appointments</span>
        <a href="{{ route('staff.appointments') }}" class="btn btn-sm btn-light">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Date &amp; Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcoming as $appt)
                    <tr>
                        <td class="text-muted">#{{ $appt->id }}</td>
                        <td>
                            <div class="fw-600">{{ $appt->customer->name }}</div>
                            <small class="text-muted">{{ $appt->customer->phone }}</small>
                        </td>
                        <td>{{ $appt->service->title ?? '—' }}</td>
                        <td>
                            @if($appt->slot)
                                {{ $appt->slot->date->format('M d, Y') }}<br>
                                <small class="text-muted">{{ date('h:i A', strtotime($appt->slot->start_time)) }}</small>
                            @else — @endif
                        </td>
                        <td>
                            <span class="status-badge badge-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('staff.appointments') }}" class="btn btn-sm btn-outline-primary">Manage</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-25"></i>
                            No upcoming appointments.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
