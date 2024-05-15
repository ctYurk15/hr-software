<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sicklist extends Model
{
    use HasFactory;

    protected $fillable = ['from_date', 'to_date', 'employee_id', 'description'];

    // Add the $dates property
    protected $dates = ['from_date', 'to_date'];

    /**
     * Get the user that is associated with the sicklist.
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
