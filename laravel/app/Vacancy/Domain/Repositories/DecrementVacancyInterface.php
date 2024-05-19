<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Repositories;

interface DecrementVacancyInterface
{
    public function decrement(int $vacancyId, int $count): void;
}
