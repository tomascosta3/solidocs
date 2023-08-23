<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Returns home view.
     */
    public function index() : View {

        return view('home.home');
    }
}
