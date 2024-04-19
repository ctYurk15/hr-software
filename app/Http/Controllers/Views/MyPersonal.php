<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;

class MyPersonal extends View
{
    public function view()
    {
        return $this->process('personal.my');
    }
}
