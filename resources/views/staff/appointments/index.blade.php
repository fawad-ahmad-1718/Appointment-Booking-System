@extends('layouts.app')
@section('title', 'My Appointments')
@section('breadcrumb', 'Staff / Appointments')

@section('content')
<div class="page-header">
    <h1 class="page-title">My Appointments <small>Manage bookings assigned to you</small></h1>
</div>

<div class="content-card">
    <div class="card-header">
        <span><i class="bi bi-calendar-check me-2"></i>Appointments ({{ $appointments->total() }})</span>
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
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr id="row-{{ $appt->id }}">
                        <td class="text-muted">#{{ $appt->id }}</td>
                        <td>
                            <div class="fw-600">{{ $appt->customer->name }}</div>
                            <small class="text-muted">{{ $appt->customer->phone }}</small>
                        </td>
                        <td>{{ $appt->service->title ?? '—' }}</td>
                        <td>
                            @if($appt->slot)
                                {{ $appt->slot->date->format('M d, Y') }}<br>
                                <small class="text-muted">
                                    {{ date('h:i A', strtotime($appt->slot->start_time)) }} –
                                    {{ date('h:i A', strtotime($appt->slot->end_time)) }}
                                </small>
                            @else — @endif
                        </td>
                        <td class="text-muted small" style="max-width:160px;">
                            {{ $appt->remarks ?: '—' }}
                        </td>
                        <td>
                            <span class="status-badge badge-{{ $appt->status }}" id="badge-{{ $appt->id }}">
                                {{ ucfirst($appt->status) }}
                            </span>
                        </td>
                        <td>
                            @if(!in_array($appt->status, ['completed','cancelled']))
                            <div class="d-flex gap-1 flex-wrap">
                                @foreach(['approved','completed','cancelled'] as $st)
                                    @if($st !== $appt->status)
                                    <button class="btn btn-xs update-status-btn"
                                            data-id="{{ $appt->id }}"
                                            data-status="{{ $st }}"
                                            data-url="{{ route('staff.appointments.status', $appt) }}"
                                            style="font-size:0.72rem;padding:2px 8px;border-radius:999px;
                                                   background:{{ $st==='approved'?'#d1fae5':($st==='completed'?'#dbeafe':'#fee2e2') }};
                                                   color:{{ $st==='approved'?'#065f46':($st==='completed'?'#1e40af':'#991b1b') }};
                                                   border:none;">
                                        {{ ucfirst($st) }}
                                    </button>
                                    @endif
                                @endforeach
                            </div>
                            @else
                            <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-25"></i>
                            No appointments assigned to you yet.
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

@push('scripts')
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).on('click', '.update-status-btn', function () {
    const btn    = $(this);
    const id     = btn.data('id');
    const status = btn.data('status');
    const url    = btn.data('url');

    btn.prop('disabled', true).text('...');

    $.ajax({
        url: url,
        type: 'PATCH',
        data: { status: status },
        success: function (res) {
            const badge = $(`#badge-${id}`);
            const classes = { pending:'badge-pending', approved:'badge-approved', completed:'badge-completed', cancelled:'badge-cancelled' };
            badge.attr('class', `status-badge ${classes[status]}`).text(status.charAt(0).toUpperCase() + status.slice(1));

            if (['completed','cancelled'].includes(status)) {
                $(`#row-${id}`).find('.d-flex').html('<span class="text-muted small">—</span>');
            } else {
                btn.remove();
            }
        },
        error: function () {
            btn.prop('disabled', false).text(status.charAt(0).toUpperCase() + status.slice(1));
            alert('Failed to update status. Please try again.');
        }
    });
});
</script>
@endpush
