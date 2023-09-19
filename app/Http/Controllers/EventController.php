<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Returns all events in json format.
     */
    public function index() {

        $events = Event::all()->where('active', true);
        return response()->json($events);
    }


    /**
     * Add event to calendar.
     */
    public function add_event_to_calendar(Request $request, $calendar_id) {

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('create', [
            'event_type_id' => ['required'],
            'title' => ['required'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'location' => ['nullable'],
            'comment' => ['nullable'],
            'all_day' => ['nullable']
        ]);
        
        // Get calendar, if fails returns error.
        $calendar = Calendar::findOrFail($calendar_id);

        $all_day = true;
        if($request->all_day == null) {
            $all_day = false;
        }

        // Create event and saves it in requested calendar.
        $event = Event::create([
            'calendar_id' => $calendar->id,
            'event_type_id' => $request->event_type_id,
            'title' => $request->title,
            'start' => $request->start_date,
            'end' => $request->end_date,
            'all_day' => $all_day,
            'location' => mb_convert_case($request->location, MB_CASE_TITLE, "UTF-8"),
            'comment' => $request->comment, 
        ]);

        // return response()->json(['status' => 'success']);
        return to_route('calendars.show', ['calendar_id' => $calendar_id])
            ->with('success', 'Evento creado correctamente.');
    }
}
