<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;

class MyVacation extends View
{
    public function view()
    {
        return $this->process('vacation.my');
    }
}
