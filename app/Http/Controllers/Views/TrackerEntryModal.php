<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Http\Helpers\Tracker as TrackerHelper;
use App\Models\TrackerEvent;
use App\Models\TrackerEntry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackerEntryModal extends View
{
    public function view(Request $request)
    {
        $tracker_entry_id = $request->get('tracker_entry_id') ?? null;
        $date = $request->get('date') ?? null;

        $entry = null;
        $events_arr = [];
        if($tracker_entry_id != null)
        {
            $entry = TrackerEntry::with('events')->find($tracker_entry_id);

            foreach($entry->events as $event)
            {
                $events_arr[$event->id] = [
                    'user_id' => $entry->employee_id,
                    'date' => $event->created_at->format('Y-m-d'),
                    'time' => $event->created_at->format('H:i'),
                    'type' => $event->type
                ];
            }
        }

        $users = User::all();

        $html = (string) view('tracker.entry-events-modal', [
            'entry' => $entry,
            'users' => $users,
            'date' => $date
        ]);

        return [
            'html' => $html,
            'events' => $events_arr
        ];
    }
}
