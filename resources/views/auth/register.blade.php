@extends('layouts.auth')
@section('title', 'Register')

@section('content')
<h2 class="auth-title mb-1">Create Account</h2>
<p class="auth-subtitle mb-4">Join AppointBook as a customer</p>

<form method="POST" action="{{ route('register.post') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="name">Full Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror"
               id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="email">Email Address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror"
               id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="phone">Phone Number <span class="text-muted">(optional)</span></label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror"
               id="phone" name="phone" value="{{ old('phone') }}" placeholder="03001234567">
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror"
               id="password" name="password" placeholder="Min 6 characters" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" required>
    </div>
    <button type="submit" class="btn btn-gradient w-100 py-2 mb-3">
        <i class="bi bi-person-plus me-2"></i> Create Account
    </button>
</form>
<p class="text-center text-muted small">
    Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold">Sign in</a>
</p>
@endsection
