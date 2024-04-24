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

        $arguments = array_merge($arguments, [
            'user_role' => $role,
            'menu' => $menu,
            'route_name' => Route::currentRouteName(),
        ]);

        return view($template_path, $arguments);
    }
}
