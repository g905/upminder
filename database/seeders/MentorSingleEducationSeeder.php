<?php

namespace Database\Seeders;

use App\Models\MentorSingleEducation;
use Illuminate\Database\Seeder;

class MentorSingleEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            0 => [
                'mentor_id' => rand(1, 5),
                'date_start' => '2022-08-16',
                'date_end' => '2022-08-21',
                'date_present' => 0,
                'school' => 'МГУ',
                'course' => 'Юрист',
            ],
            1 => [
                'mentor_id' => rand(1, 5),
                'date_start' => '2022-08-16',
                'date_end' => '2022-08-21',
                'date_present' => 0,
                'school' => 'АГУ',
                'course' => 'Экономист',
            ],
        ];
        
        foreach ($data as $datum) {
            $new = new MentorSingleEducation();
            $new->fill($datum);
            $new->save();
        }
    }
}
