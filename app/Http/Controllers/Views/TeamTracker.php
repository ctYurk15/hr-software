<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Http\Helpers\Tracker as TrackerHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamTracker extends View
{
    public function view(Request $request)
    {
        $now = Carbon::now();
        $from_date = $request->get('from_date') ??($now->startOfMonth())->format('Y-m-d');
        $to_date = $request->get('to_date') ?? Carbon::now()->format('Y-m-d');
        $users_ids = is_array($request->users_ids) ? $request->users_ids : [];

        $rows = TrackerHelper::getUsersRows($from_date, $to_date, $users_ids);
        $users = User::all();

        return $this->process('tracker.team', [
            'rows' => $rows,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'users_ids_selected' => $users_ids,
            'users' => $users
        ]);
    }
}
