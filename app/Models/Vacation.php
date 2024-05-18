<?php

namespace App\Models;

use App\Http\Helpers\DatesCalculator;
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
        return DatesCalculator::calculateWeekdays($this);
    }
}
