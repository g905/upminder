<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Mentor;
use App\Models\MentorSingleEducation;
use App\Models\MentorSingleService;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MentorSingleServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('ru_RU');
        $data = [
             [
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'currency_id' => Currency::whereCode('RUB')->first()->id,
                'service' => 'Первое занятие',
                'price' => $faker->unique()->numberBetween(250, 3000),
                'discount' => $faker->unique()->numberBetween(0, 200)
            ],
             [
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'currency_id' => Currency::whereCode('RUB')->first()->id,
                'service' => 'Пять услуг',
                'price' => $faker->unique()->numberBetween(250, 3000),
                'discount' => $faker->unique()->numberBetween(0, 200)
            ],
             [
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'currency_id' => Currency::whereCode('RUB')->first()->id,
                'service' => 'Две услуги',
                'price' => $faker->unique()->numberBetween(250, 3000),
                'discount' => $faker->unique()->numberBetween(0, 200)
            ],
             [
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'currency_id' => Currency::whereCode('RUB')->first()->id,
                'service' => 'Одна консультация',
                'price' => $faker->unique()->numberBetween(250, 3000),
                'discount' => $faker->unique()->numberBetween(0, 200)
            ],
             [
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'currency_id' => Currency::whereCode('RUB')->first()->id,
                'service' => 'Услуга',
                'price' => $faker->unique()->numberBetween(250, 3000),
                'discount' => $faker->unique()->numberBetween(0, 200)
            ],
             [
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'currency_id' => Currency::whereCode('RUB')->first()->id,
                'service' => 'Разработка сайта под ключ',
                'price' => $faker->unique()->numberBetween(250, 3000),
                'discount' => $faker->unique()->numberBetween(0, 200)
            ],
             [
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'currency_id' => Currency::whereCode('RUB')->first()->id,
                'service' => 'Вёрстка',
                'price' => $faker->unique()->numberBetween(250, 3000),
                'discount' => $faker->unique()->numberBetween(0, 200)
            ],
        ];
    
        foreach ($data as $datum) {
            $new = new MentorSingleService();
            $new->fill($datum);
            $new->save();
        }
    }
}
