<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Returns view with groups list.
     */
    public function index() : View {

        $groups = Group::where('active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('users.groups.index')
            ->with(['groups' => $groups]);
    }


    /**
     * Returns group creation view.
     */
    public function create() {

        $current_organization = auth()->user()->organization();

        if(!$current_organization) {

            session()->flash('problem', 'No se encontró la organización,');
            
            return to_route('users.groups');
        }

        $organization_id = $current_organization->id;

        $users = User::whereHas('organizations', function($query) use ($organization_id) {
            $query->where('organizations.id', $organization_id);
        })->where('active', true)->get();

        $half = ceil($users->count() / 2);

        $firstColumnUsers = $users->take($half);
        $secondColumnUsers = $users->slice($half);

        return view('users.groups.create')
            ->with(['users' => $users])
            ->with(['firstColumnUsers' => $firstColumnUsers])
            ->with(['secondColumnUsers' => $secondColumnUsers]);
    }


    /**
     * Create a new group and saves it in database.
     */
    public function store(Request $request) {

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('create', [
            'name' => ['required'],
            'users' => ['required'],
        ]);

        // Create user's group.
        $group = Group::create([
            'name' => mb_convert_case($request->input('name'), MB_CASE_TITLE, "UTF-8"),
        ]);

        // Link users with group.
        $user_ids = $request->input('users');
        $group->users()->attach($user_ids);

        return to_route('users.groups');
    }


    /**
     * Return group view.
     */
    public function view($id) {

        $group = Group::where('id', $id)
            ->where('active', true)
            ->first();

        if(!$group) {
            session()->flash('problem', 'No se encontró el grupo');
            return to_route('users.groups');
        }

        $group_users = $group->users();

        return view('users.groups.view')
            ->with(['group' => $group])
            ->with(['group_users' => $group_users]);
    }
}
