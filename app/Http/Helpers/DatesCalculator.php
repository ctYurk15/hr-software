<?php

namespace App\Http\Helpers;

use App\Models\Holiday;
use Carbon\Carbon;

class DatesCalculator
{
    public static function calculateWeekdays($record)
    {
        $fromDate = Carbon::parse($record->from_date);
        $toDate = Carbon::parse($record->to_date);

        $user = $record->user()->with('country')->first(); // Fetch user with country relationship loaded
        $country_id = $user->country_id;

        // Fetch holidays for the given country and year
        $holidays = Holiday::where('country_id', $country_id)
            ->whereYear('date', $fromDate->year)
            ->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })->toArray();

        $days = 0;

        while ($fromDate->lte($toDate)) {
            // Check if it's not a weekend and not a holiday
            if (!$fromDate->isWeekend() && !in_array($fromDate->format('Y-m-d'), $holidays)) {
                $days++;
            }
            $fromDate->addDay();
        }

        return $days;
    }
}
