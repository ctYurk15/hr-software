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
                'title' => 'My Vacations',
                'link' => route('my-vacation'),
                'image' => asset('images/modules-icons/my-vacation.png'),
                'route_name' => 'my-vacation',
                'manager_page' => false,
            ],
            [
                'title' => 'Team Vacations',
                'link' => route('team-vacation'),
                'image' => asset('images/modules-icons/team-vacation.png'),
                'route_name' => 'team-vacation',
                'manager_page' => true,
            ],
            [
                'title' => 'My Sicklist',
                'link' => route('my-sicklist'),
                'image' => asset('images/modules-icons/my-sicklist.png'),
                'route_name' => 'my-sicklist',
                'manager_page' => false,
            ],
            [
                'title' => 'Team Sicklist',
                'link' => route('team-sicklist'),
                'image' => asset('images/modules-icons/team-sicklist.png'),
                'route_name' => 'team-sicklist',
                'manager_page' => true,
            ],
            [
                'title' => 'Holidays',
                'link' => route('holidays'),
                'image' => asset('images/modules-icons/holidays.png'),
                'route_name' => 'holidays',
                'manager_page' => false,
            ],
        ];
    }
}
