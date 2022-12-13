<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Русский',
            'English',
            'Italiano',
            'Polski'
        ];

        foreach ($data as $datum){
            $new = new Language();
            $new->fill(['name' => $datum]);
            $new->save();
        }
    }
}
