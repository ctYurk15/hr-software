<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VacationsList extends View
{
    public function view(Request $request)
    {
        $current_user = Auth::user();

        $query = Vacation::with('user');

        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('from_date', '=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('to_date', '=', $request->to_date);
        }

        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        //only managers can see all vacations
        if($current_user->role != 'manager')
        {
            $query->where('employee_id', $current_user->id);
        }

        $vacations = $query->paginate(10);
        $users = User::all(); // For dropdown list

        return $this->process('vacation.list', [
            'vacations' => $vacations,
            'current_user' => $current_user,
            'users' => $users
        ]);
    }
}
