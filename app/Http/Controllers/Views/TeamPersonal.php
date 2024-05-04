<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TeamPersonal extends View
{
    public function view(Request $request)
    {
        $query = User::query();

        $fields = User::getFields('list');

        // Apply filters dynamically
        foreach ($fields as $field => $data) {
            $type = $data['operator'];
            if ($request->filled($field)) {
                $query->where($field, $type === 'like' ? 'LIKE' : '=', $type === 'like' ? '%' . $request->$field . '%' : $request->$field);
            }
        }

        $users = $query->paginate(10);

        $current_user = Auth::user();

        return $this->process('personal.team', [
            'users' => $users,
            'current_user' => $current_user,
            'list_fields' => $fields
        ]);
    }
}
