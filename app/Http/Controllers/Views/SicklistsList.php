<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Models\User;
use App\Models\Sicklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SicklistsList extends View
{
    public function view(Request $request)
    {
        $current_user = Auth::user();

        $query = Sicklist::with('user');

        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('from_date', '=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('to_date', '=', $request->to_date);
        }

        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->has('description') && $request->description) {
            $query->where('description', $request->description);
        }

        //only managers can see all sicklists
        if($current_user->role != 'manager')
        {
            $query->where('employee_id', $current_user->id);
        }

        $sicklists = $query->paginate(10);
        $users = User::all(); // For dropdown list

        return $this->process('sicklist.list', [
            'sicklists' => $sicklists,
            'current_user' => $current_user,
            'users' => $users
        ]);
    }
}
