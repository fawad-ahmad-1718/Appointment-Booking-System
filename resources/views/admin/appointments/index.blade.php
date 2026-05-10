@extends('layouts.app')
@section('title', 'All Appointments')
@section('breadcrumb', 'Admin / Appointments')

@section('content')
<div class="page-header">
    <h1 class="page-title">All Appointments <small>System-wide booking records</small></h1>
</div>
<div class="content-card">
    <div class="card-header"><i class="bi bi-calendar3 me-2"></i>Appointments ({{ $appointments->total() }})</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr><th>#</th><th>Customer</th><th>Service</th><th>Staff</th><th>Date / Time</th><th>Status</th><th>Booked At</th></tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr>
                        <td class="text-muted">#{{ $appt->id }}</td>
                        <td>
                            <div class="fw-600">{{ $appt->customer->name }}</div>
                            <small class="text-muted">{{ $appt->customer->email }}</small>
                        </td>
                        <td>{{ $appt->service->title ?? '—' }}</td>
                        <td>{{ $appt->staff->name ?? '—' }}</td>
                        <td>
                            @if($appt->slot)
                                {{ $appt->slot->date->format('M d, Y') }}<br>
                                <small class="text-muted">{{ date('h:i A', strtotime($appt->slot->start_time)) }}</small>
                            @else — @endif
                        </td>
                        <td><span class="status-badge badge-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span></td>
                        <td class="text-muted small">{{ $appt->booked_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No appointments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appointments->hasPages())
        <div class="p-3">{{ $appointments->links() }}</div>
        @endif
    </div>
</div>
@endsection
