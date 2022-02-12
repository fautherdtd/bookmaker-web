<?php

namespace App\Console\Data;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateBets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:bets';

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
        foreach ($this->request() as $bet) {
            DB::table('bets')
                ->updateOrInsert(
                    ['name' => $bet['name']],
                    ['name' => $bet['name']]
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
        $response = $client->request('get', 'bets');
        return json_decode($response->getBody(), true);
    }
}
