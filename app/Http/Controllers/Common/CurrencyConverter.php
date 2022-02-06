<?php

namespace App\Http\Controllers\Common;

use GuzzleHttp\Client;

class CurrencyConverter
{
    /** @var Client */
    protected Client $client;


    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => getenv('API_ACC_SYS'),
            'timeout'  => 2.0,
            'headers'  => [
                'Authorization' => 'Bearer ' . getenv('API_ACC_SYS_TOKEN')
            ]
        ]);
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrenciesApi()
    {
        $response = $this->client->get('currencies');
        $result = json_decode($response->getBody());
        return $result;
    }

}
