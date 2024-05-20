<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

abstract class View extends Controller
{
    public function view(Request $request) {}

    public function process(string $template_path, array $arguments = [])
    {
        $role = '';
        if(Auth::user() != null)
        {
            $role = (Auth::user())->role;
        }

        $menu = Menu::get();
        $route_name = Route::currentRouteName();
        $key = array_search($route_name, array_column($menu, 'route_name'));
        $route_title = $menu[$key]['title'];

        $arguments = array_merge($arguments, [
            'user_role' => $role,
            'menu' => $menu,
            'route_name' => $route_name,
            'route_title' => $route_title,
        ]);

        return view($template_path, $arguments);
    }
}
