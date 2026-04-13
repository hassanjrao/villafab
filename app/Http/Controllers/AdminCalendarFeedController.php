<?php

namespace App\Http\Controllers;

use App\Models\CalendarFeed;
use Illuminate\Http\Request;

class AdminCalendarFeedController extends Controller
{
    public function index()
    {
        $feeds = CalendarFeed::orderBy('name')->get();

        return view('admin.calendar-feeds.index', compact('feeds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'ics_url' => 'required|url|max:2048',
        ]);

        CalendarFeed::create([
            'name'      => $request->input('name'),
            'ics_url'   => $request->input('ics_url'),
            'is_active' => true,
        ]);

        return redirect()->route('admin.calendar-feeds.index')
            ->with('success', 'Calendar feed added successfully.');
    }

    public function update(Request $request, CalendarFeed $calendarFeed)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'ics_url'   => 'required|url|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        $calendarFeed->update([
            'name'      => $request->input('name'),
            'ics_url'   => $request->input('ics_url'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.calendar-feeds.index')
            ->with('success', 'Calendar feed updated successfully.');
    }

    public function destroy(CalendarFeed $calendarFeed)
    {
        $calendarFeed->delete();

        return redirect()->route('admin.calendar-feeds.index')
            ->with('success', 'Calendar feed deleted.');
    }
}
