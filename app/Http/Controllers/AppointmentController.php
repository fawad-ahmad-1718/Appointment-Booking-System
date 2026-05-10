<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    // Customer: booking form
    public function book()
    {
        $services = Service::where('status', 'active')->get();
        return view('customer.book', compact('services'));
    }

    // Customer: store new booking
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'slot_id'    => 'required|exists:availability_slots,id',
            'remarks'    => 'nullable|string|max:500',
        ]);

        $slot = AvailabilitySlot::findOrFail($request->slot_id);

        // Prevent double booking
        if ($slot->is_booked) {
            return back()->with('error', 'Sorry, this slot was just booked. Please choose another.');
        }

        DB::transaction(function () use ($request, $slot) {
            $slot->update(['is_booked' => true]);

            Appointment::create([
                'customer_id' => auth()->id(),
                'staff_id'    => $slot->staff_id,
                'service_id'  => $request->service_id,
                'slot_id'     => $slot->id,
                'status'      => 'pending',
                'remarks'     => $request->remarks,
                'booked_at'   => now(),
            ]);
        });

        return redirect()->route('customer.appointments')->with('success', 'Appointment booked successfully! It is pending approval.');
    }

    // Customer: their appointments
    public function customerIndex()
    {
        $appointments = Appointment::with(['service', 'staff', 'slot'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.appointments.index', compact('appointments'));
    }

    // Customer: cancel appointment
    public function cancel(Appointment $appointment)
    {
        if ($appointment->customer_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($appointment->status, ['pending', 'approved'])) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        DB::transaction(function () use ($appointment) {
            $appointment->slot->update(['is_booked' => false]);
            $appointment->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Appointment cancelled successfully.');
    }

    // Staff: view assigned appointments
    public function staffIndex()
    {
        $appointments = Appointment::with(['customer', 'service', 'slot'])
            ->where('staff_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('staff.appointments.index', compact('appointments'));
    }

    // Staff: update appointment status (AJAX + normal)
    public function updateStatus(Request $request, Appointment $appointment)
    {
        if ($appointment->staff_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Status updated successfully.', 'status' => $appointment->status]);
        }

        return back()->with('success', 'Appointment status updated.');
    }

    // Admin: all appointments
    public function adminIndex()
    {
        $appointments = Appointment::with(['customer', 'staff', 'service', 'slot'])
            ->latest()
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }
}
