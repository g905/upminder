<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
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
                'page_type' => 1,
                'title' => 'О нас',
                'slug' => 'about',
                'excerpt' => 'test',
                'content' => 'active',
                'active' => 1
            ],
            1 => [
                'page_type' => 1,
                'title' => 'Тестовая страница',
                'slug' => 'test',
                'excerpt' => 'test',
                'content' => 'active',
                'active' => 1
            ]
        ];

        foreach ($data as $datum){
            $new = new Page();
            $new->fill($datum);
            $new->save();
        }
    }
}
