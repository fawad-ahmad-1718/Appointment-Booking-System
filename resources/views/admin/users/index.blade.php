@extends('layouts.app')
@section('title', 'Manage Users')
@section('breadcrumb', 'Admin / Users')

@section('content')
<div class="page-header">
    <h1 class="page-title">Manage Users <small>All registered accounts</small></h1>
</div>

<div class="content-card">
    <div class="card-header">
        <span><i class="bi bi-people me-2"></i>Users ({{ $users->total() }})</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Joined</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted">{{ $user->id }}</td>
                        <td class="fw-600">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td><span class="status-badge role-{{ $user->role }}" style="padding:3px 10px;border-radius:20px;font-size:0.7rem;font-weight:700;">{{ ucfirst($user->role) }}</span></td>
                        <td><span class="status-badge badge-{{ $user->status }}">{{ ucfirst($user->status) }}</span></td>
                        <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="p-3">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection
