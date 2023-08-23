<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Shows login view.
     */
    public function view() {

        return view('auth.login');
    }
}
