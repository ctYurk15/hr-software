<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailsPersonal extends View
{
    public function view(Request $request, int $user_id = 0)
    {
        $user = $user_id != null ? User::find($user_id) : null;
        $current_user = Auth::user();

        return $this->process('personal.single', [
            'user' => $user,
            'current_user' => $current_user
        ]);
    }
}
