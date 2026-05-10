<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AvailabilitySlot;

class StaffController extends Controller
{
    public function dashboard()
    {
        $staffId = auth()->id();

        $stats = [
            'total_slots'    => AvailabilitySlot::where('staff_id', $staffId)->count(),
            'available_slots'=> AvailabilitySlot::where('staff_id', $staffId)->where('is_booked', false)->where('status', 'available')->count(),
            'total_bookings' => Appointment::where('staff_id', $staffId)->count(),
            'pending'        => Appointment::where('staff_id', $staffId)->where('status', 'pending')->count(),
            'approved'       => Appointment::where('staff_id', $staffId)->where('status', 'approved')->count(),
            'completed'      => Appointment::where('staff_id', $staffId)->where('status', 'completed')->count(),
        ];

        $upcoming = Appointment::with(['customer', 'service', 'slot'])
    ->join('availability_slots', 'appointments.slot_id', '=', 'availability_slots.id')
    ->where('appointments.staff_id', $staffId)
    ->whereIn('appointments.status', ['pending', 'approved'])
    ->where('availability_slots.date', '>=', now()->format('Y-m-d'))
    ->orderBy('availability_slots.date')
    ->orderBy('availability_slots.start_time')
    ->select('appointments.*')
    ->take(5)
    ->get();

        return view('staff.dashboard', compact('stats', 'upcoming'));
    }
}
