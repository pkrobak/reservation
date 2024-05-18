<?php

namespace App\Vacancy\Infrastructure;

use App\Vacancy\Application\Factories\VacancyFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;
    protected $fillable = [
        'start', 'end', 'count', 'user_id'
    ];

    protected static function newFactory(): Factory
    {
        return VacancyFactory::new();
    }
}
