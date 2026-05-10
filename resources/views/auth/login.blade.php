@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<h2 class="auth-title mb-1">Welcome Back</h2>
<p class="auth-subtitle mb-4">Sign in to your AppointBook account</p>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('login.post') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="email">Email Address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror"
               id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
    </div>
    <div class="mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label text-muted small" for="remember">Remember me</label>
        </div>
    </div>
    <button type="submit" class="btn btn-gradient w-100 py-2 mb-3">
        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
    </button>
</form>
<p class="text-center text-muted small mb-3">
    Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold">Create one</a>
</p>
<div class="mt-3 p-3 rounded-3" style="background:#f8fafc;border:1px dashed #c7d2fe;">
    <p class="text-center text-muted small fw-bold mb-2"><i class="bi bi-info-circle me-1"></i> Demo Credentials (password: password)</p>
    <div class="row g-2 text-center">
        <div class="col-4">
            <button class="btn btn-sm w-100" style="background:#fee2e2;color:#991b1b;font-size:0.72rem;" onclick="document.getElementById('email').value='admin@booking.com';document.getElementById('password').value='password'">
                Admin
            </button>
        </div>
        <div class="col-4">
            <button class="btn btn-sm w-100" style="background:#d1fae5;color:#065f46;font-size:0.72rem;" onclick="document.getElementById('email').value='staff@booking.com';document.getElementById('password').value='password'">
                Staff
            </button>
        </div>
        <div class="col-4">
            <button class="btn btn-sm w-100" style="background:#dbeafe;color:#1e40af;font-size:0.72rem;" onclick="document.getElementById('email').value='customer@booking.com';document.getElementById('password').value='password'">
                Customer
            </button>
        </div>
    </div>
</div>
@endsection
