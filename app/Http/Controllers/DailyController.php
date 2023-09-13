<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DailyController extends Controller
{
    /**
     * Returns dailys index view.
     */
    public function index() {

        return view('dailys.index');
    }
}
