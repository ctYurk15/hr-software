<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;

class Holidays extends View
{
    public function view()
    {
        return $this->process('other.holidays');
    }
}
