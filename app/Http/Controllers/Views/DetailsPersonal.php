<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Models\User;
use Illuminate\Http\Request;

class DetailsPersonal extends View
{
    public function view(Request $request, int $user_id = 0)
    {
        $user = User::find($user_id);
        return $this->process('personal.single', [
            'user' => $user
        ]);
    }
}
