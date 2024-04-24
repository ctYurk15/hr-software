<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrackerEntry extends Model
{
    use HasFactory;

    protected $table = 'tracker_entry';

    protected $fillable = ['date', 'employee_id', 'start_worktime', 'end_worktime', 'worked_time'];

    protected $casts = [
        'date' => 'date', // Casting the 'date' column to a date type
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function events()
    {
        return $this->hasMany(TrackerEvent::class, 'tracker_id');
    }

    public static function firstOrCreateEntry()
    {
        $employee_id = (Auth::user())->id;

        $today = now()->toDateString();

        // Attempt to find or create the tracker entry of user in current day
        return TrackerEntry::firstOrCreate(
            [
                'employee_id' => $employee_id,
                'date' => $today
            ],
            [
                'start_worktime' => null,
                'end_worktime' => null,
                'worked_time' => 0
            ]
        );
    }

    public function recalculateTotalTime()
    {
        // Fetch all start and end events sorted by creation time
        $events = $this->events()->whereIn('type', ['start', 'end'])->orderBy('created_at')->get();

        $totalDuration = 0;
        $tempStart = null;

        foreach ($events as $event) {
            if ($event->type === 'start') {
                $tempStart = new Carbon($event->created_at);
            } elseif ($event->type === 'end' && $tempStart) {
                $tempEnd = new Carbon($event->created_at);
                $totalDuration += $tempStart->diffInSeconds($tempEnd);
                $tempStart = null; // Reset start time for the next cycle
            }
        }

        $this->worked_time = $totalDuration;
    }

    public function getWorkTimeStr()
    {
        $total_worktime_seconds = (int) $this->worked_time;

        $hours = intval($total_worktime_seconds / 3600);
        $minutes = intval(($total_worktime_seconds - ($hours * 3600)) / 60);

        return str_pad($hours, 2, '0', STR_PAD_LEFT)
            .':'.str_pad($minutes, 2, '0', STR_PAD_LEFT);
    }
}
