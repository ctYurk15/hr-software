<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date', 'country_code'];

    public static function fetchHolidays($year, $countryCode)
    {
        // Check if holidays for this year and country code are already fetched
        $existingHolidays = self::whereYear('date', $year)->where('country_code', $countryCode)->get();
        if ($existingHolidays->isNotEmpty()) {
            return $existingHolidays;
        }

        $url = "https://date.nager.at/api/v3/PublicHolidays/{$year}/{$countryCode}";
        echo $url;
        $response = Http::get($url);

        if ($response->successful()) {
            $holidays = $response->json();

            foreach ($holidays as $holiday) {
                self::create([
                    'name' => $holiday['name'],
                    'date' => $holiday['date'],
                    'country_code' => $countryCode, // Storing the country code
                ]);
            }

            return self::whereYear('date', $year)->where('country_code', $countryCode)->get();
        } else {
            // Handle the error accordingly
            throw new \Exception('Failed to fetch holidays from API');
        }
    }
}
