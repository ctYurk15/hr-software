<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CountryAction extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country_code' => 'required|string|max:2|unique:countries,country_code'
        ]);

        $country = Country::create($validatedData);
        return response()->json($country, 201);
    }

    public function update(Request $request, Country $country)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Ensure the country_code is unique but ignore the current country's ID
            'country_code' => ['required', 'string', 'max:2', Rule::unique('countries', 'country_code')->ignore($country->id)]
        ]);

        $country->update($validatedData);
        return response()->json($country, 200);
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json(null, 204);
    }
}
