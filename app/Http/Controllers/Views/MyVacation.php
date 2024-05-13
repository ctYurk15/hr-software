<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MyVacation extends View
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

        $vacations = $query->get();
        $users = User::all(); // For dropdown list

        return $this->process('vacation.list', [
            'vacations' => $vacations,
            'users' => $users
        ]);
    }
}
