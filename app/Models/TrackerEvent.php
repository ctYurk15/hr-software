<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackerEvent extends Model
{
    use HasFactory;

    protected $table = 'tracker_event';

    protected $fillable = ['tracker_id', 'type'];

    public function trackerEntry()
    {
        return $this->belongsTo(TrackerEntry::class, 'tracker_id');
    }
}
