<?php

namespace App\Http\Controllers;

use App\Models\AvailabilitySlot;
use App\Models\Service;
use Illuminate\Http\Request;

class AvailabilitySlotController extends Controller
{
    public function index()
    {
        $slots = AvailabilitySlot::with(['service'])
            ->where('staff_id', auth()->id())
            ->orderBy('date')
            ->orderBy('start_time')
            ->paginate(20);

        $services = Service::where('status', 'active')->get();

        return view('staff.slots.index', compact('slots', 'services'));
    }

    public function create()
    {
        $services = Service::where('status', 'active')->get();
        return view('staff.slots.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date'       => 'required|date|after_or_equal:today',
            'slots'      => 'required|array|min:1',
            'slots.*.start_time' => 'required|date_format:H:i',
            'slots.*.end_time'   => 'required|date_format:H:i|after:slots.*.start_time',
        ]);

        $created = 0;
        $skipped = 0;

        foreach ($request->slots as $slotData) {
            $exists = AvailabilitySlot::where([
                'staff_id'   => auth()->id(),
                'service_id' => $request->service_id,
                'date'       => $request->date,
                'start_time' => $slotData['start_time'],
            ])->exists();

            if (!$exists) {
                AvailabilitySlot::create([
                    'staff_id'   => auth()->id(),
                    'service_id' => $request->service_id,
                    'date'       => $request->date,
                    'start_time' => $slotData['start_time'],
                    'end_time'   => $slotData['end_time'],
                    'is_booked'  => false,
                    'status'     => 'available',
                ]);
                $created++;
            } else {
                $skipped++;
            }
        }

        $msg = "$created slot(s) created.";
        if ($skipped > 0) $msg .= " $skipped slot(s) already exist and were skipped.";

        return redirect()->route('staff.slots.index')->with('success', $msg);
    }

    public function destroy(AvailabilitySlot $slot)
    {
        if ($slot->staff_id !== auth()->id()) {
            abort(403);
        }

        if ($slot->is_booked) {
            return back()->with('error', 'Cannot delete a booked slot.');
        }

        $slot->delete();

        return back()->with('success', 'Slot deleted successfully.');
    }

    // AJAX: Get available slots for a service + date
    public function getSlots(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date'       => 'required|date',
        ]);

        $slots = AvailabilitySlot::with('staff')
            ->where('service_id', $request->service_id)
            ->where('date', $request->date)
            ->where('is_booked', false)
            ->where('status', 'available')
            ->where('date', '>=', now()->format('Y-m-d'))
            ->orderBy('start_time')
            ->get()
            ->map(fn($slot) => [
                'id'         => $slot->id,
                'start_time' => $slot->start_time,
                'end_time'   => $slot->end_time,
                'staff_name' => $slot->staff->name,
                'staff_id'   => $slot->staff_id,
                'label'      => date('h:i A', strtotime($slot->start_time)) . ' - ' . date('h:i A', strtotime($slot->end_time)) . ' (Dr. ' . $slot->staff->name . ')',
            ]);

        return response()->json(['slots' => $slots]);
    }
}
