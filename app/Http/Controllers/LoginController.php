<?php

namespace App\Http\Controllers;

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

            return to_route('home');
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
}
