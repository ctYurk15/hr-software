<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;

use App\Models\TrackerEntry;
use App\Models\TrackerEvent;
use DateTime;
use DateInterval;
use DatePeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Http\Request;

class MyTracker extends View
{
    public function view(Request $request)
    {
        $tracker_entry = TrackerEntry::firstOrCreateEntry();
        $lastEvent = TrackerEvent::where('tracker_id', $tracker_entry->id)
            ->latest('id')
            ->first();

        $now = Carbon::now();
        $from_date = $request->get('from_date') ?? $now->startOfMonth()->format('Y-m-d');
        $to_date = $request->get('to_date') ?? $now->endOfMonth()->format('Y-m-d');
        $user_id = (int) (Auth::user())->id;

        $rows = $this->getRows($from_date, $to_date, $user_id);

        return $this->process('tracker.my', [
            'last_event' => $lastEvent,
            'rows' => $rows,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ]);
    }

    private function getRows(string $start_date, string $end_date, int $user_id)
    {
        $endDate = Carbon::createFromFormat('Y-m-d', $end_date);
        $startDate = Carbon::createFromFormat('Y-m-d', $start_date);

        // Create an array to store dates with entries
        $datesWithEntries = [];

        // Manually create dates from endDate to startDate
        for ($date = clone $endDate; $date->gte($startDate); $date->subDay()) {
            $dateStr = $date->format('Y-m-d');
            $datesWithEntries[$dateStr] = [
                'date' => $dateStr,
                'entry' => null
            ];
        }

        $entries = TrackerEntry::where('employee_id', $user_id)
            ->whereBetween('date', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ])
            ->orderBy('date', 'desc')
            ->get();


        // Append entries to their corresponding dates
        foreach ($entries as $entry) {
            $entryDate = $entry->date->format('Y-m-d');
            echo $entryDate."<br>";
            if (isset($datesWithEntries[$entryDate])) {
                $datesWithEntries[$entryDate]['entry'] = $entry;
            }
        }

        return $datesWithEntries;
    }
}
