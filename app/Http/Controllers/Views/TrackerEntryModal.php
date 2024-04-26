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

        $entry = null;
        if($tracker_entry_id != null)
        {
            $entry = TrackerEntry::with('events')->find($tracker_entry_id);
        }

        $users = User::all();

        return view('tracker.entry-events-modal', [
            'entry' => $entry,
            'users' => $users
        ]);
    }
}
