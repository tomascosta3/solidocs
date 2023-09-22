<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
            'roles' => ['required'],
        ]);

        // Create user's group.
        $group = Group::create([
            'name' => mb_convert_case($request->input('name'), MB_CASE_TITLE, "UTF-8"),
        ]);

        // Get users list.
        $user_ids = $request->input('users');

        // Get roles list.
        $roles = $request->input('roles');

        // Prepare data for attach.
        $user_data = [];
        foreach($user_ids as $user_id) {
            $user_data[$user_id] = ['role' => $roles[$user_id]];
        }

        // Link users with group with their roles.
        $group->users()->attach($user_data);

        // Create new calendar.
        $calendar = Calendar::create([
            'user_id' => auth()->user()->id,
            'group_id' => $group->id,
            'name' => $group->name,
        ]);

        // Attach group users with calendar.
        foreach ($group->users()->get() as $user) {
            $user->calendars()->attach($calendar);
        }

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

        $group_users = $group->users()->get();

        $organization_users = auth()->user()->organization()->users()->get();

        $users_not_in_group = $organization_users->diff($group_users);

        $half = ceil($users_not_in_group->count() / 2);

        $first_column_users = $users_not_in_group->take($half);
        $second_column_users = $users_not_in_group->splice($half);

        return view('users.groups.view')
            ->with(['group' => $group])
            ->with(['group_users' => $group_users])
            ->with(['first_column_users' => $first_column_users])
            ->with(['second_column_users' => $second_column_users]);
    }


    /**
     * Remove user from the group.
     */
    public function remove_user($group_id, $user_id) : RedirectResponse {

        $group = Group::find($group_id);

        if($group) {

            // Detach user from group.
            $group->users()->detach($user_id);

            // Detach user from group's calendar.
            $calendar = $group->calendar;
            $calendar->users()->detach($user_id);

            session()->flash('success', 'Usuario desvinculado con éxito');
        } else {
            session()->flash('problem', 'Grupo no encontrado');
        }


        session()->flash('success', 'Usuario desvinculado con éxito');

        return to_route('users.groups.view', ['id' => $group_id]);
    }


    /**
     * Add users to existing group.
     */
    public function add_users(Request $request, $group_id) : RedirectResponse {

        $group = Group::find($group_id);

        /**
         * Validate form inputs.
         */
        $validated = $request->validateWithBag('create', [
            'users' => 'required|array',
            'users.*' => ['exists:users,id'],
            'roles' => ['required'],
        ]);

        $user_ids = $request->input('users');

        $user_ids = array_filter($user_ids, function ($userId) use ($group) {
            return !$group->users->contains($userId);
        });

        // Get roles list.
        $roles = $request->input('roles');

        // Prepare data for attach.
        $user_data = [];
        foreach($user_ids as $user_id) {
            $user_data[$user_id] = ['role' => $roles[$user_id]];
        }

        // Link users with group with their roles.
        $group->users()->attach($user_data);

        // Attach users to group's calendar.
        $calendar = $group->calendar;
        $calendar->users()->attach($user_ids);

        return to_route('users.groups.view', ['id' => $group->id]);
    }


    /**
     * Delete group.
     */
    public function delete($group_id) : RedirectResponse {

        $group = Group::find($group_id);

        if(!$group) {
            session()->flash('problem', 'No existe el grupo');
            return to_route('users.groups');
        }

        // Inactive all group-user relations.
        $group->users->each(function ($user) {
            $user->pivot->active = false;
            $user->pivot->save();
        });

        // Inactive group.
        $group->update([
            'active' => false,
        ]);

        $calendar = $group->calendar;
        
        $calendar->users->each(function ($user) {
            $user->pivot->active = false;
            $user->pivot->save();
        });

        $calendar->update([
            'active' => false,
        ]);

        return to_route('users.groups');
    }


    /**
     * Edit group and save changes.
     */
    public function edit(Request $request, $group_id) : RedirectResponse {

        /**
         * Validate form inputs.
         */
        $validated = $request->validateWithBag('create', [
            'name' => ['required'],
        ]);

        $group = Group::find($group_id);

        if(!$group) {
            session()->flash('problem', 'No existe el grupo');
            return to_route('users.groups');
        }

        // Change group's name.
        $group->update([
            'name' => $request->input('name'),
        ]);

        // Change calendar's name.
        $calendar = $group->calendar;
        $calendar->update([
            'name' => $request->input('name'),
        ]);
        session()->flash('success', 'Nombre del grupo cambiado');

        return to_route('users.groups.view', ['id' => $group_id]);
    }
}
