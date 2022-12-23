<?php

namespace Database\Seeders;

use App\Models\Mentor;
use App\Models\MentorSingleEducation;
use App\Models\MentorSingleExperience;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MentorSingleExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Factory::create('ru_RU');
        $mentors = Mentor::all();
        
        if (!MentorSingleExperience::count() > 0) {
            foreach ($mentors as $mentor) {
                $new = new MentorSingleExperience();
                $new->mentor_id = $mentor->id;
                $new->date_start = Carbon::now()->subMonths(rand(12, 36));
                $new->date_end = Carbon::now()->subMonths(rand(1, 11));
                $new->date_present = 0;
                $new->company = $faker->company;
                $new->position = $faker->jobTitle;
                $new->save();
            }
        }
    }
}
