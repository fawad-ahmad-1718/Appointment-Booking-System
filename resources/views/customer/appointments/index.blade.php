@extends('layouts.app')
@section('title', 'My Appointments')
@section('breadcrumb', 'Customer / My Appointments')

@section('content')
<div class="page-header">
    <h1 class="page-title">My Appointments <small>View and manage your bookings</small></h1>
    <a href="{{ route('customer.book') }}" class="btn btn-gradient">
        <i class="bi bi-plus-circle me-2"></i>Book New
    </a>
</div>

<div class="content-card">
    <div class="card-header">
        <span><i class="bi bi-calendar3 me-2"></i>All Bookings ({{ $appointments->total() }})</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Provider</th>
                        <th>Date &amp; Time</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr>
                        <td class="text-muted">#{{ $appt->id }}</td>
                        <td>
                            <div class="fw-600">{{ $appt->service->title ?? '—' }}</div>
                            @if($appt->service)
                            <small class="text-muted">{{ $appt->service->duration }} min</small>
                            @endif
                        </td>
                        <td>{{ $appt->staff->name ?? '—' }}</td>
                        <td>
                            @if($appt->slot)
                                <span class="fw-600">{{ $appt->slot->date->format('M d, Y') }}</span><br>
                                <small class="text-muted">
                                    {{ date('h:i A', strtotime($appt->slot->start_time)) }} –
                                    {{ date('h:i A', strtotime($appt->slot->end_time)) }}
                                </small>
                            @else — @endif
                        </td>
                        <td class="text-muted small" style="max-width:150px;">
                            {{ $appt->remarks ?: '—' }}
                        </td>
                        <td>
                            <span class="status-badge badge-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span>
                        </td>
                        <td>
                            @if(in_array($appt->status, ['pending','approved']))
                            <form method="POST" action="{{ route('customer.appointments.cancel', $appt) }}"
                                  onsubmit="return confirm('Cancel this appointment? This cannot be undone.')">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                </button>
                            </form>
                            @else
                            <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-25"></i>
                            You have no appointments yet.
                            <a href="{{ route('customer.book') }}" class="d-block mt-1">Book your first appointment</a>
                        </td>
                    </tr>
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
