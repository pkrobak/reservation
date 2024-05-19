<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Collections;

use App\Reservation\Domain\DTO\ClientDto;
use App\Shared\Domain\AbstractCollection;

class ClientsCollection extends AbstractCollection
{
    protected function type(): string
    {
        return ClientDto::class;
    }
}
