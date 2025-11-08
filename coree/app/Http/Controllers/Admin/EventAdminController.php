<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventAdminController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_date', 'desc')->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|in:bonus_multiplier,special_offers,contest,announcement',
            'banner_color' => 'required|string',
            'bonus_multiplier' => 'nullable|numeric|min:1|max:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'nullable|integer',
            'is_active' => 'boolean',
            'show_banner' => 'boolean',
            'send_notification' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['show_banner'] = $request->has('show_banner');
        $validated['send_notification'] = $request->has('send_notification');

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully!');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|in:bonus_multiplier,special_offers,contest,announcement',
            'banner_color' => 'required|string',
            'bonus_multiplier' => 'nullable|numeric|min:1|max:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'nullable|integer',
            'is_active' => 'boolean',
            'show_banner' => 'boolean',
            'send_notification' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['show_banner'] = $request->has('show_banner');
        $validated['send_notification'] = $request->has('send_notification');

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }
}

