<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Models\User;
use Illuminate\Http\Request;

class EditPersonal extends View
{
    public function view(Request $request, int $user_id = 0)
    {

        $user = User::find($user_id);
        $fields = User::getFields('edit');

        return $this->process('personal.edit', [
            'user' => $user,
            'fields' => $fields
        ]);
    }
}
