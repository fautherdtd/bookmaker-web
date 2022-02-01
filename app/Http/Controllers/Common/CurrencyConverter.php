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
            'base_uri' => 'https://currency-converter5.p.rapidapi.com/currency/',
            'timeout'  => 2.0,
        ]);
    }

    /**
     * @param string $currency
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function convert(string $currency)
    {
        $response = $this->client->get('convert', [
            'headers' => [
                'x-rapidapi-key' => getenv('RAPIDAPI_KEY'),
                'x-rapidapi-host' => getenv('RAPIDAPI_HOST')
            ],
            'query' => [
                'format' => 'json',
                'from' => 'EUR',
                'to' => $currency,
                'amount' => '1.00'
            ]
        ]);
        $result = json_decode($response->getBody());
        return $result->rates;
    }
}
