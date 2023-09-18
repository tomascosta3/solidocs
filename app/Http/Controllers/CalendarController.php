<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\CalendarUser;
use App\Models\EventType;
use App\Models\User;
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

        return view('calendar.index')
            ->with(['calendar' => $calendar])
            ->with(['calendars' => $calendars]);
    }


    /**
     * 
     */
    public function show($calendar_id) {

        $calendar = Calendar::with('events')->findOrFail($calendar_id);
        
        $event_types = EventType::where('active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('calendar.index')
            ->with(['calendar' => $calendar])
            ->with(['event_types' => $event_types]);
    }
}
