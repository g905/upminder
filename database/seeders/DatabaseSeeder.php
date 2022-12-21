<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        $this->call([
            CountrySeeder::class,
            CitySeeder::class,
            CompanySeeder::class,
            CompanyCategorySeeder::class,
            CompanySingleCategorySeeder::class,
            CurrencySeeder::class,
            LanguageSeeder::class,
            MentorCategorySeeder::class,
            MentorSeeder::class,
            PageSeeder::class,
            MentorSingleEducationSeeder::class,
            MentorSingleExperienceSeeder::class,
            MentorSingleCategorySeeder::class,
            MentorSingleServicesSeeder::class,
            UserSeeder::class,
            MentorTagSeeder::class,
            ReviewsSeeder::class,
        ]);
    }
}
