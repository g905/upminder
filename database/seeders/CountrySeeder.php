<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            'Россия',
            'Украина',
            'Беларусь',
            'США'
        ];

        foreach ($countries as $country){
            $newCountry = new Country();
            $newCountry->name = $country;
            $newCountry->save();
        }
    }
}
