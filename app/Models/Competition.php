<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'identification',
        'slug',
        'budget',
        'status',
        'start_date',
        'end_date',
    ];
}
