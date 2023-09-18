<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\CalendarUser;
use App\Models\EventType;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    /**
     * Return calendar view.
     */
    public function index() : View {

        $calendar = null;

        $user = auth()->user();
        $calendars = $user->calendars;

        return view('calendars.index')
            ->with(['calendar' => $calendar])
            ->with(['calendars' => $calendars]);
    }


    /**
     * Show requested calendar as main calendar.
     */
    public function show($calendar_id) {

        $calendar = Calendar::with('events')->findOrFail($calendar_id);
        
        $event_types = EventType::where('active', true)
            ->orderBy('name', 'asc')
            ->get();

        $user = auth()->user();
        $calendars = $user->calendars;

        return view('calendars.index')
            ->with(['calendar' => $calendar])
            ->with(['event_types' => $event_types])
            ->with(['calendars' => $calendars]);
    }


    /**
     * Create new calendar
     */
    public function create(Request $request) : RedirectResponse {

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('create', [
            'name' => ['required']
        ]);

        $user = auth()->user();

        // Create calendar.
        $calendar = Calendar::create([
            'user_id' => $user->id,
            'name' => $request->input('name'),
        ]);

        // Attach new calendar with current user.
        $user->calendars()->attach($calendar->id);

        return to_route('calendars');
    }
}
