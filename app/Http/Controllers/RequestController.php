<?php

namespace App\Http\Controllers;

use App\Models\DayUser;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    /**
     * View requests. 
     */
    public function view() : View {

        $day_user = DayUser::where('active', true)
            ->where('user_id', auth()->user()->id)
            ->get();

        return view('requests.requests')
            ->with(['day_user' => $day_user]);
    }
}
