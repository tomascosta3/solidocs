<?php

namespace App\Http\Controllers;

use App\Mail\DayRequestCreated;
use App\Models\Day;
use App\Models\DayRequest;
use App\Models\DayUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

        $day_requests = DayRequest::where('active', true)
            ->where('requested_by', auth()->user()->id)
            ->get();

        $days = Day::where('active', true)
            ->get();

        return view('requests.requests')
            ->with(['day_user' => $day_user])
            ->with(['day_requests' => $day_requests])
            ->with(['days' => $days]);
    }


    /**
     * Create a new request and saves it in the database.
     */
    public function store(Request $request) {

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         * 'start_date' must be before 'end_date'. 
         */
        $validated = $request->validateWithBag('create', [
            'option_request' => ['required', 'string'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date']
        ]);

        $day = Day::where('type', $request->input('option_request'))
            ->where('active', true)
            ->first();

        // If day doesn't exists returns error.
        if(!$day) {
            session()->flash('problem', 'Error al crear la solicitud');
            return to_route('requests');
        }

        // Calculates the number of days based on the start date and the end date.
        $start_date = Carbon::parse($request->input('start_date'))->startOfDay();
        $end_date = Carbon::parse($request->input('end_date'))->startOfDay();
        $requested_days = $start_date->diffInDays($end_date) + 1;

        // Create day request.
        $request = DayRequest::create([
            'requested_by' => auth()->user()->id,
            'day_id' => $day->id,
            'requested_days' => $requested_days,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date')
        ]);

        /**
         * If day request was created successfully returns success message,
         * else returns error message.
         */
        if($request && $request->id) {
            session()->flash('success', 'Solicitud creada correctamente');
        } else {
            session()->flash('problem', 'Error al crear la solicitud');
        }
    
        // Send emails here.
        $users = User::whereHas('organizations', function ($query) {
            $query->where('business_name', 'Solido Connecting Solutions')
                   ->where('organization_user.access_level', '>=', 6);
        })->get();

        foreach ($users as $user) {

            Mail::to($user->email)->send(new DayRequestCreated($user, $request, auth()->user()));
        }

        return to_route('requests');
    }
}
