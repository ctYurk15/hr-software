<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;

class MyTracker extends View
{
    public function view()
    {
        return $this->process('tracker.my');
    }
}
