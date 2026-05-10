@extends('layouts.app')
@section('title', 'Services')
@section('breadcrumb', 'Admin / Services')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Services <small>Manage all available services</small></h1>
    </div>
    <a href="{{ route('services.create') }}" class="btn btn-gradient">
        <i class="bi bi-plus-circle me-2"></i>Add Service
    </a>
</div>

<div class="content-card">
    <div class="card-header">
        <span><i class="bi bi-grid-3x3-gap me-2"></i>All Services ({{ $services->total() }})</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Bookings</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td class="text-muted">#{{ $service->id }}</td>
                        <td class="fw-600">{{ $service->title }}</td>
                        <td class="text-muted small" style="max-width:220px;">
                            {{ Str::limit($service->description, 70) }}
                        </td>
                        <td><i class="bi bi-clock me-1 text-primary"></i>{{ $service->duration }} min</td>
                        <td>PKR {{ number_format($service->price, 0) }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $service->appointments_count }}</span>
                        </td>
                        <td>
                            <span class="status-badge badge-{{ $service->status === 'active' ? 'approved' : 'cancelled' }}">
                                {{ ucfirst($service->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-secondary toggle-status-btn"
                                        data-id="{{ $service->id }}"
                                        data-status="{{ $service->status }}"
                                        title="{{ $service->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                    <i class="bi bi-toggle-{{ $service->status === 'active' ? 'on text-success' : 'off text-secondary' }}"></i>
                                </button>
                                <form method="POST" action="{{ route('services.destroy', $service) }}"
                                      onsubmit="return confirm('Delete this service? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-grid-3x3-gap fs-1 d-block mb-2 opacity-25"></i>
                            No services yet. <a href="{{ route('services.create') }}">Add the first one.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($services->hasPages())
        <div class="p-3">{{ $services->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.toggle-status-btn', function () {
    const btn = $(this);
    const id  = btn.data('id');
    $.post(`/services/${id}/toggle`, { _token: '{{ csrf_token() }}' }, function (res) {
        const isActive = res.status === 'active';
        btn.find('i').attr('class', `bi bi-toggle-${isActive ? 'on text-success' : 'off text-secondary'}`);
        btn.data('status', res.status);
        btn.closest('tr').find('.status-badge')
            .attr('class', `status-badge badge-${isActive ? 'approved' : 'cancelled'}`)
            .text(isActive ? 'Active' : 'Inactive');
    });
});
</script>
@endpush
