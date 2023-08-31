<?php

namespace App\Http\Controllers;

use App\Mail\AccountVerification;
use App\Models\Login;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Ramsey\Uuid\Type\Integer;

class UserController extends Controller
{
    /**
     * Returns users list view.
     */
    public function index(Request $request) : View {

        $search = $request->input('search');
        $search_option = $request->input('search_option');

        // If search and search option are define, search users.
        if($search && $search_option) {

            if($search_option == 'name') {
                // Search for filtered users by name.
                $users = User::where('active', true)
                    ->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                    ->orderBy('first_name', 'asc')
                    ->get();
            
            } else if($search_option == 'organization') {
                // Search for filtered users by organization.
                $users = User::whereHas('organizations', function ($query) use ($search) {
                    $query->where('business_name', 'like', '%' . $search . '%');
                })->orderBy('first_name', 'asc')->get();
            
            } else if($search_option == 'email') {
                // Search for filtered users by email.
                $users = User::where('active', true)
                    ->where('email', 'like', '%' . $search . '%')
                    ->orderBy('first_name', 'asc')
                    ->get();
            }

        } else {

            $users = User::where('active', true)
                ->orderBy('first_name', 'asc')
                ->get();
        }

        return view('users.index')
            ->with(['users' => $users]);
    }


    /**
     * Return creation view with active organizations.
     */
    public function create() : View {

        $organizations = Organization::where('active', true)
            ->orderBy('business_name', 'asc')
            ->get();

        return view('users.create')
            ->with(['organizations' => $organizations]);
    }


    /**
     * Create a new user and saves it database.
     */
    public function store(Request $request) : RedirectResponse {

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('create', [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['nullable'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s])[^ ]{6,}$/'],
            'password_confirmation' => ['required'],
            'organization' => ['required'],
            'access_level' => ['required'],
        ]);

        $organization = Organization::find($request->input('organization'));

        // If organization not exists or is not active return error.
        if(!$organization->id || $organization->active == false) {

            session()->flash('problem', 'No se puede acceder a la organización');
            return to_route('users.create');
        }

        // Create user.
        $user = User::create([
            'first_name' => mb_convert_case($request->input('first_name'), MB_CASE_TITLE, "UTF-8"),
            'last_name' => mb_convert_case($request->input('last_name'), MB_CASE_TITLE, "UTF-8"),
            'phone_number' => $request->input('phone_number'),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
        ]);

        // Check if the user was created successfully.
        if(!$user->id) {

            session()->flash('problem', 'No se pudo crear el usuario');
            return to_route('users.create');
        }

        $token = Str::random(60);

        // Create the login and link it to the user.
        $login = Login::create([
            'user_id' => $user->id,
            'verification_code' => $token,
            'verification_code_issue_date' => Carbon::now(),
            'verification_code_expiration_date' => Carbon::now()->addMinutes(30),
        ]);

        // Check if the login was created successfully.
        if(!$login->id) {

            session()->flash('problem', 'Error al crear el usuario');
            return to_route('users.create');
        }

        // Send email to account verification.
        Mail::to($user->email)->queue(new AccountVerification($login, $user));

        $user->organizations()->attach($organization->id, ['access_level' => $request->input('access_level')]);

        session()->flash('success', 'Usuario creado correctamente');

        return to_route('users.create');
    }


    /**
     * Return view with user if finds it.
     */
    public function view($id) {

        $user = User::find($id);

        // If the user doesn't exists, it returns an error.
        if(!$user) {

            session()->flash('problem', 'No se encuentra el usuario');
            return to_route('users');
        }

        // Get users for user's list.
        $users = User::where('active', true)
            ->orderBy('first_name', 'asc')
            ->get();

        // Get user organizations.
        $user_organizations = $user->organizations;

        return view('users.view')
            ->with(['user' => $user])
            ->with(['users' => $users])
            ->with(['user_organizations' => $user_organizations]);
    }


    /**
     * Sets the user to inactive so that it is not visible to
     * the user.
     */
    public function delete($id) : RedirectResponse {

        $user = User::find($id);        

        // If the user doesn't exists, it returns an error.
        if(!$user || $user->active == false) {

            session()->flash('problem', 'No se encuentra el usuario seleccionado');
            return to_route('users');
        }

        // Set active field to false.
        $user->active = false;
        $user->save();

        session()->flash('success', 'Usuario eliminado.');

        return to_route('users');
    }
}
