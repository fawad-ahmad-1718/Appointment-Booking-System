@extends('layouts.app')
@section('title', 'My Time Slots')
@section('breadcrumb', 'Staff / My Slots')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">My Time Slots <small>Manage your availability</small></h1>
    </div>
    <a href="{{ route('staff.slots.create') }}" class="btn btn-gradient">
        <i class="bi bi-plus-circle me-2"></i>Add Slots
    </a>
</div>

<div class="content-card">
    <div class="card-header">
        <span><i class="bi bi-clock me-2"></i>Time Slots ({{ $slots->total() }})</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Booked?</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slots as $slot)
                    <tr>
                        <td class="text-muted">#{{ $slot->id }}</td>
                        <td class="fw-600">{{ $slot->service->title ?? '—' }}</td>
                        <td>{{ $slot->date->format('M d, Y') }}</td>
                        <td>{{ date('h:i A', strtotime($slot->start_time)) }}</td>
                        <td>{{ date('h:i A', strtotime($slot->end_time)) }}</td>
                        <td>
                            @if($slot->is_booked)
                                <span class="badge bg-danger text-white">Booked</span>
                            @else
                                <span class="badge bg-success text-white">Free</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge badge-{{ $slot->status === 'available' ? 'approved' : 'cancelled' }}">
                                {{ ucfirst($slot->status) }}
                            </span>
                        </td>
                        <td>
                            @if(!$slot->is_booked)
                            <form method="POST" action="{{ route('staff.slots.destroy', $slot) }}"
                                  onsubmit="return confirm('Delete this slot?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @else
                            <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-clock fs-1 d-block mb-2 opacity-25"></i>
                            No slots yet. <a href="{{ route('staff.slots.create') }}">Create your first slot.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($slots->hasPages())
        <div class="p-3">{{ $slots->links() }}</div>
        @endif
    </div>
</div>
@endsection
