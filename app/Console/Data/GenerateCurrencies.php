<?php

namespace App\Console\Data;

use App\Http\Controllers\Common\CurrencyConverter;
use App\Models\Pivot\Currencies;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Currencies statistics';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(
        Currencies $currencies,
        CurrencyConverter $api
    ) {
        $bar = $this->output->createProgressBar(
            count($api->getCurrenciesApi())
        );
        foreach ($api->getCurrenciesApi() as $currency) {
            DB::table('currencies')
                ->updateOrInsert(
                    ['code' => $currency->code],
                    ['exchange' => $currency->exchange]
                );
            $bar->advance();
        }
        $bar->finish();
    }
}
