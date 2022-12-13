<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $cities = [
            'Москва',
            'Киев',
            'Минск',
            'Флорида',
        ];
        
        if (!City::count() > 0) {
            
            foreach ($cities as $index => $city) {
                $newCity = new City();
                $newCity->name = $city;
                $newCity->country_id = ++$index;
                $newCity->save();
            }
        }
    }
}
