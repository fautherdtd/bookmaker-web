<?php

namespace App\Console\Data;

use App\Http\Controllers\Common\CurrencyConverter;
use App\Models\Pivot\Currencies;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GeneratePaymentType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:payments-type';

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
    public function handle() {
        $bar = $this->output->createProgressBar(
            count($this->request())
        );
        foreach ($this->request() as $type) {
            DB::table('currencies')
                ->updateOrInsert(
                    ['title' => $type->title],
                    ['title' => $type->title]
                );
            $bar->advance();
        }
        $bar->finish();
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(): array
    {
        $client = new Client([
            'base_uri' => getenv('API_ACC_SYS'),
            'timeout'  => 2.0,
            'headers'  => [
                'Authorization' => 'Bearer ' . getenv('API_ACC_SYS_TOKEN')
            ]
        ]);
        $response = $client->request('get', 'payments-type');
        $content = json_decode($response->getBody(), true);
        return $content;
    }
}
