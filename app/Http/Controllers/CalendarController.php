<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    /**
     * Return calendar view.
     */
    public function index() : View {

        return view('calendar.index');
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
