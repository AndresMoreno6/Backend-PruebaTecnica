<?php

namespace App\Services;

use GuzzleHttp\Client;
class CambioMonedaService
{
    protected $client;
    protected $apikey;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->apikey = env('EXCHANGERATES_API_KEY');
    }


    public function cambioMoneda($base, $targets)
    {
        $url = "https://api.exchangeratesapi.io/latest?base={$base}
        &symbols={$targets}&apikey={$this->apikey}";
        $response = $this->client->get($url);
        return json_decode($response->getBody(), true);
    }
}
