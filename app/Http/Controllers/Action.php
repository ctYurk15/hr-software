<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

abstract class Action extends Controller
{
    public function action()
    {
        return null;
    }

    public function checkPermission()
    {
        return true;
    }

    public function process()
    {
        if($this->checkPermission())
        {
            return $this->action();
        }

        return ['success' => false];
    }
}
