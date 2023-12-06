<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MovieDatabaseService
{
    private Client $client;
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
    }

    public function apiRequest(string $method, string $url, array $options = [], int $page = 1)
    {
        $url = "$url?page=$page";

        try {
            $response = $this->client->request($method, $url, array_merge([
                'headers' => [
                    'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
                    'X-RapidAPI-Key' => $this->apiKey,
                ],
            ], $options));

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }

}

