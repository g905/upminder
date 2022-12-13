<?php

namespace Database\Seeders;

use App\Models\MentorCategory;
use App\Models\MentorTag;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MentorTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $tags = [
          'Телеграм бот',
          'Анимация',
          'Помочь с less',
          'Помогу изучить media',
          'Помощь с ларой',
        ];
        
        $faker = Factory::create('ru_RU');
        if (!MentorTag::count() > 0) {
            foreach ($tags as $tag) {
                MentorTag::create([
                    'category_id' => MentorCategory::all()->random(1)->first()->id,
                    'name' => $tag,
                ]);
                $this->command->line('Тег ментора создан: ' . $tag);
            }
        }
    }
}
