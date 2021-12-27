<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            ['name' => 'Gansiy cedi', 'code' => 'GHS'],
            ['name' => 'Kenyan shilling', 'code' => 'KES'],
            ['name' => 'Nigerian naira', 'code' => 'NGN'],
            ['name' => 'Zambian kwacha', 'code' => 'ZMW'],
            ['name' => 'Tanzanian Shilling', 'code' => 'TZS'],
            ['name' => 'South African Rand', 'code' => 'ZAR'],
            ['name' => 'Euro', 'code' => 'EUR'],
            ['name' => 'Pound', 'code' => 'GBP'],
            ['name' => 'Dollars', 'code' => 'USD'],
            ['name' => 'Peruvian salt', 'code' => 'PEN'],
            ['name' => 'Colombian peso', 'code' => 'COP'],
            ['name' => 'Mexican peso', 'code' => 'MXN'],
            ['name' => 'Nabian dollar', 'code' => 'NAD'],
            ['name' => 'Australian dollar', 'code' => 'AUD'],
            ['name' => 'Ugandan shilling', 'code' => 'UGX'],
            ['name' => 'Ruble', 'code' => 'RUB'],
            ['name' => 'Tenge', 'code' => 'KZT'],
            ['name' => 'Canadian dollar', 'code' => 'CAD'],
            ['name' => 'Brazilian Real', 'code' => 'BRL'],
            ['name' => 'Chinese Yuan', 'code' => 'CNY'],
            ['name' => 'Ethiopian birr', 'code' => 'ETB'],
        ];
        foreach ($currencies as $currency) {
            DB::table('currencies')->insert([
                'name' => $currency['name'],
                'code' => $currency['code'],
            ]);
        };
    }
}
