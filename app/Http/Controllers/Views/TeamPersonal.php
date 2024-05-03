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

        $list_fields = [
            'name' => [
                'operator' => 'like',
                'type' => 'text'
            ],
            'firstname' => [
                'operator' => 'like',
                'type' => 'text'
            ],
            'lastname' => [
                'operator' => 'like',
                'type' => 'text'
            ],
            'role' => [
                'operator' => 'exact',
                'type' => 'text'
            ],
            'birthdate' => [
                'operator' => 'exact',
                'type' => 'date'
            ],
            'email' => [
                'operator' => 'like',
                'type' => 'text'
            ],
            'phone' => [
                'operator' => 'like',
                'type' => 'text'
            ],
            'region' => [
                'operator' => 'like',
                'type' => 'text'
            ],
            'start_work_date' => [
                'operator' => 'exact',
                'type' => 'date'
            ]
        ];

        // Apply filters dynamically
        foreach ($list_fields as $field => $data) {
            $type = $data['operator'];
            if ($request->filled($field)) {
                $query->where($field, $type === 'like' ? 'LIKE' : '=', $type === 'like' ? '%' . $request->$field . '%' : $request->$field);
            }
        }

        $users = $query->get();

        $current_user = Auth::user();

        return $this->process('personal.team', [
            'users' => $users,
            'current_user' => $current_user,
            'list_fields' => $list_fields
        ]);
    }
}
