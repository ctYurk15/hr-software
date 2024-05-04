<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private static array $fields = [
        'name' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Name',
            'views' => ['list', 'detail', 'edit'],
        ],
        'firstname' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Firstname',
            'views' => ['list', 'detail', 'edit'],
        ],
        'lastname' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Lastname',
            'views' => ['list', 'detail', 'edit'],
        ],
        'role' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Role',
            'views' => ['list', 'detail', 'edit'],
        ],
        'birthdate' => [
            'operator' => 'exact',
            'type' => 'date',
            'title' => 'Birthdate',
            'views' => ['list', 'detail', 'edit'],
        ],
        'email' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'E-Mail',
            'views' => ['list', 'detail', 'edit'],
        ],
        'phone' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Phone',
            'views' => ['list', 'detail', 'edit'],
        ],
        'region' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Region',
            'views' => ['list', 'detail', 'edit'],
        ],
        'start_work_date' => [
            'operator' => 'exact',
            'type' => 'date',
            'title' => 'Start work',
            'views' => ['list', 'detail'],
        ],
        'working_time_monday' => [
            'operator' => 'exact',
            'type' => 'number',
            'title' => 'Monday Working Time',
            'views' => ['detail', 'edit'],
        ],
        'working_time_tuesday' => [
            'operator' => 'exact',
            'type' => 'number',
            'title' => 'Tuesday Working Time',
            'views' => ['detail', 'edit'],
        ],
        'working_time_wednesday' => [
            'operator' => 'exact',
            'type' => 'number',
            'title' => 'Wednesday Working Time',
            'views' => ['detail', 'edit'],
        ],
        'working_time_thursday' => [
            'operator' => 'exact',
            'type' => 'number',
            'title' => 'Thursday Working Time',
            'views' => ['detail', 'edit'],
        ],
        'working_time_friday' => [
            'operator' => 'exact',
            'type' => 'number',
            'title' => 'Friday Working Time',
            'views' => ['detail', 'edit'],
        ],
        'working_time_saturday' => [
            'operator' => 'exact',
            'type' => 'number',
            'title' => 'Saturday Working Time',
            'views' => ['detail', 'edit'],
        ],
        'working_time_sunday' => [
            'operator' => 'exact',
            'type' => 'number',
            'title' => 'Sunday Working Time',
            'views' => ['detail', 'edit'],
        ],
        'current_year_overtime' => [
            'operator' => 'exact',
            'type' => 'number',
            'title' => 'Current Year Overtime',
            'views' => ['detail'],
        ],
    ];

    public static function getFields(string $view)
    {
        $result = [];

        foreach(static::$fields as $field_name => $field_data)
        {
            if(in_array($view, $field_data['views'])) $result[$field_name] = $field_data;
        }

        return $result;
    }
}
