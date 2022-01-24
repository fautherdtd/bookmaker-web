<?php

namespace Database\Seeders;

use App\Models\User;
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
        $this->call([
            BetsSeeder::class,
            CountriesSeeder::class,
            CurrenciesSeeder::class,
            PaymentTypesSeeder::class,
            UserAndRolesSeeder::class
        ]);
    }
}
