<?php

namespace App\Vacancy\Infrastructure;

use App\Vacancy\Application\Factories\VacancyFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read Carbon $date
 * @property-read int $count
 * @property-read int $user_id
 */
class Vacancy extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 'count', 'user_id'
    ];

    protected static function newFactory(): Factory
    {
        return VacancyFactory::new();
    }
}
