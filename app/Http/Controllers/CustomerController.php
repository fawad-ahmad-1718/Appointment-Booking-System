<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customerId = auth()->id();

        $stats = [
            'total'     => Appointment::where('customer_id', $customerId)->count(),
            'pending'   => Appointment::where('customer_id', $customerId)->where('status', 'pending')->count(),
            'approved'  => Appointment::where('customer_id', $customerId)->where('status', 'approved')->count(),
            'completed' => Appointment::where('customer_id', $customerId)->where('status', 'completed')->count(),
            'cancelled' => Appointment::where('customer_id', $customerId)->where('status', 'cancelled')->count(),
        ];

        $upcoming = Appointment::with(['service', 'staff', 'slot'])
            ->where('customer_id', $customerId)
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->take(3)
            ->get();

        $services = Service::where('status', 'active')->take(6)->get();

        return view('customer.dashboard', compact('stats', 'upcoming', 'services'));
    }
}
