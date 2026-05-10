@extends('layouts.app')
@section('title', 'My Dashboard')
@section('breadcrumb', 'Customer / Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">My Dashboard
            <small>Welcome, {{ auth()->user()->name }}</small>
        </h1>
    </div>
    <a href="{{ route('customer.book') }}" class="btn btn-gradient">
        <i class="bi bi-plus-circle me-2"></i>Book Appointment
    </a>
</div>

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card indigo">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon indigo"><i class="bi bi-calendar3"></i></div>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label mt-1">Total Bookings</div>
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
    <div class="col-xl-3 col-md-6">
        <div class="stat-card emerald">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon emerald"><i class="bi bi-check-circle-fill"></i></div>
            </div>
            <div class="stat-value">{{ $stats['completed'] }}</div>
            <div class="stat-label mt-1">Completed</div>
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

<div class="row g-4">
    <!-- Upcoming appointments -->
    <div class="col-lg-7">
        <div class="content-card h-100">
            <div class="card-header">
                <span><i class="bi bi-calendar-week me-2"></i>Upcoming Appointments</span>
                <a href="{{ route('customer.appointments') }}" class="btn btn-sm btn-light">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr><th>Service</th><th>Provider</th><th>Date &amp; Time</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($upcoming as $appt)
                            <tr>
                                <td class="fw-600">{{ $appt->service->title ?? '—' }}</td>
                                <td>{{ $appt->staff->name ?? '—' }}</td>
                                <td>
                                    @if($appt->slot)
                                        {{ $appt->slot->date->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ date('h:i A', strtotime($appt->slot->start_time)) }}</small>
                                    @else — @endif
                                </td>
                                <td><span class="status-badge badge-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    No upcoming appointments. <a href="{{ route('customer.book') }}">Book one now!</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Available services -->
    <div class="col-lg-5">
        <div class="content-card h-100">
            <div class="card-header">
                <span><i class="bi bi-grid-3x3-gap me-2"></i>Available Services</span>
                <a href="{{ route('customer.book') }}" class="btn btn-sm btn-gradient">Book</a>
            </div>
            <div class="card-body">
                @forelse($services as $service)
                <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:40px;height:40px;background:linear-gradient(135deg,#4f46e5,#0ea5e9);color:#fff;">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-600">{{ $service->title }}</div>
                        <small class="text-muted">{{ $service->duration }} min &bull; PKR {{ number_format($service->price, 0) }}</small>
                    </div>
                    <a href="{{ route('customer.book') }}" class="btn btn-xs btn-outline-primary"
                       style="font-size:0.75rem;padding:3px 10px;">Book</a>
                </div>
                @empty
                <p class="text-muted text-center py-3">No services available right now.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
