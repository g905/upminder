<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyCategory;
use App\Models\CompanySingleCategory;
use Illuminate\Database\Seeder;

class CompanySingleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
    
        $companies = Company::all();
        if (!CompanySingleCategory::count() > 0) {
            foreach ($companies as $arr) {
                $new = new CompanySingleCategory();
                $new->company_id = $arr->id;
                $new->category_id = CompanyCategory::inRandomOrder()->first()->id;
                $new->save();
                $this->command->line('Связнь компания - Категория компании создана');
            }
        }
    }
}
