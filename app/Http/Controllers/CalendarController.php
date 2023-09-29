<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\CalendarUser;
use App\Models\EventType;
use App\Models\Group;
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

        $organizations = $user->organizations;

        $organization = $organizations->first();

        if ($organization) {
            $users_in_organization = $organization->users->where('id', '!=', $user->id);
        } else {
            $users_in_organization = collect();
        }

        // Get events from all calendars with color.
        $all_events = [];
        foreach (auth()->user()->calendars as $calendar) {

            $user_events = $calendar->user_events($user->id);
    
            $all_events[$calendar->id] = $user_events->map(function ($event) use ($calendar) {
                return [
                    'id' => $event->id,
                    'calendar' => [
                        'name' => $event->calendar->name,
                    ],
                    'event_type_id' => $event->event_type_id,
                    'title' => $event->title,
                    'visibility' => $event->visibility,
                    'start' => $event->start,
                    'end' => $event->end,
                    'reminder' => $event->reminder,
                    'reminder_sent' => $event->reminder_sent,
                    'location' => $event->location,
                    'comment' => $event->comment,
                    'all_day' => $event->all_day,
                    'color' => $calendar->group ? $calendar->group->color : null,
                ];
            })->toArray();
        }

        
        // Get event types.
        $event_types = EventType::where('active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('calendars.index')
            ->with(['calendar' => $calendar])
            ->with(['calendars' => $calendars])
            ->with(['event_types' => $event_types])
            ->with(['users_in_organization' => $users_in_organization])
            ->with(['all_events' => $all_events]);
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

        $organizations = $user->organizations;

        $organization = $organizations->first();

        if ($organization) {
            $users_in_organization = $organization->users->where('id', '!=', $user->id);
        } else {
            $users_in_organization = collect();
        }

        // Get events from selected calendars with color.
        $events = collect();
        foreach($calendar->events as $event) {
            if($calendar->group) {
                $event->color = $calendar->group->color;
            }
            $events->push($event);
        }

        return view('calendars.index')
            ->with(['calendar' => $calendar])
            ->with(['event_types' => $event_types])
            ->with(['calendars' => $calendars])
            ->with(['users_in_organization' => $users_in_organization])
            ->with(['all_events' => $events]);
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


    /**
     * Get users from calendar's group.
     * If calendar doesn't have group attached, return
     * associated user.
     */
    public function get_users_from_calendar($calendar_id) {

        $calendar = Calendar::find($calendar_id);

        if(!$calendar) {
            return response()->json(['error' => 'Grupo no encontrado'], 404);
        }

        $group = $calendar->group;

        if (!$group) {
            return response()->json($calendar->users);
        }

        return response()->json($group->users);
    }

}