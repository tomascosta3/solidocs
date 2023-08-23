<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Shows login view.
     */
    public function view() : View {

        return view('auth.login');
    }
}
