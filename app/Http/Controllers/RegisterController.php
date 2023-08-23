<?php

namespace App\Http\Controllers;

use App\Mail\AccountVerification;
use App\Models\Login;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Returns register view.
     */
    public function view() : View {

        return view('auth.register');
    }

    /**
     * Create a new user.
     */
    public function create(Request $request) : RedirectResponse {

        $created = false;

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('register', [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'dni' => ['required', 'integer'],
            'phone_number' => ['nullable'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s])[^ ]{6,}$/'],
            'password_confirmation' => ['required'],
        ]);

        // Create user.
        $user = User::create(
            [
                'first_name' => mb_convert_case($request->input('first_name'), MB_CASE_TITLE, "UTF-8"),
                'last_name' => mb_convert_case($request->input('last_name'), MB_CASE_TITLE, "UTF-8"),
                'dni' => $request->input('dni'),
                'phone_number' => $request->input('phone_number'),
                'email' => strtolower($request->input('email')),
                'password' => bcrypt($request->input('password')),
            ]
        );

        // Check if the user was created successfully.
        if($user->id) {

            $token = Str::random(60);

            // Create the login and link it to the user.
            $login = Login::create([
                'user_id' => $user->id,
                'verification_code' => $token,
                'verification_code_issue_date' => Carbon::now(),
                'verification_code_expiration_date' => Carbon::now()->addMinutes(30),
            ]);

            // Check if the login was created successfully.
            if($login->id) {

                // Send email to account verification.
                Mail::to($user->email)->queue(new AccountVerification($login, $user));

                $created = true;
            }
        }

        /**
         * Create a flash session variable depending on whether the 
         * user and login were created correctly.
         */
        if($created) {

            session()->flash('success', 'Usuario creado correctamente!');
        } else {

            session()->flash('problem', 'Error al crear el usuario');
        }

        return to_route('auth.login');
    }

    /**
     * Verify account if token is valid.
     * Returns view that shows the result.
     */
    public function verify($token) : View {

        // Get Login that matches token.
        $login = Login::where('verification_code', $token)
            ->first();

        /**
         * If there is no matching login or the token has already expired,
         * it returns the view with an error.
         */
        if(!$login || Carbon::now() > $login->verification_code_expiration_date) {

            return view('auth.verification')->with(['verified' => false]);
        }

        // Mark the user as verified and save the verification date.
        $login->user->verified = true;
        $login->user->verified_at = Carbon::now();
        $login->user->save();

        // Delete token.
        $login->verification_code = null;
        $login->save();

        // Returns view with a sign of success. 
        return view('auth.verification')->with(['verified' => true]);
    }
}
