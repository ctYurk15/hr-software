<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;

class TeamVacation extends View
{
    public function view()
    {
        return $this->process('vacation.team');
    }
}
