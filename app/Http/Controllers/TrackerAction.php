<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\TrackerEntry;
use App\Models\TrackerEvent;
use Illuminate\Http\Request;

class TrackerAction extends Controller
{
    public function process(Request $request, string $action = '')
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

            case 'add-manual':

                $user_id = (int) $request->get('user_id');
                $date = (string) $request->get('date');
                $time = (string) $request->get('time');
                $type = (string) $request->get('type');

                $tracker_entry = TrackerEntry::firstOrCreateEntry($user_id, $date);

                $new_event = new TrackerEvent();
                $new_event->tracker_id = $tracker_entry->id;
                $new_event->type = $type;
                $new_event->created_at = $date.' '.$time;
                $new_event->updated_at = $date.' '.$time;
                $new_event->save();

                //fill tracker entry date
                $current_datetime = $date.' '.$time;
                if($tracker_entry->start_worktime == null && $type == 'start')
                {
                    $tracker_entry->start_worktime = $current_datetime;
                }
                else if(
                    ($tracker_entry->end_worktime == null || strtotime($tracker_entry->end_worktime) < strtotime($current_datetime))
                    && $type == 'end')
                {
                    $tracker_entry->end_worktime = $current_datetime;
                }

                //recalculate worktime
                $tracker_entry->recalculateTotalTime();

                $tracker_entry->save();

                break;

            case 'delete':
                $event_id = (int) $request->get('event_id');
                $event = TrackerEvent::find($event_id);
                $tracker_entry_id = $event->tracker_id;
                $type = $event->type;
                $event->delete();

                //update start/end_worktime columns
                $entry = TrackerEntry::with(['events' => function($query) use ($type) {
                    $query->where('type', $type);
                }])->find($tracker_entry_id);

                if($entry->events->count() == 0)
                {
                    $column_name = $type.'_worktime';
                    $entry->$column_name = null;
                    $entry->save();
                }

                break;
        }
        return ['success' => true];
    }
}
