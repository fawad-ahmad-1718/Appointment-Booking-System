<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::withCount('appointments')->latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255|unique:services,title',
            'description' => 'nullable|string|max:1000',
            'duration'    => 'required|integer|min:5|max:480',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title'       => 'required|string|max:255|unique:services,title,' . $service->id,
            'description' => 'nullable|string|max:1000',
            'duration'    => 'required|integer|min:5|max:480',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    public function toggleStatus(Service $service)
    {
        $service->update(['status' => $service->status === 'active' ? 'inactive' : 'active']);
        return response()->json(['status' => $service->status, 'message' => 'Status updated.']);
    }
}
