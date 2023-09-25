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

        // Repeat option.
        $dates = [];
        $repeat_option = $request->input('repeat_option');
        $repeat_duration = $request->input('repeat_duration_value');
        $start_date = new \DateTime($request->input('start_date'));
        $end_date = new \DateTime($request->input('end_date'));

        if($repeat_option !== "no-repeat") {

            switch($repeat_option) {
                case 'daily':
                    for($i = 0; $i < $repeat_duration + 1; $i++) {
                        $current_start = clone $start_date;
                        $current_end = clone $end_date;
                        $dates[] = [
                            'start' => $current_start->modify("+$i day"),
                            'end' => $current_end->modify("+$i day"),
                        ];
                    }
                    break;
                case 'weekly':
                    $week_days = $request->inpdwut('week_days');
                    break;
                case 'custom':
                    break;
                default:
                $dates[] = $start_date;
            }

            foreach ($dates as $date) {

                // Create repetition events and saves them in requested calendar.
                $event = Event::create([
                    'calendar_id' => $calendar->id,
                    'event_type_id' => $request->event_type_id,
                    'title' => $request->title,
                    'start' => $date['start'],
                    'end' => $date['end'],
                    'all_day' => $all_day,
                    'location' => mb_convert_case($request->location, MB_CASE_TITLE, "UTF-8"),
                    'comment' => $request->comment, 
                ]);
            }
        } else {

            // Create no repetition event and saves it in requested calendar.
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
        }

        return to_route('calendars.show', ['calendar_id' => $calendar_id])
            ->with('success', 'Evento creado correctamente.');
    }
}
