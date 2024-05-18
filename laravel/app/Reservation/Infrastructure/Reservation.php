<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure;

use App\Reservation\Application\Factories\ReservationFactory;
use App\Vacancy\Infrastructure\Vacancy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read Carbon $date
 * @property-read Collection<Client> $clients
 */
class Reservation extends Model
{
    protected $casts = [
        'date' => 'date:Y-m-d'
    ];
    use HasFactory;
    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    protected static function newFactory(): ReservationFactory
    {
        return ReservationFactory::new();
    }
}
