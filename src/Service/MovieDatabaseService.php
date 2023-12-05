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

    public function getUpcomingMovies($page = 1)
    {
        try {
            $response = $this->client->request('GET', "https://moviesdatabase.p.rapidapi.com/titles/x/upcoming?page=$page", [
                'headers' => [
                    'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
                    'X-RapidAPI-Key' => $this->apiKey,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
