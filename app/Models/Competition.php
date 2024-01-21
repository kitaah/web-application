<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model};

class Competition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identification',
        'slug',
        'budget',
        'status',
        'start_date',
        'end_date',
    ];
}
