<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\View;
use App\Models\Country;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Holidays extends View
{
    public function view(Request $request)
    {
        $current_user = Auth::user();
        $countries = Country::all();

        $countryId = $request->input('country_id', null);
        if($countryId == null && count($countries) > 0)
        {
            $countryId = $countries[0]->id;
        }

        $year = (int) date('Y');
        $holidays = [];

        if($countryId != null)
        {
            $holidays = Holiday::fetchHolidays($year, $countryId);
        }

        return $this->process('other.holidays', [
            'holidays' => $holidays,
            'current_user' => $current_user,
            'countries' => $countries,
            'countryId' => $countryId
        ]);
    }
}
