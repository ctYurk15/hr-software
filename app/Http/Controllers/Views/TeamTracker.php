<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;

class TeamTracker extends View
{
    public function view()
    {
        return $this->process('tracker.team');
    }
}
