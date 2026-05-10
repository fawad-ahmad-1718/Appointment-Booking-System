@extends('layouts.app')
@section('title', 'Book Appointment')
@section('breadcrumb', 'Customer / Book Appointment')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Book an Appointment <small>Choose a service and time slot</small></h1>
    </div>
    <a href="{{ route('customer.appointments') }}" class="btn btn-light">
        <i class="bi bi-list-ul me-2"></i>My Appointments
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="card-header"><i class="bi bi-calendar-plus me-2"></i>Appointment Details</div>
            <div class="card-body">
                <form method="POST" action="{{ route('customer.book.store') }}" id="bookingForm">
                    @csrf

                    <!-- Step 1: Service -->
                    <div class="mb-3">
                        <label class="form-label fw-600">1. Select Service <span class="text-danger">*</span></label>
                        <select name="service_id" id="serviceSelect" class="form-select @error('service_id') is-invalid @enderror" required>
                            <option value="">— Choose a Service —</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}" data-duration="{{ $service->duration }}" data-price="{{ $service->price }}"
                                    {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->title }} — {{ $service->duration }} min — PKR {{ number_format($service->price,0) }}
                            </option>
                            @endforeach
                        </select>
                        @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <!-- Service info card -->
                        <div id="serviceInfo" class="mt-2 p-3 rounded-3 d-none" style="background:#f0f9ff;border:1px solid #bae6fd;">
                            <small class="text-primary fw-600" id="serviceInfoText"></small>
                        </div>
                    </div>

                    <!-- Step 2: Date -->
                    <div class="mb-3">
                        <label class="form-label fw-600">2. Select Date <span class="text-danger">*</span></label>
                        <input type="date" id="dateInput" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('date') }}">
                        <small class="text-muted">Select a service first, then pick a date.</small>
                    </div>

                    <!-- Step 3: Slot -->
                    <div class="mb-3">
                        <label class="form-label fw-600">3. Select Time Slot <span class="text-danger">*</span></label>
                        <div id="slotsContainer">
                            <div id="slotsPlaceholder" class="text-muted small p-3 rounded-3 border border-dashed text-center">
                                <i class="bi bi-clock me-1"></i> Please select a service and date to see available slots.
                            </div>
                            <div id="slotsLoading" class="text-center py-3 d-none">
                                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                                Loading available slots...
                            </div>
                            <div id="slotsGrid" class="row g-2 d-none"></div>
                            <div id="noSlots" class="text-muted small p-3 rounded-3 border text-center d-none">
                                <i class="bi bi-calendar-x me-1"></i> No available slots for this date. Please try another date.
                            </div>
                        </div>
                        <input type="hidden" name="slot_id" id="slotInput" value="{{ old('slot_id') }}">
                        @error('slot_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <!-- Step 4: Remarks -->
                    <div class="mb-4">
                        <label class="form-label fw-600">4. Remarks (Optional)</label>
                        <textarea name="remarks" rows="3" class="form-control"
                                  placeholder="Any notes or reason for visit...">{{ old('remarks') }}</textarea>
                    </div>

                    <!-- Summary -->
                    <div id="bookingSummary" class="d-none mb-4 p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                        <p class="fw-600 text-success mb-1"><i class="bi bi-check-circle me-2"></i>Booking Summary</p>
                        <div id="summaryText" class="text-muted small"></div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient px-4" id="submitBtn" disabled>
                            <i class="bi bi-calendar-check me-2"></i>Confirm Booking
                        </button>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-light px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedSlot = null;

function loadSlots() {
    const serviceId = $('#serviceSelect').val();
    const date      = $('#dateInput').val();

    if (!serviceId || !date) return;

    $('#slotsPlaceholder').addClass('d-none');
    $('#slotsGrid').addClass('d-none').empty();
    $('#noSlots').addClass('d-none');
    $('#slotsLoading').removeClass('d-none');
    $('#submitBtn').prop('disabled', true);
    selectedSlot = null;
    $('#slotInput').val('');
    $('#bookingSummary').addClass('d-none');

    $.get('{{ route("api.slots") }}', { service_id: serviceId, date: date }, function (res) {
        $('#slotsLoading').addClass('d-none');

        if (res.slots.length === 0) {
            $('#noSlots').removeClass('d-none');
            return;
        }

        $('#slotsGrid').removeClass('d-none');
        res.slots.forEach(function (slot) {
            const btn = $(`
                <div class="col-md-4 col-6">
                    <button type="button" class="btn w-100 slot-btn" data-id="${slot.id}"
                            style="background:#f8fafc;border:2px solid #e2e8f0;border-radius:10px;padding:10px 6px;font-size:0.82rem;">
                        <i class="bi bi-clock me-1 text-primary"></i>
                        <span class="fw-600 d-block">${slot.label.split(' (')[0]}</span>
                        <small class="text-muted">${slot.staff_name}</small>
                    </button>
                </div>`);
            $('#slotsGrid').append(btn);
        });
    }).fail(function () {
        $('#slotsLoading').addClass('d-none');
        $('#noSlots').removeClass('d-none').text('Error loading slots. Please try again.');
    });
}

$(document).on('click', '.slot-btn', function () {
    $('.slot-btn').css({ background: '#f8fafc', borderColor: '#e2e8f0', color: 'inherit' });
    $(this).css({ background: '#ede9fe', borderColor: '#7c3aed', color: '#5b21b6' });

    selectedSlot = $(this).data('id');
    $('#slotInput').val(selectedSlot);
    $('#submitBtn').prop('disabled', false);

    const serviceName = $('#serviceSelect option:selected').text().split(' — ')[0];
    const slotLabel   = $(this).find('.fw-600').text() + ' with ' + $(this).find('small').text();
    $('#summaryText').html(`<b>Service:</b> ${serviceName}<br><b>Slot:</b> ${slotLabel}<br><b>Date:</b> ${$('#dateInput').val()}`);
    $('#bookingSummary').removeClass('d-none');
});

$('#serviceSelect').on('change', function () {
    const opt = $(this).find('option:selected');
    if (opt.val()) {
        $('#serviceInfo').removeClass('d-none');
        $('#serviceInfoText').text(`Duration: ${opt.data('duration')} minutes · Price: PKR ${parseInt(opt.data('price')).toLocaleString()}`);
    } else {
        $('#serviceInfo').addClass('d-none');
    }
    loadSlots();
});

$('#dateInput').on('change', loadSlots);
</script>
@endpush
