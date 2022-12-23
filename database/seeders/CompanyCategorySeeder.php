<?php

namespace Database\Seeders;

use App\Models\CompanyCategory;
use Illuminate\Database\Seeder;

class CompanyCategorySeeder extends Seeder
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
                'name' => 'Производители'
            ],
            1 => [
                'parent_id' => 1,
                'name' => 'Программное обеспечение'
            ]
        ];

        foreach ($data as $arr){
            $newCompanyCategory = new CompanyCategory();
            $newCompanyCategory->fill($arr);
            $newCompanyCategory->save();
        }
    }
}
