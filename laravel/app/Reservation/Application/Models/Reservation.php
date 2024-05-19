<?php

declare(strict_types=1);

namespace App\Reservation\Application\Models;

use App\Reservation\Application\Factories\ReservationFactory;
use App\Vacancy\Application\Models\Vacancy;
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
    use HasFactory;
    protected $casts = [
        'date' => 'date:Y-m-d'
    ];
    protected $fillable = ['vacancy_id', 'date'];
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
