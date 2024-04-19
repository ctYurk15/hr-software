<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;

class MySicklist extends View
{
    public function view()
    {
        return $this->process('sicklist.my');
    }
}
