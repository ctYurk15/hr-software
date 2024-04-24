<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\TrackerEntry;
use App\Models\TrackerEvent;

class TrackerAction extends Controller
{
    public function process(string $action = '')
    {
        $tracker_entry = TrackerEntry::firstOrCreateEntry();

        switch ($action)
        {
            case 'add':
                //get last event
                $lastEvent = TrackerEvent::where('tracker_id', $tracker_entry->id)
                    ->latest('id')
                    ->first();

                //select type
                $new_entry_type = 'start';
                if($lastEvent != null && $lastEvent->type == 'start') $new_entry_type = 'end';

                //create event
                $new_event = new TrackerEvent();
                $new_event->tracker_id = $tracker_entry->id;
                $new_event->type = $new_entry_type;
                $new_event->save();

                //fill tracker entry date
                $current_datetime = date('Y-m-d H:i:s');
                if($tracker_entry->start_worktime == null && $new_entry_type == 'start')
                {
                    $tracker_entry->start_worktime = $current_datetime;
                }
                else if(
                    ($tracker_entry->end_worktime == null || strtotime($tracker_entry->end_worktime) < strtotime($current_datetime))
                    && $new_entry_type == 'end')
                {
                    $tracker_entry->end_worktime = $current_datetime;
                }

                //recalculate worktime
                $tracker_entry->recalculateTotalTime();

                $tracker_entry->save();

                break;
        }
        return ['success' => true, 'debug' => $tracker_entry->id, 'debug1' => $new_entry_type, 'action' => $action];
    }
}
