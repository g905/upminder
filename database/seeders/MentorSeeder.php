<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Mentor;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Factory::create('ru_RU');
        $data = [
            0 => [
                'email' => 'Indesite@gmail.com',
                'phone' => '9831001000',
                'telegram' => null,
                'description' => 'Описание',
                'help_text' => 'Я могут помочь',
                'experience' => null,
                'verified' => 1,
                'vip_status' => rand(0, 1),
            ],
            1 => [
                'email' => 'Indesite@gmail.com',
                'phone' => '09123490120934',
                'telegram' => null,
                'description' => 'Описание',
                'help_text' => 'Я могут помочь',
                'experience' => null,
                'verified' => 1,
                'vip_status' => rand(0, 1),
            ],
            2 => [
                'email' => 'Indesite@gmail.com',
                'phone' => '9831001000',
                'telegram' => null,
                'description' => 'Описание',
                'help_text' => 'Я могут помочь',
                'experience' => null,
                'verified' => 1,
                'vip_status' => rand(0, 1),
            ],
            3 => [
                'email' => 'Indesite@gmail.com',
                'phone' => '9831001000',
                'telegram' => null,
                'description' => 'Описание',
                'help_text' => 'Я могут помочь',
                'experience' => null,
                'verified' => 1,
                'vip_status' => rand(0, 1),
            ],
        ];
        if (!Mentor::count() > 0) {
            $countries = Country::all();
            foreach ($data as $datum) {
                $country = $countries->random(1)
                    ->first();
                $new = new Mentor();
                $new->fill($datum);
                $new->country_id = $country->id;
                $new->city_id = $country->cities()
                    ->inRandomOrder()
                    ->first()->id;
                $new->last_name = $faker->lastName;
                $new->first_name = $faker->firstName;
                $new->surname = '';
                $new->save();
            }
        }
    }
}
