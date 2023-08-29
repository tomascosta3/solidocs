<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Shows login view.
     */
    public function view() : View {

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request) : RedirectResponse{

        // Validate the incoming request data.
        $credentials = $request->validateWithBag('login', [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Attempt to authenticate the user using the provided credentials.
        if(Auth::Attempt($credentials, false)) {

            // Regenerate the session.
            $request->session()->regenerate();

            $user = Auth::user();
            
            if($user->organization_count() == 1) {
                
                $organization = $user->organization();
                session(['organization_id' => $organization->id]);

                return to_route('home')->with(['organization' => $organization]);

            } else if($user->organization_count() > 1){
                //If user belongs to many organizations.

            } else {
                // If user doesn't belong to any organization.
                return to_route('home');
            }

        }

        /**
         * If authentication failed, invalidate the session and regenerate 
         * the CSRF token.
         */
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('problem', 'Error al iniciar sesión, correo o contraseña incorrecta');

        // Redirect back to the login page with the error message.
        return to_route('auth.login');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request) : RedirectResponse {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('auth.login');
    }
}
