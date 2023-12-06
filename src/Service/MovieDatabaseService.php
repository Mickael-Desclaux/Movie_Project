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
        // Construction des paramètres de la requête
        $query = [
            'page' => $page,
        ];
        // Ajouter les paramètres supplémentaires fournis à la requête
        foreach ($options as $key => $value) {
            $query[$key] = $value;
        }
        // Construire l'URL avec les paramètres de requête
        $url = $url . '?' . http_build_query($query);

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

