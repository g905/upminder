<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
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
                'code' => 'RUB',
                'name' => 'Российский рубль'
            ],
            1 => [
                'code' => 'USD',
                'name' => 'Доллар США'
            ]
        ];

        foreach ($data as $datum){
            $new = new Currency();
            $new->fill($datum);
            $new->save();
        }
    }
}
