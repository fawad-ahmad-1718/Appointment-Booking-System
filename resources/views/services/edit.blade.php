@extends('layouts.app')
@section('title', 'Edit Service')
@section('breadcrumb', 'Admin / Services / Edit')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Service <small>{{ $service->title }}</small></h1>
    </div>
    <a href="{{ route('services.index') }}" class="btn btn-light">
        <i class="bi bi-arrow-left me-2"></i>Back to Services
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="content-card">
            <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit Service Details</div>
            <div class="card-body">
                <form method="POST" action="{{ route('services.update', $service) }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-600">Service Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $service->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Description</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $service->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Duration (minutes) <span class="text-danger">*</span></label>
                            <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror"
                                   value="{{ old('duration', $service->duration) }}" min="5" max="480" required>
                            @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Price (PKR) <span class="text-danger">*</span></label>
                            <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $service->price) }}" min="0" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-600">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active"   {{ old('status',$service->status)==='active'   ? 'selected':'' }}>Active</option>
                            <option value="inactive" {{ old('status',$service->status)==='inactive' ? 'selected':'' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient px-4">
                            <i class="bi bi-check-circle me-2"></i>Update Service
                        </button>
                        <a href="{{ route('services.index') }}" class="btn btn-light px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
