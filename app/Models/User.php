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

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    private static array $fields = [
        'name' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Name',
            'views' => ['list', 'detail', 'edit'],
            'required' => true,
        ],
        'password' => [
            'operator' => 'like',
            'type' => 'password',
            'title' => 'Password',
            'views' => ['edit'],
            'required' => true,
        ],
        'password_confirmation' => [
            'operator' => 'like',
            'type' => 'password',
            'title' => 'Repeat password',
            'views' => ['edit'],
            'required' => true,
        ],
        'firstname' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Firstname',
            'views' => ['list', 'detail', 'edit'],
            'required' => true,
        ],
        'lastname' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Lastname',
            'views' => ['list', 'detail', 'edit'],
            'required' => true,
        ],
        'role' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'Role',
            'views' => ['list', 'detail', 'edit'],
            'options' => ['employee', 'manager'],
            'required' => true,
        ],
        'birthdate' => [
            'operator' => 'exact',
            'type' => 'date',
            'title' => 'Birthdate',
            'views' => ['list', 'detail', 'edit'],
            'required' => true,
        ],
        'email' => [
            'operator' => 'like',
            'type' => 'text',
            'title' => 'E-Mail',
            'views' => ['list', 'detail', 'edit'],
            'required' => true,
        ],
        'phone' => [
            'operator' => 'like',
            'type' => 'tel',
            'title' => 'Phone',
            'views' => ['list', 'detail', 'edit'],
        ],
        'country_id' => [
            'operator' => 'exact',
            'type' => 'relation',
            'relation_prop' => 'country',
            'relation_model' => Country::class,
            'title' => 'Country',
            'views' => ['detail', 'edit'],
        ],
        'start_work_date' => [
            'operator' => 'exact',
            'type' => 'date',
            'title' => 'Start work',
            'views' => ['list', 'detail'],
        ],
        'address' => [
            'operator' => 'exact',
            'type' => 'textarea',
            'title' => 'Address',
            'views' => ['edit', 'detail'],
        ],
        /*'working_time_monday' => [
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
        ],*/
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
