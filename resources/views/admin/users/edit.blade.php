@extends('layouts.app')
@section('title', 'Edit User')
@section('breadcrumb', 'Admin / Users / Edit')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit User <small>Update account details</small></h1>
    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="content-card">
            <div class="card-header"><i class="bi bi-person-gear me-2"></i>Edit: {{ $user->name }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                @foreach(['admin','staff','customer'] as $role)
                                    <option value="{{ $role }}" {{ old('role',$user->role)===$role?'selected':'' }}>{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status',$user->status)==='active'?'selected':'' }}>Active</option>
                                <option value="inactive" {{ old('status',$user->status)==='inactive'?'selected':'' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient px-4"><i class="bi bi-check-lg me-2"></i>Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
