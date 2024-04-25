<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Models\TrackerEntry;
use App\Models\TrackerEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Helpers\Tracker as TrackerHelper;

class MyTracker extends View
{
    public function view(Request $request)
    {
        $tracker_entry = TrackerEntry::firstOrCreateEntry();
        $lastEvent = TrackerEvent::where('tracker_id', $tracker_entry->id)
            ->latest('id')
            ->first();

        $now = Carbon::now();
        $from_date = $request->get('from_date') ??($now->startOfMonth())->format('Y-m-d');
        $to_date = $request->get('to_date') ?? Carbon::now()->format('Y-m-d');
        $user_id = (int) (Auth::user())->id;

        $rows = TrackerHelper::getUserRows($from_date, $to_date, $user_id);

        return $this->process('tracker.my', [
            'last_event' => $lastEvent,
            'rows' => $rows,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ]);
    }
}
