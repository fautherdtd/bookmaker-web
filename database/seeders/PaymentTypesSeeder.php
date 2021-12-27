<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Neteller',
            'Skrill',
            'usdt',
            'btc',
            'Банковские карты зарубежных стран',
            'Банковские карты РФ',
            'Qiwi'
        ];
        foreach ($types as $type) {
            DB::table('payment_types')->insert([
                'title' => $type
            ]);
        };
    }
}
