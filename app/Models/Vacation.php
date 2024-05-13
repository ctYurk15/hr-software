<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
