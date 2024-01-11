<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_associations',
        'total_competitions',
        'total_games',
        'total_resources',
        'total_users',
    ];
}
