<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\TrackerEvent;
use Illuminate\Http\Request;

use App\Models\Vacation;

class VacationAction extends Controller
{
    public function save(Request $request)
    {
        $result = ['success' => true];

        $record_id = $request->get('id');

        $count = Vacation::where('employee_id', $request->get('employee_id'))
            ->whereNotIn('id', $record_id ? [$record_id] : [])
            ->whereDate('from_date', '=', $request->get('from_date'))
            ->whereDate('to_date', '=', $request->get('to_date'))
            ->count();

        if($count > 0)
        {
            $result['success'] = false;
            $result['error'] = 'Duplicate record! Please change data';
        }
        else
        {
            $vacation_record = $record_id == null ? new Vacation() : Vacation::find($record_id);
            $vacation_record->from_date = $request->get('from_date');
            $vacation_record->to_date= $request->get('to_date');
            $vacation_record->employee_id = $request->get('employee_id');
            $vacation_record->save();
        }

        return $result;
    }

    public function get(Request $request, int $vacation_id)
    {
        $vacation = Vacation::find($vacation_id);
        if($vacation != null)
        {
            return [
                'success' => true,
                'from_date' => $vacation->from_date->format('Y-m-d'),
                'to_date' => $vacation->to_date->format('Y-m-d'),
                'employee_id' => $vacation->employee_id,
            ];
        }

        return ['success' => false];
    }

    public function delete(Request $request, int $vacation_id)
    {
        $vacation = Vacation::find($vacation_id);
        if($vacation != null)
        {
            $vacation->delete();
        }
        return ['success' => true];
    }

}
