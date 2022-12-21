<?php

namespace Database\Seeders;

use App\Models\MentorSingleCategory;
use Illuminate\Database\Seeder;

class MentorSingleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            0 => [
                'mentor_id' => rand(1, 4),
                'category_id' => rand(1, 3)
            ],
            1 => [
                'mentor_id' => rand(1, 4),
                'category_id' => rand(1, 3)
            ],
            2 => [
                'mentor_id' => rand(1, 4),
                'category_id' => rand(1, 3)
            ],
            3 => [
                'mentor_id' => rand(1, 4),
                'category_id' => rand(1, 3)
            ]
        ];

        foreach ($data as $datum){
            $new = new MentorSingleCategory();
            $new->fill($datum);
            $new->save();
        }
    }
}
