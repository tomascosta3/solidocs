<?php

namespace App\Http\Controllers;

use App\Mail\DayRequestApproved;
use App\Mail\DayRequestCreated;
use App\Mail\DayRequestRejected;
use App\Models\Day;
use App\Models\DayRequest;
use App\Models\DayUser;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RequestController extends Controller
{
    /**
     * View requests. 
     */
    public function index() : View {

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
    public function store(Request $request) : RedirectResponse {

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

        $day_user = DayUser::where('user_id', auth()->user()->id)
            ->where('day_id', $day->id)
            ->where('active', true)
            ->first();

        /**
         * Check if the days ordered are less than or equal to the
         * quantity available.
         */
        $allow_request_creation = false;

        if($day_user) {

            if($day_user->days_available == null || $requested_days <= $day_user->days_available) {

                $allow_request_creation = true;
            }
        }

        /**
         * Returns the error when the relationship day_user does not exist
         * or if the user requested more days than he had available.
         */
        if(!$allow_request_creation) {
            session()->flash('problem', 'Error: solicitó más días de los disponibles');
            return to_route('requests');
        }

        $document_id = null;

        // If the day type requires a file, add a validation rule for it.
        if($day->need_file) {

            $validator = Validator::make($request->all(), [
                'file' => ['required', 'file', 'mimes:pdf,png,jpg,doc,docx', 'max:10240'],
            ]);

            // If the validator fails then returns error.
            if($validator->fails()) {
                
                if($validator->errors()->has('file')) {

                    session()->flash('problem', 'El archivo es requerido y sólo acepta archivos PDF, PNG, JPG, DOC y DOCX');
                    return to_route('requests');
                }

            } else {

                // Move file to server and hash its name.
                $file = $request->file('file');
                $hashed_name = $file->hashName();
                $folder_name = 'storage/documents';
                $file->move(public_path($folder_name), $hashed_name);
    
                // Create document.
                $document = Document::create([
                    'name' => 'Certificado: ' . auth()->user()->first_name . ' ' . auth()->user()->last_name . ' ' . Carbon::now()->format('d/m/Y'),
                    'required_access_level' => 6, // Solido Connecting Solutions -> Administration.
                    'comment' => null,
                    'path' => $folder_name . '/' . $hashed_name,
                    'created_by' => auth()->user()->id,
                ]);
    
                // If the file isn't saved then it shows an error.
                if(!$document) {
                    session()->flash('problem', 'Error al cargar el archivo');
                    return to_route('requests');
                }
    
                $document_id = $document->id;
            }
        }

        // Create day request.
        $request = DayRequest::create([
            'requested_by' => auth()->user()->id,
            'day_id' => $day->id,
            'document_id' => $document_id,
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
    
        // User whom email will be sent to.
        $users = User::whereHas('organizations', function ($query) {
            $query->where('business_name', 'Solido Connecting Solutions')
                   ->where('organization_user.access_level', '>=', 6);
        })->get();

        foreach ($users as $user) {
            // Send email.
            Mail::to($user->email)->queue(new DayRequestCreated($user, $request, auth()->user()));
        }

        return to_route('requests');
    }


    /**
     * Return view with request data if finds it.
     */
    public function view($id) {

        $day_request = DayRequest::find($id);

        // If the request doesn't exists, returns an error.
        if(!$day_request) {

            session()->flash('problem', 'No se encuentra la solicitud');
            return to_route('requests');
        }
         
        // Get user-day relationship
        $day_user = DayUser::where('user_id', auth()->user()->id)
            ->where('day_id', $day_request->day->id)
            ->where('active', true)
            ->first();

        /**
         * Calculates the days the user would have if the request
         * is accepted.
         */
        $days_after_approve = null;

        $day_type = $day_request->day;
        $requester_user = $day_request->requester;
        $available_days = $requester_user->days->where('id', $day_type->id)->first()->pivot->days_available;
        $requested_days = $day_request->requested_days;
        $days_after_approve = $available_days - $requested_days;

        return view('requests.view')
            ->with(['day_request' => $day_request])
            ->with(['days_after_approve' => $days_after_approve])
            ->with(['day_user' => $day_user]);
    }


    /**
     * Approve the day_request if exists and is active.
     */
    public function approve($id) : RedirectResponse {

        $day_request = DayRequest::find($id);

        // If the request doesn't exists or is inactive, returns an error.
        if(!$day_request || !$day_request->active) {

            session()->flash('problem', 'No se encuentra la solicitud');
            return to_route('requests.view', ['id' => $id]);
        }

        // Update the day_request's status and updated_by attributes.
        $day_request->update([
            'status' => 'Approved',
            'updated_by' => auth()->user()->id
        ]);

        // Sends emails to day_request's requester.
        Mail::to($day_request->requester->email)->queue(new DayRequestApproved(auth()->user(), $day_request, $day_request->requester));

        session()->flash('success', 'Solicitud aprobada!');

        return to_route('requests.view', ['id' => $id]);
    }


    /**
     * Reject the day_request if exists and is active.
     */
    public function reject($id) : RedirectResponse {

        $day_request = DayRequest::find($id);

        // If the request doesn't exists or is inactive, returns an error.
        if(!$day_request || !$day_request->active) {

            session()->flash('problem', 'No se encuentra la solicitud');
            return to_route('requests.view', ['id' => $id]);
        }

        // Update the day_request's status and updated_by attributes.
        $day_request->update([
            'status' => 'Rejected',
            'updated_by' => auth()->user()->id
        ]);

        // Sends emails to day_request's requester.
        Mail::to($day_request->requester->email)->queue(new DayRequestRejected(auth()->user(), $day_request, $day_request->requester));

        session()->flash('success', 'Solicitud rechazada');

        return to_route('requests.view', ['id' => $id]);
    }
}
