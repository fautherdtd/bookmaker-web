<?php

namespace App\Console\Data;

use App\Http\Controllers\Common\CurrencyConverter;
use App\Models\Pivot\Currencies;
use Illuminate\Console\Command;


class GenerateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate statistics';

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
    public function handle()
    {
    }
}
