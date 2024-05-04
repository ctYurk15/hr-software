<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MyPersonal extends View
{
    public function view(Request $request)
    {
        $user = Auth::user();
        $fields = User::getFields('detail');

        return $this->process('personal.single', [
            'user' => $user,
            'current_user' => $user,
            'fields' => $fields
        ]);
    }
}
