<?php

namespace Database\Seeders;

use App\Models\Mentor;
use App\Models\Review;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        if (!Review::count() > 0){
            Review::create([
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'author' => $faker->firstName,
                'text' => 'Хорошо всё. Спасибо',
                'type' => rand(1,2),
                'active' => $faker->boolean
            ]);
            Review::create([
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'author' => $faker->firstName,
                'text' => 'Ну что за прекрасный ментор',
                'type' => rand(1,2),
                'active' => $faker->boolean
            ]);
            Review::create([
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'author' => $faker->firstName,
                'text' => 'Хорошо всё. Спасибо',
                'type' => rand(1,2),
                'active' => $faker->boolean
            ]);
            Review::create([
                'mentor_id' => Mentor::inRandomOrder()->first()->id,
                'author' => $faker->firstName,
                'text' => 'Ну что за прекрасный ментор',
                'type' => rand(1,2),
                'active' => $faker->boolean
            ]);
        }
    }
}
