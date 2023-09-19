<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Returns view with groups list.
     */
    public function index() : View {

        $groups = Group::all()->where('active', true);

        return view('users.groups.index');
    }
}
