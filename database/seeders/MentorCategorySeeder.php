<?php

namespace Database\Seeders;

use App\Models\MentorCategory;
use Illuminate\Database\Seeder;

class MentorCategorySeeder extends Seeder
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
                'parent_id' => null,
                'name' => 'IT'
            ],
            1 => [
                'parent_id' => null,
                'name' => 'Юриспруденция'
            ],
            2 => [
                'parent_id' => 2,
                'name' => 'Гражданское право'
            ],
            3 => [
                'parent_id' => 2,
                'name' => 'Административное право'
            ],
            4 => [
                'parent_id' => 1,
                'name' => 'CSS'
            ],
            5 => [
                'parent_id' => 1,
                'name' => 'LESS'
            ],
            6 => [
                'parent_id' => 1,
                'name' => 'Система'
            ],
        ];

        foreach ($data as $datum){
            $new = new MentorCategory();
            $new->fill($datum);
            $new->save();
        }
    }
}
