<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;

class TeamSicklist extends View
{
    public function view()
    {
        return $this->process('sicklist.team');
    }
}
