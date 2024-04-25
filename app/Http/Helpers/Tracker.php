<?php

namespace App\Http\Helpers;

use App\Models\TrackerEntry;
use Carbon\Carbon;

class Tracker
{
    public static function getUserRows(string $start_date, string $end_date, int $user_id)
    {
        return static::getUsersRows($start_date, $end_date, [$user_id]);
    }

    public static function getUsersRows(string $start_date, string $end_date, array $users_ids)
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
                'entries' => []
            ];
        }

        $entries = TrackerEntry::whereBetween('date', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ])
            ->orderBy('date', 'desc');
            //->get();
        if($users_ids != []) $entries = $entries->whereIn('employee_id', $users_ids);

        $entries = $entries->get();


        // Append entries to their corresponding dates
        foreach ($entries as $entry) {
            $entryDate = $entry->date->format('Y-m-d');

            if (isset($datesWithEntries[$entryDate])) {
                $datesWithEntries[$entryDate]['entries'][] = $entry;
            }
        }

        return $datesWithEntries;
    }
}
