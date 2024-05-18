<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure;

use App\Reservation\Application\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read string $first_name
 * @property-read string $last_name
 */
class Client extends Model
{
    use HasFactory;

    protected static function newFactory(): ClientFactory
    {
        return new ClientFactory();
    }
}
