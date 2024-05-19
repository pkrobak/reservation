<?php

declare(strict_types=1);

namespace App\Reservation\Domain\DTO;

readonly class ClientDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
    ) {}
}
