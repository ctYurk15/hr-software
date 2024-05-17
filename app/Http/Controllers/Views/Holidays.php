<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Holidays extends View
{
    public function view(Request $request)
    {
        $current_user = Auth::user();
        $countryCode = $request->input('country_code', 'US');

        $year = date('Y');
        $holidays = Holiday::fetchHolidays($year, $countryCode);

        $countries = [
            'US' => 'United States',
            'UA' => 'Ukraine',
        ];

        return $this->process('other.holidays', [
            'holidays' => $holidays,
            'current_user' => $current_user,
            'countries' => $countries,
            'countryCode' => $countryCode
        ]);
    }
}
