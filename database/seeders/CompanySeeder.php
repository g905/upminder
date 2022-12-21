<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $companies = [
            0 => [
                'name' => 'Такая вот компания',
                'law_name' => 'ООО "Рога и копыта"',
                'inn' => '12312312311',
                
                'contact_name' => 'Пупкин Иван Васильевич',
                'email' => 'asdfoi@mail.ru',
                'phone' => '+79110000000',
                'website' => 'http://indesiv4.beget.tech/',
                'description' => 'Описание',
                'logo' => '',
            ],
            1 => [
                'name' => 'Стройка',
                'law_name' => 'ООО "Стройка"',
                'inn' => '123123123',
                'contact_name' => 'Пупкин Иван',
                'email' => 'asdfpo@mail.ru',
                'phone' => '+79990000000',
                'website' => 'https://mail.ru/',
                'description' => 'test description',
                'logo' => '',
            ],
            2 => [
                'name' => 'Балдеж',
                'law_name' => 'ООО "Балдеж компани"',
                'inn' => '263519928143',
                'contact_name' => 'Константин Кравцов',
                'email' => 'hhh1@gmail.com',
                'phone' => '+79110000000',
                'website' => 'http://indesiv4.beget.tech/',
                'description' => 'Описание',
                'logo' => '',
            ],
        ];
        
        if (!Company::count() > 0) {
            foreach ($companies as $company) {
                $newCompany = new Company();
                $newCompany->fill($company);
                $country = Country::inRandomOrder()
                    ->first();
                $city = $country->cities()
                    ->inRandomOrder()
                    ->first();
                $newCompany->country_id = $country->id ?? 0;
                $newCompany->city_id = $city
                    ? $city->id
                    : null;
                $newCompany->save();
            }
        }
    }
}
