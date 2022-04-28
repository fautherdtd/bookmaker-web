<?php

namespace App\Console\Data;

use App\Models\Bks;
use App\Models\Pivot\Bets;
use App\Models\Pivot\BkStories;
use App\Models\Pivot\Countries;
use App\Models\Pivot\Currencies;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:updated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updated data';

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
        $date = $carbon->now()->toDateString();
        for ($page = 1;/*  */; $page++) {
            $body = $this->request($date, $page);
            if (empty($body)) {
                $this->info('Импорт завершен.');
                break;
            }
            foreach ($body as $data) {
                $model = Bks::where('id_external', $data['id'])->first();
                if (empty($model)) {
                    continue;
                }
                $actions = [];
                if ($data['drop']['country_id'] != $model->country_id) {
                    $country = Countries::where('id', $data['drop']['country_id'])->pluck('name');
                    $countryOld = Countries::where('id', $model->country_id)->pluck('name');
                    $actions[] = ["(Обновление с 1 системы) Страна с ". $countryOld ." на {$country}"];
                    $model->email = $data['drop']['country_id'];
                }
                if ($data['drop']['name'] != $model->drop) {
                    $actions[] = ["(Обновление с 1 системы) Дроп с ". $model->drop . " на {$data['drop']['name']}"];
                    $model->drop = $data['drop']['name'];
                }
                if ($data['drop']['login_mail'] != $model->email) {
                    $actions[] = ["(Обновление с 1 системы) Логин с ". $model->email ." на {$data['drop']['login_mail']}"];
                    $model->email = $data['drop']['login_mail'];
                }
                if ($data['drop']['password_mail'] != $model->password) {
                    $actions[] = ["(Обновление с 1 системы) Пароль с " . $model->password . " на {$data['drop']['password']}"];
                    $model->password = $data['drop']['password_mail'];
                }
                if ($data['drop']['address'] != $model->address) {
                    $actions[] = ["(Обновление с 1 системы) Адрес с ". $model->address ." на {$data['drop']['address']}"];
                    $model->address = $data['drop']['address'];
                }
                if ($data['drop']['src_document'] != $model->document) {
                    $actions[] = ["(Обновление с 1 системы) Ссылка на документ с ". $model->document ." на {$data['drop']['src_document']}"];
                    $model->document = $data['drop']['src_document'];
                }
                if ($data['add_info'] != $model->info) {
                    $actions[] = ["(Обновление с 1 системы) Доп.информация с ". $model->info ." на {$data['add_info']}"];
                    $model->info = $data['add_info'] ?? '-';
                }
                if ($data['bet_id'] != $model->bet_id) {
                    $bet = Bets::where('id', $data['bet_id'])->pluck('name');
                    $betOld = Bets::where('id', $data['bet_id'])->pluck('name');
                    $actions[] = ["(Обновление с 1 системы) БК с ". $betOld ." на {$bet}"];
                    $model->bet_id = $data['bet_id'];
                }
                if ($data['cash'] != $model->sum_external) {
                    $actions[] = ["(Обновление с 1 системы) Сумма изменена с ". $model->sum_external ." на {$data['cash']}"];
                    $model->sum = $data['cash'];
                }
                if ($data['currency'] != $model->currency) {
                    $currency = Currencies::where('code', $data['currency'])->pluck('name');
                    $currencyOld = Currencies::where('code', $model->currency)->pluck('name');
                    $actions[] = ["(Обновление с 1 системы) Валюта изменена с ". $currencyOld ." на {$currency}"];
                    $model->currency = $data['currency'];
                }
                $model->touch_updated_at = $carbon->now();
                $model->save();
                foreach (array_values($actions) as $action) {
                    BkStories::create([
                        'bk_id' => $model->id,
                        'action' => implode('', $action),
                        'user' => 1
                    ]);
                }
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
