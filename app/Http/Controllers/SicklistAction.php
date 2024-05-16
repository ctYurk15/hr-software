<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\TrackerEvent;
use Illuminate\Http\Request;

use App\Models\Sicklist;

class SicklistAction extends Controller
{
    public function save(Request $request)
    {
        $result = ['success' => true];

        $record_id = $request->get('id');

        $count = Sicklist::where('employee_id', $request->get('employee_id'))
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
            $sicklist_record = $record_id == null ? new Sicklist() : Sicklist::find($record_id);
            $sicklist_record->from_date = $request->get('from_date');
            $sicklist_record->to_date= $request->get('to_date');
            $sicklist_record->employee_id = $request->get('employee_id');
            $sicklist_record->description = $request->get('description');
            $sicklist_record->save();
        }

        return $result;
    }

    public function get(Request $request, int $sicklist_id)
    {
        $sicklist = Sicklist::find($sicklist_id);
        if($sicklist != null)
        {
            return [
                'success' => true,
                'from_date' => $sicklist->from_date->format('Y-m-d'),
                'to_date' => $sicklist->to_date->format('Y-m-d'),
                'employee_id' => $sicklist->employee_id,
                'description' => $sicklist->description,
            ];
        }

        return ['success' => false];
    }

    public function delete(Request $request, int $sicklist_id)
    {
        $sicklist = Sicklist::find($sicklist_id);
        if($sicklist != null)
        {
            $sicklist->delete();
        }
        return ['success' => true];
    }

}
