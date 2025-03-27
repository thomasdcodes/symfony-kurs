<?php

declare(strict_types=1);

namespace App\Service\MongoDb;

use MongoDB\Collection;

class AppointmentCollectionFactory
{
    public function __construct(private MongoDbClient $client)
    {
    }

    public function getCollection(): Collection
    {
        return $this->client->getClient()->bsw->appointments;
    }
}