<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'        => User::count(),
            'total_services'     => Service::count(),
            'total_appointments' => Appointment::count(),
            'pending'            => Appointment::where('status', 'pending')->count(),
            'approved'           => Appointment::where('status', 'approved')->count(),
            'completed'          => Appointment::where('status', 'completed')->count(),
            'cancelled'          => Appointment::where('status', 'cancelled')->count(),
            'staff_count'        => User::where('role', 'staff')->count(),
            'customer_count'     => User::where('role', 'customer')->count(),
        ];

        $recent_appointments = Appointment::with(['customer', 'staff', 'service', 'slot'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_appointments'));
    }

    public function users()
    {
        $users = User::orderBy('role')->orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'role'   => 'required|in:admin,staff,customer',
            'phone'  => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($request->only('name', 'email', 'role', 'phone', 'status'));

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
