<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Event;
use Carbon\Carbon;
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
     * Returns dates array with start-end date event.
     */
    private function event_dates($start_date, $end_date, $days_duration) {
        
        $dates = [];

        for($i = 0; $i < $days_duration; $i++) {
            $current_start = clone $start_date;
            $current_end = clone $end_date;
            $dates[] = [
                'start' => $current_start->modify("+$i day"),
                'end' => $current_end->modify("+$i day"),
            ];
        }

        return $dates;
    }


    /**
     * Add event to calendar.
     */
    public function add_event(Request $request) {

        dd($request);

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('create', [
            'calendar_id' => ['required'],
            'event_type_id' => ['required'],
            'title' => ['required'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'location' => ['nullable'],
            'comment' => ['nullable'],
            'all_day' => ['nullable']
        ]);
        
        // Get calendar, if fails returns error.
        $calendar = Calendar::findOrFail($request->input('calendar_id'));

        $all_day = true;
        if($request->all_day == null) {
            $all_day = false;
        }

        // Repeat option.
        $dates = [];
        $repeat_option = $request->input('repeat_option');
        $repeat_duration_unit = $request->input('repeat_duration_unit');
        $repeat_duration = $request->input('repeat_duration_value');
        $start_date = new \DateTime($request->input('start_date'));
        $end_date = new \DateTime($request->input('end_date'));

        if($repeat_option !== "no-repeat") {

            switch($repeat_option) {

                case 'daily':

                    switch($repeat_duration_unit) {

                        case 'days':

                            $dates = $this->event_dates($start_date, $end_date, $repeat_duration + 1);

                            break;

                        case 'weeks':

                            $dates = $this->event_dates($start_date, $end_date, $repeat_duration * 7);

                            break;

                        case 'months':

                            $start = Carbon::parse($start_date);
                            $repeat_until = $start->copy()->addMonths($repeat_duration);
                            
                            $dates = $this->event_dates($start_date, $end_date, $start->diffInDays($repeat_until));

                            break;
                    }
                    break;

                case 'weekly':
                    $week_days = $request->input('week_days');
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

        return to_route('calendars')
            ->with('success', 'Evento creado correctamente.');
    }
}
