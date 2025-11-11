<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendEventReminderJob;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Event::create($request->all());
        return redirect()->route('events.index')->with('success', 'Event Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::find($id);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'reminder_time' => 'required|integer|min:0',
            'meeting_link' => 'required|string',
            'event_price' => 'nullable|numeric|min:0',
        ]);

        $event = Event::findOrFail($id);
        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'reminder_time' => $request->reminder_time,
            'meeting_link' => $request->meeting_link,
            'event_price' => $request->event_price,
        ]);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found.');
        }
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully!'
        ]);
    }
}
