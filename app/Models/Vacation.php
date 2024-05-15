<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vacation extends Model
{
    protected $fillable = ['from_date', 'to_date', 'employee_id'];

    // Add the $dates property
    protected $dates = ['from_date', 'to_date'];

    /**
     * Get the user that owns the vacation.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Calculates the number of weekdays between from_date and to_date, excluding weekends.
     * @return int Number of weekdays
     */
    public function calculateWeekdays()
    {
        $fromDate = Carbon::parse($this->from_date);
        $toDate = Carbon::parse($this->to_date);

        $days = 0;

        while ($fromDate->lte($toDate)) {
            if (!$fromDate->isWeekend()) {
                $days++;
            }
            $fromDate->addDay();
        }

        return $days;
    }
}
