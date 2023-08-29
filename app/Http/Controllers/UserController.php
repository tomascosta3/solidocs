<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
                    ->get();
            
            } else if($search_option == 'organization') {
                // Search for filtered users by organization.
                $users = User::whereHas('organizations', function ($query) use ($search) {
                    $query->where('business_name', 'like', '%' . $search . '%');
                })->get();
            
            } else if($search_option == 'email') {
                // Search for filtered users by email.
                $users = User::where('active', true)
                    ->where('email', 'like', '%' . $search . '%')
                    ->get();
            }

        } else {

            $users = User::where('active', true)
                ->get();
        }

        return view('users.index')
            ->with(['users' => $users]);
    }
}
