<?php

namespace App\Console\Data;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\ModelIdentifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import';

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
    public function handle(Carbon $carbon)
    {
//        $date = $carbon->now()->toDateString();
        $date = '2022-01-03';
        for ($page = 1;/*  */; $page++) {
            $body = $this->request($date, $page);
            if (empty($body)) {
                $this->info('Импорт завершен.');
                break;
            }
            foreach ($body as $data) {
                DB::transaction(function () use ($data) {
                    // БК
                    $bk = DB::table('bks')->insertGetId([
                        'country_id' => $data['drop']['country_id'],
                        'drop' => $data['drop']['name'],
                        'email' => $data['drop']['login_mail'],
                        'password' => $data['drop']['password_mail'],
                        'address' => $data['drop']['address'],
                        'document' => $data['drop']['src_document'],
                        'info' => $data['add_info'],
                        'drop_guide' => $data['drop']['drop_guide']['name'],
                        'bet_id' => $data['bet_id'],
                        'sum' => $data['cash'],
                        'currency' => $data['currency']
                    ]);
                    // Платежки
                    if (!empty($data['payments'])) {
                        foreach ($data['payments'] as $payments) {
                            // Транкзации
                            $transactions = [];
                            if (!empty($payments['transactions'])) {
                                foreach ($payments['transactions'] as $transaction) {
                                    array_push($transactions, implode(' ', [
                                        date('d.m.Y', strtotime($transaction['created_at'])) . ' - ',
                                        $transaction['operation'] === 'decrement' ?
                                            'Внесение на БК ' : 'Вывод на Платежку ',
                                        $transaction['sum'] . $transaction['currency']
                                    ]));
                                }
                            }
                            DB::table('payments')->insert([
                                'country_id' => $data['drop']['country_id'],
                                'type_id' => $payments['type_id'],
                                'sum' => $payments['sum'],
                                'currency' => $payments['currency'],
                                'status' => $payments['status'],
                                'drop' => $data['drop']['name'],
                                'bk_id' => $bk,
                                'histories' => json_encode($transactions, true),
                                'created_at' => $payments['created_at']
                            ]);
                        }
                    }
                });
            }
        }
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
