<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Fetches public holidays from the API based on country_id and stores them in the database.
     *
     * @param int $year
     * @param int $countryId
     * @return mixed
     */
    public static function fetchHolidays(int $year, int $countryId)
    {
        $country = Country::find($countryId);
        if (!$country) {
            throw new \Exception("Invalid country ID: {$countryId}");
        }

        // Assuming the API still needs a country code, we fetch it from the Country model
        $countryCode = $country->country_code;

        // Check if holidays for this year and country are already fetched
        $existingHolidays = self::whereYear('date', $year)
            ->where('country_id', $countryId)
            ->get();

        if ($existingHolidays->isNotEmpty()) {
            return $existingHolidays;
        }

        $url = "https://date.nager.at/api/v3/PublicHolidays/{$year}/{$countryCode}";
        $response = Http::get($url);

        if ($response->successful()) {
            $holidays = $response->json();

            foreach ($holidays as $holiday) {
                self::create([
                    'name' => $holiday['name'],
                    'date' => $holiday['date'],
                    'country_id' => $countryId,  // Store the country_id instead of country_code
                ]);
            }

            return self::whereYear('date', $year)->where('country_id', $countryId)->get();
        } else {
            // Handle the error accordingly
            throw new \Exception('Failed to fetch holidays from API');
        }
    }
}
