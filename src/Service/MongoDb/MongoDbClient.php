<?php

declare(strict_types=1);

namespace App\Service\MongoDb;

use MongoDB\Client;

class MongoDbClient
{
    private Client $client;

    public function __construct(private string $uri)
    {
        $this->client = new Client($this->uri);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}