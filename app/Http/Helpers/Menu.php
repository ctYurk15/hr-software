<?php

namespace App\Http\Helpers;

class Menu
{
    public static function get()
    {
        return [
            [
                'title' => 'My Tracker',
                'link' => route('my-tracker'),
                'image' => asset('images/modules-icons/my-tracker.png'),
                'route_name' => 'my-tracker',
                'manager_page' => false,
            ],
            [
                'title' => 'Team Tracker',
                'link' => route('team-tracker'),
                'image' => asset('images/modules-icons/team-tracker.png'),
                'route_name' => 'team-tracker',
                'manager_page' => true,
            ],
            [
                'title' => 'My Personal',
                'link' => route('my-personal'),
                'image' => asset('images/modules-icons/my-personal.png'),
                'route_name' => 'my-personal',
                'manager_page' => false,
            ],
            [
                'title' => 'Team Personal',
                'link' => route('team-personal'),
                'image' => asset('images/modules-icons/team-personal.png'),
                'route_name' => 'team-personal',
                'manager_page' => true,
            ],
            [
                'title' => 'Vacations',
                'link' => route('my-vacation'),
                'image' => asset('images/modules-icons/my-vacation.png'),
                'route_name' => 'my-vacation',
                'manager_page' => false,
            ],
            [
                'title' => 'Sicklists',
                'link' => route('sicklists'),
                'image' => asset('images/modules-icons/my-sicklist.png'),
                'route_name' => 'sicklists',
                'manager_page' => false,
            ],
            [
                'title' => 'Holidays',
                'link' => route('holidays'),
                'image' => asset('images/modules-icons/holidays.png'),
                'route_name' => 'holidays',
                'manager_page' => false,
            ],
            [
                'title' => 'Countries',
                'link' => route('countries'),
                'image' => asset('images/modules-icons/countries.png'),
                'route_name' => 'countries',
                'manager_page' => true,
            ],
            [
                'title' => 'Edit personal',
                'link' => route('edit-personal'),
                'image' => asset('images/modules-icons/my-personal.png'),
                'route_name' => 'edit-personal',
                'manager_page' => true,
                'hidden' => true
            ],
        ];
    }
}
