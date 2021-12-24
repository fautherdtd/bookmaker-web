<?php

namespace App\Console\Data;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\ModelIdentifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data';

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
        Carbon $carbon
    )
    {
        $date = $carbon->now()->toDateString();
        for ($page = 1;/*  */; $page++) {
            $body = $this->request($date, $page);
            $this->model('Bks', [
                'country_id' => $body['country_id'],
                'drop' => $body['drop']['name'],
                'email' => $body['drop']['login_mail'],
                'password' => $body['drop']['password_mail'],
                'address' => $body['drop']['address'],
                'document' => $body['drop']['src_document'],
                'info' => $body['add_info'],
                'accompanying' => $body['drop']['drop_guide']['name'],
                'bet_id' => $body['bet_id'],
            ]);
        }
    }

    /**
     * @param string $model
     * @param array $params
     * @return false
     */
    protected function model(string $model, array $params): bool
    {
        /** @var Model $model */
        $builder = new $model;
        if ($builder instanceof $model) {
            return false;
        }
        return $builder::create($params);
    }

    /**
     * @param string $date
     * @param int $page
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(string $date, int $page = 1): array
    {
        $client = new Client([
            'base_uri' => getenv('API_ACC_SYS'),
            'timeout'  => 2.0,
            'headers'  => [
                'Authorization' => 'Bearer ' . getenv('API_ACC_SYS_TOKEN')
            ]
        ]);
        $response = $client->request('get', 'bk', [
            'query' => [
                'date' => $date,
                'page' => $page
            ]
        ]);
        $content = json_decode($response->getBody(), true);
        return $content['data'];
    }
}
