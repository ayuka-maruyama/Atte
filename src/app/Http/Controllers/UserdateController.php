<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Work_time;
use App\Models\Break_time;
use Illuminate\Http\Request;

class UserdateController extends Controller
{
    public function open(Request $request)
    {
        $users = User::paginate(5);

        return view('usersdate', compact('users'));
    }
}
