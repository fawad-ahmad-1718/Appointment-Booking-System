@extends('layouts.app')
@section('title', 'Add Time Slots')
@section('breadcrumb', 'Staff / Slots / Create')
 
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Add Time Slots <small>Define your availability</small></h1>
    </div>
    <a href="{{ route('staff.slots.index') }}" class="btn btn-light">
        <i class="bi bi-arrow-left me-2"></i>Back to Slots
    </a>
</div>
 
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="card-header"><i class="bi bi-clock-fill me-2"></i>Slot Details</div>
            <div class="card-body">
                <form method="POST" action="{{ route('staff.slots.store') }}" id="slotForm">
                    @csrf
 
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Service <span class="text-danger">*</span></label>
                            <select name="service_id" class="form-select @error('service_id') is-invalid @enderror" required>
                                <option value="">— Select Service —</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->title }} ({{ $service->duration }} min)
                                </option>
                                @endforeach
                            </select>
                            @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                   value="{{ old('date') }}" min="{{ date('Y-m-d') }}" required>
                            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
 
                    <!-- Dynamic Slot Rows -->
                    <div class="mb-3">
                        <label class="form-label fw-600">Time Slots <span class="text-danger">*</span></label>
                        <div id="slotsContainer">
                            <div class="slot-row row g-2 mb-2 align-items-center">
                                <div class="col-5">
                                    <input type="time" name="slots[0][start_time]" class="form-control" placeholder="Start" required>
                                </div>
                                <div class="col-5">
                                    <input type="time" name="slots[0][end_time]" class="form-control" placeholder="End" required>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-slot" disabled>
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="addSlotBtn" class="btn btn-sm btn-outline-primary mt-1">
                            <i class="bi bi-plus me-1"></i>Add Another Slot
                        </button>
                    </div>
 
                    <!-- Quick Fill Presets -->
                    <div class="mb-3">
                        <label class="form-label">Quick Fill Presets</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    id="preset-morning">
                                Morning (9–11)
                            </button>
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    id="preset-afternoon">
                                Afternoon (2–4)
                            </button>
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    id="preset-fullday">
                                Full Day
                            </button>
                        </div>
                    </div>
 
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient px-4">
                            <i class="bi bi-check-circle me-2"></i>Save Slots
                        </button>
                        <a href="{{ route('staff.slots.index') }}" class="btn btn-light px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
 
@push('scripts')
<script>
let slotCount = 1;
 
function buildRow(index, start, end) {
    return `
    <div class="slot-row row g-2 mb-2 align-items-center">
        <div class="col-5">
            <input type="time" name="slots[${index}][start_time]" class="form-control" value="${start || ''}" required>
        </div>
        <div class="col-5">
            <input type="time" name="slots[${index}][end_time]" class="form-control" value="${end || ''}" required>
        </div>
        <div class="col-2">
            <button type="button" class="btn btn-outline-danger btn-sm remove-slot">
                <i class="bi bi-x"></i>
            </button>
        </div>
    </div>`;
}
 
function applyPreset(slots) {
    $('#slotsContainer').empty();
    slotCount = 0;
    slots.forEach(function(s) {
        $('#slotsContainer').append(buildRow(slotCount++, s[0], s[1]));
    });
    updateRemoveButtons();
}
 
function updateRemoveButtons() {
    var rows = $('.slot-row');
    rows.find('.remove-slot').prop('disabled', rows.length === 1);
}
 
$(document).ready(function () {
 
    // Add slot button
    $('#addSlotBtn').on('click', function () {
        $('#slotsContainer').append(buildRow(slotCount++));
        updateRemoveButtons();
    });
 
    // Remove slot button
    $(document).on('click', '.remove-slot', function () {
        $(this).closest('.slot-row').remove();
        updateRemoveButtons();
    });
 
    // Preset - Morning
    $('#preset-morning').on('click', function () {
        applyPreset([
            ['09:00', '09:30'],
            ['09:30', '10:00'],
            ['10:00', '10:30'],
            ['10:30', '11:00']
        ]);
    });
 
    // Preset - Afternoon
    $('#preset-afternoon').on('click', function () {
        applyPreset([
            ['14:00', '14:30'],
            ['14:30', '15:00'],
            ['15:00', '15:30'],
            ['15:30', '16:00']
        ]);
    });
 
    // Preset - Full Day
    $('#preset-fullday').on('click', function () {
        applyPreset([
            ['09:00', '09:30'],
            ['09:30', '10:00'],
            ['10:00', '10:30'],
            ['10:30', '11:00'],
            ['14:00', '14:30'],
            ['14:30', '15:00'],
            ['15:00', '15:30'],
            ['15:30', '16:00']
        ]);
    });
 
});
</script>
@endpush