<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPersonal extends View
{
    public function view(Request $request)
    {
        $user = Auth::user();
        return $this->process('personal.my', [
            'user' => $user
        ]);
    }
}
