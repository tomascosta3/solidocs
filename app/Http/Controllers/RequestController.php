<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    /**
     * View requests. 
     */
    public function view() : View {

        return view('requests.requests');
    }
}
