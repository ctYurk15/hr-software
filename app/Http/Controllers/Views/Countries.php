<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Countries extends View
{
    public function view(Request $request)
    {
        $countries = Country::all();
        return $this->process('other.countries', [
            'countries' => $countries
        ]);
    }
}
