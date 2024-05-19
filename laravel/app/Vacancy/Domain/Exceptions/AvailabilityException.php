<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Exceptions;

use App\Vacancy\Domain\Collections\CarbonCollection;
use Exception;
use Throwable;

class AvailabilityException extends Exception
{
    public function __construct(
        protected CarbonCollection $invalidDates,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct('Some dates are unavailable for given period', $code, $previous);
    }

    public function getInvalidDates(): CarbonCollection
    {
        return $this->invalidDates;
    }
}
