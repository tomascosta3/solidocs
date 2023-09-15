<?php

namespace App\Http\Controllers;

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
}
