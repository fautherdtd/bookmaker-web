<?php

namespace App\Console\Data;

use App\Http\Controllers\Common\CurrencyConverter;
use App\Models\Pivot\Currencies;
use Illuminate\Console\Command;

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
        CurrencyConverter $converter
    )
    {
        $bar = $this->output->createProgressBar($currencies::count());
        foreach ($currencies->all() as $currency) {
            $temp = $currency::find($currency->id);
            if ($currency->is_exchange) {
                $current = (array) $converter->convert($currency->code);
                $temp->exchange = floatval($current[$currency->code]->rate);
                $temp->save();
            }
            sleep(2);
            $bar->advance();
        }
        $bar->finish();
    }
}
